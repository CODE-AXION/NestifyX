<?php

namespace CodeAxion\NestifyX;

class NestifyX
{
    public $indent = '    ';
    protected $flattened = [];
  

    public function appendCategoryAndChildren($categories, $depth = 0, $parent_id = null)
    {
        $sortedCategories = collect();

        foreach ($categories as $category) {
            if ($category->parent_id === $parent_id) {
                $category->depth = $depth;
                $sortedCategories->push($category);
                $sortedCategories = $sortedCategories->merge($this->appendCategoryAndChildren($categories, $depth + 1, $category->id));
            }
        }

        return $sortedCategories;
    }

    public function calculateDepth($category, $categories) {
        $depth = 0;
        $parentId = $category->parent_id;
        $hasChildren = $categories->where('parent_id', $category->id)->isNotEmpty();
    
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
        $tree = [];

        foreach ($categories as $category) {
            if ($category->parent_id === $parentId) {
                $category->depth = $depth + 1;
                $category->subcategories = $this->nestTree($categories, $category->id, $depth + 1);
                $tree[] = $category;
            }
        }

        return  $tree;
    }

    public function generateBreadCrumbs($collection = null,string $column = 'name', int $level = 0, array &$flattened = [], ?string $parentString = null): array
    {
        foreach ($collection as $item) {
            if ($parentString) {
                $itemString = ($parentString === true) ? $item?->{$column} : $parentString . $this->indent . $item?->{$column};
            } else {
                $itemString = str_repeat($this->indent, $level) . $item->{$column};
            }

            $flattened[$item->id] = $itemString;

            if (!empty($item->subcategories)) {
                $this->generateBreadCrumbs($column, collect($item->subcategories), $level + 1, $flattened, $itemString);
            }
        }

        return $flattened;
    }

    public function listsFlattened($tree, $columnName = 'name', $indent = '', $depth = 0)
    {
        $flattened = [];
       
        foreach ($tree as $category) {
    
            $flattened[$category->id] = $indent . $category->{$columnName};
            if (!empty($category->subcategories)) {
                $flattened = array_merge($flattened, $this->listsFlattened($category->subcategories, $columnName, str_repeat($this->indent,$depth), $depth+1));
            }
        }

        return $flattened;
    }

    public function setIndent($indent)
    {
        $this->indent = $indent;
        return $this;
    }
}
