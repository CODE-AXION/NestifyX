<?php


use Illuminate\Support\Facades\Route;
use CodeAxion\NestifyX\Http\Controllers\CategoryTreeController;

Route::put('/update-categories/tree', [CategoryTreeController::class, 'updateCategoryTree'])->name('categories.tree.update');
Route::get('/view-categories/tree', [CategoryTreeController::class, 'treeCategory'])->name('categories.tree');