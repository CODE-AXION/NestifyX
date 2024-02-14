
# NestifyX Package

## Overview


The NestifyX package provides functionality for managing categories or nested elements within your application.
> Organize Your Categories with Ease.

## Features
1. **Calculate Depth:** The package includes a method `calculateDepth($category, $categories)` that calculates the depth of a given category within a hierarchical structure.
   
2. **Build Tree:** Another method `buildTree($flatCategories, $parentId = null, $depth = 0)` constructs a hierarchical tree from a normal collection of categories. It arranges categories into a tree structure based on their parent-child relationships, assigning each category a depth level.

3. **Append Category and Children:** This package offers a method `appendCategoryAndChildren($category, $categories, &$sortedCategories, $depth = 0)` to append a category and its children recursively to a sorted collection. This is particularly useful for creating nested lists or trees without hierarchical structure.

## Usage
To utilize the NestifyX package in your application, follow these steps:

1. **Installation**: Install the NestifyX package via Composer:
 
 ```bash
   composer require your-vendor/NestifyX
 ```
2. Integration: Include the Nestify package in your project files by importing it as needed:


```php
   use YourVendor\Nestify\Nestify;
```

3. Calculate Depth:
  ```php
    $depthInfo = Nestify::calculateDepth($category, $categories);
    // $depthInfo[0] contains the depth
    // $depthInfo[1] contains the font-weight class indicating if the category has children
  ```

4. Build Tree:

  ```php
    $tree = Nestify::buildTree($flatCategories);
    // $tree contains the hierarchical tree structure of categories
  ```

5. Sort structure:

  ```php
    $sortedCategories = collect();
    Nestify::appendCategoryAndChildren($category, $categories, $sortedCategories);
    // $sortedCategories now contains the sorted collection of categories and their children
  
  ```


License
=======

Copyright (c) 2024 CODE AXION

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
