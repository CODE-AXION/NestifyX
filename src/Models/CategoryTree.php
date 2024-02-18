<?php

namespace CodeAxion\NestifyX\Models;

use Illuminate\Database\Eloquent\Model;


class CategoryTree extends Model 
{
    protected $guarded = [];
    
    public function __construct(array $attributes = [])
    {
        $this->table = config('nestifyx.tables.name') ?? 'categories';
    }

    public function getAllChildrenIds()
    {
        $allChildrenIds = [$this->id];

        $categories = \DB::table($this->table)->select('id', 'parent_id', 'name')->get();

        $this->collectChildrenIds($categories, $allChildrenIds,$this->id);

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
}