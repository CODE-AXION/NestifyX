<?php

namespace CodeAxion\NestifyX;

use Illuminate\Support\Collection;

class NestifyX
{
    /**
     * The string used for indentation.
     *
     * @var string
     */
    public string $indent = '    ';

    /**
     * The parent ID column name.
     *
     * @var string
     */
    public string $parent_id ;

    /**
     * The relation name.
     *
     * @var string
     */
    public string $relationName ;

    /**
     *  constructor.
     *
     * @param string $parent_id    The parent ID column name.
     * @param string $relationName The relation name.
     */
    public function __construct(string $parent_id = 'parent_id', string $relationName = 'subcategories') {
        $this->parent_id = $parent_id;
        $this->relationName = $relationName;
    }
  

    /**
     * sort categories and their children recursively.
     *
     * @param mixed   $categories The list of categories.
     * @param int     $depth      The depth of the category.
     * @param int|null $parent_id  The parent ID to start with, null for root.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function sortChildren(mixed $categories, ?int $parent_id = null,int $depth = 0 ): Collection
    {
        $sortedCategories = collect();

        foreach ($categories as $category) {
            if ($category[$this->parent_id] === $parent_id) {
                $category['depth'] = str_repeat($this->indent, $depth);
                $sortedCategories->push($category);
                $sortedCategories = $sortedCategories->merge($this->sortChildren($categories,$category['id'],$depth + 1));
            }
        }

        return $sortedCategories;
    }

    /**
     * Calculate the depth of a category.
     *
     * @param mixed $categories The list of categories.
     * @param mixed $category  The category object.
     * 
     * @return array An array containing the depth and if it has children.
     */
    public function calculateDepth(mixed $categories, mixed $category): array
    {
        $depth = 0;
        $parentId = $category->{$this->parent_id};
        $hasChildren = $categories->where($this->parent_id, $category->id)->isNotEmpty();
    
        if ($parentId !== null) {
            $parentCategory = $categories->first(function ($item) use ($parentId) {
                return $item->id === $parentId;
            });
    
            if ($parentCategory) {
                list($parentDepth, $parentHasChildren) = $this->calculateDepth($categories,$parentCategory);
                $depth = 1 + $parentDepth;
            }
        }
    
        return [$depth, $hasChildren];
    }

    /**
     * Nest the tree of categories.
     *
     * @param mixed $categories The list of categories.
     * @param int|null                              $parentId   The parent ID to start with, null for root.
     * @param int                                   $depth      The depth of the category.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function nestTree(mixed $categories, ?int $parentId = null, int $depth = 0): Collection
    {
        if (!($categories instanceof Collection)) {
            $categories = new Collection($categories);
        }
        
        $tree = [];

        foreach ($categories as $category) {
            if ($category[$this->parent_id] === $parentId) { // Access using array access notation
                $category['depth'] = $depth;
                $category[$this->relationName] = $this->nestTree($categories, $category['id'], $depth + 1);
                $tree[] = $category;
            }
        }

        return collect($tree);
    }

    /**
     * Generate breadcrumbs for a given category.
     *
     * @param mixed                                $collection   The list of categories.
     * @param int|null                             $parent_id    The parent ID to start with, null for root.
     * @param string                               $column       The column to use for breadcrumb names.
     * @param int                                  $level        The current depth level.
     * @param array                                $flattened    Reference to the flattened breadcrumbs array.
     * @param string|null                          $parentString The parent string for building breadcrumbs.
     * 
     * @return array The generated breadcrumbs.
     */
    public function generateBreadCrumbs(mixed $collection = null, ?int $parent_id = null, string $column = 'name', int $level = 0, array &$flattened = [], ?string $parentString = null): array
    {
        foreach ($collection as $item) {

            if($item[$this->parent_id] == $parent_id)
            {

                if ($parentString) {
                    $itemString = ($parentString === true) ? $item?->{$column} : $parentString . $this->indent . $item?->{$column};
                } else {
                    $itemString = str_repeat($this->indent, $level) . $item->{$column};
                }
    
                $flattened[$item->id] = $itemString;
    
                $this->generateBreadCrumbs($collection, $item['id'], $column, $level + 1, $flattened, $itemString);
            }
        }

        return $flattened;
    }

    /**
     * Prepend an item to an array with a specific key.
     *
     * @param array  $array The array to prepend to.
     * @param mixed  $item  The item to prepend.
     * @param string $key   The key to use for the item.
     * 
     * @return array The prepended array.
     */
    function prependWithKeys(array $array, $item, $key): array
    {
        $array = array_reverse($array, true);
        $array[$key] = $item;
        return array_reverse($array, true);
    }

