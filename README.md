
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
   composer require codeaxion/NestifyX
 ```
2. Integration: Include the Nestify package in your project files by importing it as needed:


```php
   use CodeAxion\NestifyX\NestifyX;
```

#### Convert Normal Eloquent Collection/Array To Nested Tree

  ```php
   $categories = Category::orderByRaw('-position DESC')->get();

   $nestify = new NestifyX('parent_id','subcategories');
   $categories = $nestify->nestTree($categories);
  ```

#### Sort Children without converting it to tree

```php
   $categories = Category::orderByRaw('-position DESC')->get();

   $nestify = new NestifyX('parent_id','subcategories');
   $categories = $nestify->setIndent('|--')->sortChildren($categories);

   // In views

   @foreach($categories as $category)
    <div> {{$category->depth}} {{$category->name}} </div>
   @endforeach
```

#### Sort Children without converting it to tree (flattened version - usefull for dropdowns)

```php
    $categories = \App\Models\Category::orderByRaw('-position DESC')->get();

    $nestify = new NestifyX('parent_id','subcategories');
    $categories = $nestify->nestTree($categories);
    $categories = $nestify->setIndent('|--')->listsFlattened($categories);

  //Result:
  #items: array:7 [▼
    4 => "Electronics"
    5 => "|--Laptops"
    9 => "|--|--All Laptops"
    7 => "|--Mobiles"
    10 => "|--|--All Mobiles"
    8 => "|--Headphones"
    11 => "|--|--All Headphones"
  ]
```

#### generate breadcrumbs for all categories

```php
  $categories = \App\Models\Category::orderByRaw('-position DESC')->get();

    $nestify = new NestifyX('parent_id','subcategories');
    $categories = $nestify->nestTree($categories);
    $categories = $nestify->setIndent(' \ ')->generateBreadCrumbs($categories);

    //Result:
    
    array:7 [▼ // routes\web.php:27
      4 => "Electronics"
      5 => "Electronics \ Laptops"
      9 => "Electronics \ Laptops \ All Laptops"
      7 => "Electronics \ Mobiles"
      10 => "Electronics \ Mobiles \ All Mobiles"
      8 => "Electronics \ Headphones"
      11 => "Electronics \ Headphones \ All Headphones"
    ]
```


#### generate current breadcrumbs 
```php

    $categories = Category::get();

    $nestify = new NestifyX('parent_id','subcategories');
   
    $categories = $nestify->generateCurrentBreadCrumbs($categories,11);

    array:2 [▼ // routes\web.php:34
      4 => array:2 [▼
        "name" => "Electronics"
        "category" => array:8 [▼
          "id" => 4
          "name" => "Electronics"
          "parent_id" => null
          "created_at" => "2024-02-18T13:37:52.000000Z"
          "updated_at" => "2024-02-22T16:40:00.000000Z"
        ]
      ]
      5 => array:2 [▼
        "name" => "Laptops"
        "category" => array:8 [▼
          "id" => 5
          "name" => "Laptops"
          "parent_id" => 4
          "created_at" => "2024-02-18T13:43:26.000000Z"
          "updated_at" => "2024-02-22T16:40:00.000000Z"
        ]
      ]
    ]
```

#### Get all parent ids of a child
```php

    $categories = Category::get();

    $nestify = new NestifyX('parent_id','subcategories');
   
    $categories = $nestify->collectParentIds($categories,11);

```

#### Get all child ids of a parent
```php

    $categories = Category::get();

    $nestify = new NestifyX('parent_id','subcategories');
   
    $categories = $nestify->collectChildIds($categories,4);

```




### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email codeaxoin77@gmail.com instead of using the issue tracker.

## Credits

-   [code-axion](https://github.com/code-axion)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
