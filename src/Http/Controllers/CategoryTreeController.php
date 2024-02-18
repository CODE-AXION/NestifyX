<?php

namespace CodeAxion\NestifyX\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use CodeAxion\NestifyX\Models\CategoryTree;

class CategoryTreeController extends Controller
{
    public function updateCategoryTree()
    {
        // dump(request('category_edit'));
        // dd(request()->all());
        
        if(request()->has('delete_category')){

            $category = CategoryTree::where('id',request('delete_category')['id'])->first();

            $categories = CategoryTree::whereIn('id',$category->getAllChildrenIds())->delete();
            
            return response()->json(['message' => 'category deleted']);
        }
        if(request()->has('category_edit'))
        {
            $category = CategoryTree::where('id',request('category_edit')['id'])->first()->update([
                'name' => request('category_edit')['text'],
            ]);

            return response()->json(['success' => true]);
        }
        if(request()->has('create_category'))
        {
        
            $position = CategoryTree::where('parent_id', request('create_category')['id'] )->count();
            $category = CategoryTree::create([
                'name' => request('create_category')['text'],
                'parent_id' => request('create_category')['id']
            ]);

            return response()->json(['id' => $category->id]);
        }

        \CodeAxion\NestifyX\Http\Services\CategoryTreeUpdater::update(request('category_tree'));

        return 'category order saved';
    }

    public function treeCategory()
    {
        $categories = CategoryTree::orderByRaw('-position DESC')->get();

        return new \CodeAxion\NestifyX\Responses\CategoryTreeResponse($categories);
    }
}