    /**
     * Get the breadcrumbs for a given category.
     *
     * @param mixed  $categories The list of categories.
     * @param int    $categoryId The ID of the target category.
     * @param string $column     The column to use for breadcrumb names.
     * @param array  $breadcrumbs Reference to the breadcrumbs array.
     * 
     * @return array The generated breadcrumbs.
     */
    public function getParentBreadcrumbs(mixed $categories, int $categoryId, string $column = 'name', array $breadcrumbs = []): array
    {
        foreach ($categories as $category) {
            if ($category['id'] == $categoryId) {

                $breadcrumbs = $this->prependWithKeys($breadcrumbs, $category[$column], $category['id']);

                if (isset($category[$this->parent_id])) {
     
                    return $this->getParentBreadcrumbs($categories, $category[$this->parent_id], $column, $breadcrumbs);
                }
    
                return $breadcrumbs;
            }
        }
        return [];
    }
    

    /**
     * List categories flattened with indentation.
     *
     * @param mixed  $categories  The list of categories.
     * @param int|null $parentId   The parent ID to start with, null for root.
     * @param string $columnName  The column to use for category names.
     * @param int    $depth       The current depth level.
     * 
     * @return \Illuminate\Support\Collection The flattened categories.
     */
    public function listsFlattened(mixed $categories, ?int $parentId = null, string $columnName = 'name', int $depth = 0): Collection
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

    /**
     * Convert a multi-dimensional array to a collection.
     *
     * @param mixed $collection The collection or array to convert.
     * 
     * @return \Illuminate\Support\Collection The converted collection.
     */
    public function arrayToCollection($collection): Collection
    {
        return $collection->map(function ($value) {
            if (is_array($value) || is_object($value)) {
                return $this->arrayToCollection(collect($value));
            }
            return $value;
        });
    }


    /**
     * Set the indentation string.
     *
     * @param string $indent The string used for indentation.
     * 
     * @return self
     */
    public function setIndent(string $indent): self
    {
        $this->indent = $indent;
        return $this;
    }

    /**
     * Collect parent IDs for a given category.
     *
     * @param mixed  $categories The list of categories.
     * @param int    $targetId   The ID of the target category.
     * @param string $key        The key column name for IDs.
     * @param string $name       The name column to use for breadcrumbs.
     * @param array  $breadcrumbs Reference to the breadcrumbs array.
     * 
     * @return array The collected parent IDs.
     */
    public function collectParentIds(mixed $categories, int $targetId, string $key = 'id', string $name = 'id', array $breadcrumbs = []): array
    {
        foreach ($categories as $category) {
            if ($category['id'] == $targetId) {
            
                $breadcrumbs[$category[$key]] = $category[$name]; 

                if (isset($category[$this->parent_id])) {

                    return $this->collectParentIds($categories, $category[$this->parent_id], $key, $name, $breadcrumbs);
                }
                
                return $breadcrumbs;
            }
        }

        return [];
    }

    /**
     * Collect child IDs of a parent category.
     *
     * @param mixed  $categories The list of categories.
     * @param int    $parent_id  The parent ID to start with.
     * 
     * @return array The collected child IDs.
     */
    public function collectChildIds(mixed $categories, int $parent_id): array
    {
        $allChildrenIds = [$parent_id];

        $this->collectChildrenIds($categories, $allChildrenIds, $parent_id);

        return $allChildrenIds;
    }

    /**
     * function to collect children IDs.
     *
     * @param mixed $categories    The list of categories.
     * @param array $allChildrenIds Reference to the all children IDs array.
     * @param int   $parent_id     The parent ID to start with.
     * 
     * @return void
     */
    protected function collectChildrenIds(mixed $categories, array &$allChildrenIds, ?int $parent_id = null)
    {
        $children = collect($categories)->filter(function ($item) use ($parent_id) {
            return $item->{$this->parent_id} == $parent_id;
        });

        foreach ($children as $child) {
            $allChildrenIds[] = $child->id;
            $this->collectChildrenIds($categories, $allChildrenIds, $child->id);
        }
    }

    /**
     * Generate breadcrumbs for the current category.
     *
     * @param mixed $categories The list of categories.
     * @param int   $targetId   The ID of the target category.
     * @param string $column    The column to use for breadcrumb names.
     * 
     * @return array The generated breadcrumbs.
     */
    public function generateCurrentBreadCrumbs(mixed $categories, int $targetId, string $column = 'name'): array
    {
        $breadcrumbs = [];

        $parentIds = $this->collectParentIds($categories, $targetId, 'id');

        $parentCategories = collect($categories)->whereIn('id', $parentIds);

        foreach ($parentCategories as $category) {
            $breadcrumbs[$category['id']] = [
                'name' => $category[$column],
                'category' => $category->toArray(),
            ];
        }

        return $breadcrumbs;
    }
}
