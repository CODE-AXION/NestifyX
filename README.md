
<h2 align=center> NestifyX Package </h2>

<h2 align=center>
<img align=center src="https://github.com/CODE-AXION/NestifyX/assets/97381867/13f078a2-a179-4b06-8a2b-813a2490fcec" />
 </h2>
 
## Overview


The NestifyX package provides functionality for managing categories or nested elements within your application.
> Organize Your Categories with Ease.
> 
<h2 align=center>
<img align=center src="https://github.com/CODE-AXION/NestifyX/assets/97381867/c8e1f213-9b9f-4e8c-ad23-a88aadc204e8" />
 </h2>

## Features
1. **Category Tree Management:** This Module includes Category Management with the Ability of changing its position, you just have to include a button component and thats it .
   
2. **Recursion Methods:** This Module includes various methods to play with recursions, like generating tree, fetch Children/Parent ids, generate breadcrumbs, show tree view in dropdown etc...  


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



### Upcoming Feature
> Add Nestable2 plugin feature in Categories
<br>
New features suggestions are always welcome

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

