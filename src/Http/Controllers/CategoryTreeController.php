<?php

namespace CodeAxion\NestifyX\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use CodeAxion\NestifyX\Models\CategoryTree;

class CategoryTreeController extends Controller
{
    public function updateCategoryTree()
    {
        try {
            if(request()->has('delete_category')){
    
                $category = CategoryTree::where('id',request('delete_category')['id'])->first();
    
                $categories = CategoryTree::whereIn('id',$category->getAllChildrenIds())->delete();
                
                return response()->json(['success' => true, 'message' => 'category deleted']);
            }
            if(request()->has('category_edit'))
            {
                $category = CategoryTree::where('id',request('category_edit')['id'])->first()->update([
                    'name' => request('category_edit')['text'],
                ]);
    
                return response()->json(['success' => true,'message' => 'category updated']);
            }
            if(request()->has('create_category'))
            {
            
                $position = CategoryTree::where('parent_id', request('create_category')['id'] )->count();
                $category = CategoryTree::create([
                    'name' => request('create_category')['text'],
                    'parent_id' => request('create_category')['id']
                ]);
    
                return response()->json(['success' => true,'id' => $category->id]);
            }
    
            \CodeAxion\NestifyX\Http\Services\CategoryTreeUpdater::update(request('category_tree'));
    
            return response()->json(['success' => true,'message' => 'category order updated']);

        } catch (\Throwable $th) {

             return response()->json(['success' => false,'message' => $th->getMessage()],422);
        }
    }

    public function treeCategory()
    {
        try {
            $categories = CategoryTree::orderByRaw('-position DESC')->get();
    
            return new \CodeAxion\NestifyX\Responses\CategoryTreeResponse($categories);

        } catch (\Throwable $th) {
            
            return response()->json(['success' => false,'message' => $th->getMessage()],422);
        }
    }
}