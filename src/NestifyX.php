<?php

namespace CodeAxion\NestifyX;

use Illuminate\Support\Collection;

class NestifyX
{
    public $indent = '    ';
    protected $flattened = [];

    public $parent_id ;
    public $relationName ;

    public function __construct($parent_id,$relationName) {
        $this->parent_id = $parent_id;
        $this->relationName = $relationName;
    }
  

    public function appendCategoryAndChildren($categories, $depth = 0, $parent_id = null)
    {
       
        $sortedCategories = collect();

        foreach ($categories as $category) {
            if ($category[$this->parent_id] === $parent_id) {
                $category['depth'] = str_repeat($this->indent,$depth);
                $sortedCategories->push($category);
                $sortedCategories = $sortedCategories->merge($this->appendCategoryAndChildren($categories, $depth + 1, $category['id']));
            }
        }

        return $sortedCategories;
    }

    public function calculateDepth($category, $categories) 
    {
        $depth = 0;
        $parentId = $category->{$this->parent_id};
        $hasChildren = $categories->where($this->parent_id, $category->id)->isNotEmpty();
    
        if ($parentId !== null) {
            $parentCategory = $categories->first(function ($item) use ($parentId) {
                return $item->id === $parentId;
            });
    
            if ($parentCategory) {
                list($parentDepth, $parentHasChildren) = $this->calculateDepth($parentCategory, $categories);
                $depth = 1 + $parentDepth;
            }
        }
    
        return [$depth, $hasChildren];
    }


    public function nestTree($categories, $parentId = null, $depth = 0)
    {
        if (!($categories instanceof Collection)) {
            $categories = new Collection($categories);
        }
        
        $tree = [];

        foreach ($categories as $category) {
            if ($category[$this->parent_id] === $parentId) { // Access using array access notation
                $category['depth'] = $depth + 1;
                $category['subcategories'] = $this->nestTree($categories, $category['id'], $depth + 1);
                $tree[] = $category;
            }
        }

        
        return collect($tree);
    }

    public function generateBreadCrumbs($collection = null,$parent_id = null,string $column = 'name', int $level = 0, array &$flattened = [], ?string $parentString = null): array
    {
        foreach ($collection as $item) {

            if($item['parent_id'] == $parent_id)
            {

                if ($parentString) {
                    $itemString = ($parentString === true) ? $item?->{$column} : $parentString . $this->indent . $item?->{$column};
                } else {
                    $itemString = str_repeat($this->indent, $level) . $item->{$column};
                }
    
                $flattened[$item->id] = $itemString;
    
                $this->generateBreadCrumbs($collection,$item['id'], $column, $level + 1, $flattened, $itemString);
            }
        }

        return $flattened;
    }

    function prependWithKeys($array, $item, $key)
    {
        $array = array_reverse($array, true);
        $array[$key] = $item;
        return array_reverse($array, true);
    }

    public function getParentBreadcrumbs($categories, $categoryId, $column = 'name', $breadcrumbs = [])
    {
        foreach ($categories as $category) {
            if ($category['id'] == $categoryId) {
                // Found the category, add its breadcrumb
                $breadcrumbs = $this->prependWithKeys($breadcrumbs, $category[$column], $category['id']);
                // Check if this category has a parent
                if (isset($category['parent_id'])) {
                    // Recursive call to find parent breadcrumbs
                    return $this->getParentBreadcrumbs($categories, $category['parent_id'], $column, $breadcrumbs);
                }
                    // No parent, return the breadcrumbs
                return $breadcrumbs;
               
            }
        }
        // Category not found
        return [];
    }
    

    // public function listsFlattened($tree, $columnName = 'name', $depth = 0)
    // {
    //     $flattened = [];
    
    //     foreach ($tree as $category) {

    //         $flattened[$category->id] = str_repeat($this->indent, $depth) . $category->{$columnName};
    //         if (!empty($category->subcategories)) {
    //             // Recursively flatten subcategories and merge them into $flattened with updated depth
    //             $flattened = $flattened + $this->listsFlattened($category->subcategories, $columnName, $depth + 1);
    //         }
    //     }

    //     return $flattened;
    // }

    public function listsFlattened($categories, $parentId = null, $columnName = 'name', $depth = 0)
    {
        $flattened = [];

        foreach ($categories as $category) {
            if ($category[$this->parent_id] === $parentId) {
                $indentation = str_repeat($this->indent, $depth);
                $flattened[$category['id']] = $indentation . $category[$columnName];
                $nestedFlattened = $this->listsFlattened($categories, $category['id'], $columnName, $depth + 1);

                foreach ($nestedFlattened as $key => $value) {
                    $flattened[$key] = $value;
                }
            }
        }

        return collect($flattened);
    }

    public function arrayToCollection($collection)
    {
        return $collection->map(function ($value) {
            if (is_array($value) || is_object($value)) {
                return $this->arrayToCollection(collect($value));
            }
            return $value;
        });
    }


    

    public function setIndent($indent)
    {
        $this->indent = $indent;
        return $this;
    }

    public function collectParentIds($categories, $targetId, $key = 'id',$name = 'id', $breadcrumbs = [])
    {
        foreach ($categories as $category) {
            if ($category['id'] == $targetId) {
                // Found the target category
                $breadcrumbs[$category[$key]] = $category[$name]; // Add its ID to breadcrumbs


                if (isset($category['parent_id'])) {
                    // If it has a parent, recursively find parent breadcrumbs
                    return $this->collectParentIds($categories, $category['parent_id'], $key,$name, $breadcrumbs);
                }
                
                // No parent, this is the top-level category
                return $breadcrumbs;
            }
        }

        // If category is not found, return empty breadcrumbs
        return [];
    }

    public function collectChildIds($categories,$parent_id)
    {
        $allChildrenIds = [$parent_id];

        $this->collectChildrenIds($categories, $allChildrenIds,$parent_id);

        return $allChildrenIds;
    }

    protected function collectChildrenIds($categories, &$allChildrenIds, $parent_id = null)
    {
        $children = $categories->filter(function ($item) use ($parent_id) {
            return $item->parent_id == $parent_id;
        });

        foreach ($children as $child) {
            $allChildrenIds[] = $child->id;
            $this->collectChildrenIds($categories, $allChildrenIds, $child->id);
        }
    }

    public function generateCurrentBreadCrumbs($categories, $targetId, $column = 'name')
    {
        $breadcrumbs = [];

        // Collect parent IDs
        $parentIds = $this->collectParentIds($categories, $targetId, 'id');

        // Fetch corresponding categories
        $parentCategories = $categories->whereIn('id', $parentIds);

        // Generate breadcrumbs with names and URLs
        foreach ($parentCategories as $category) {
            $breadcrumbs[$category['id']] = [
                'name' => $category[$column],
                'category' => $category->toArray(),
            ];
        }

        return $breadcrumbs;
    }
}
