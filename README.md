
# NestifyX Laravel Package 

<h2>
  <img  src="https://github.com/CODE-AXION/NestifyX/assets/97381867/13f078a2-a179-4b06-8a2b-813a2490fcec" />
</h2>
 
## Overview


The NestifyX Laravel package provides features for managing categories and manipulate nested elements within your application using recursive methods.
> Organize Your Categories with Ease.
<br>
<h2>
    <img  src="https://github.com/CODE-AXION/NestifyX/assets/97381867/c8e1f213-9b9f-4e8c-ad23-a88aadc204e8" />
</h2>

## Features
1. **Category Tree Management:** This Module includes Category Management with the Ability of changing its position using drag and drop feature, you just have to include a button component and that's it .
   
2. **Recursion Methods:** This Module includes various methods to play with recursions, like generating tree, fetch Children/Parent ids, generate breadcrumbs, show tree view in dropdown etc... 

3. **Performance:** Will do all your work in a single query.

#### Required Dependencies To Run Js Tree pop up
>AlpineJs, Jquery, Jstree 

<a href="https://youtu.be/XwGvh_4aXvA">Demo Video</a>

## Installation
To utilize the NestifyX package in your application, follow these steps:

1. **Installation**: Install the NestifyX package via Composer:
 
 ```bash
   composer require codeaxion/nestifyx
 ```

2. Add Your Required Dependencies via CDN (without these dependencies jstree wont work)

```js
  //only optional if you have already have alpine js and tailwindcss package installed
  <script src="//unpkg.com/alpinejs" defer></script> 
  <script src="https://cdn.tailwindcss.com"></script>

  //jquery in header
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  //jstree scripts and css (add styles in header and scripts in body)
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />


```
3. Run necessary Migration 
> Will add position column in your categories table for ordering
```php
  php artisan migrate;
```

4. Integration: Include the Nestify Facade

```php
  use CodeAxion\NestifyX\Facades\NestifyX;
```
Thats's it Your setup is over

## Optional 

5. (Optional) Publish config file if you have different table name

```
php artisan vendor:publish --provider="CodeAxion\NestifyX\NestifyXServiceProvider" --tag="config"

```

6. (Optional) Publish migration if you want

```
php artisan vendor:publish --provider="CodeAxion\NestifyX\NestifyXServiceProvider" --tag="migrations"

```




## Usage

### Add Category Module Slider
> After adding this blade component click on the button named category tree to open category module slider  
```html
  <x-nestifyx::category-tree-alpine />
```


#### Convert Normal Eloquent Collection/Array To Nested Tree

  ```php
   use CodeAxion\NestifyX\Facades\NestifyX;

   $categories = Category::orderByRaw('-position DESC')->get();

   $categories = NestifyX::nestTree($categories);
  ```

#### Sort Children without converting it to tree

```php
  use CodeAxion\NestifyX\Facades\NestifyX;

  $categories = Category::orderByRaw('-position DESC')->get(); //Sort by children with it's position (RECOMMENDED after sorting is done by jstree)
  //OR
  $categories = Category::get() //Sort by only children;

  //will return original database collection 
  $categories = NestifyX::setIndent('|--')->sortChildren($categories); //fetch all categories and subcategories
  //OR
  $categories = NestifyX::setIndent('|--')->sortChildren($categories,5) //Pass different category id if you want their children of (refer to 2nd example)

  // In view
  @foreach($categories as $category)
  <div> {{$category->indent}} {{$category->name}} </div>
  @endforeach

  //Will result
  /** 
  Electronics
  |-- Mobiles
  |-- |-- All Mobiles
  |-- Headphones
  |-- |-- All Headphones
  |-- Gaming
  |-- |-- Gaming Laptops
  |-- |-- Business Laptops
  |-- Laptops
  |-- |-- All Laptops
  |-- |-- Apple Laptops
  |-- |-- Microsoft Laptops
  */
```

#### Flatten Children (- useful for dropdowns)

```php
    use CodeAxion\NestifyX\Facades\NestifyX;

    $categories = \App\Models\Category::orderByRaw('-position DESC')->get();

    //fetch all categories and subcategories (CASE 1)
    $categories = NestifyX::setIndent('|--')->listsFlattened($categories); 

    //OR
    //pass different category id if you want their children of (CASE 2)
    $categories = NestifyX::setIndent('|--')->listsFlattened($categories,5);
    //OR
    ////if your column name is different (default will be name)
    $categories = NestifyX::setIndent('|--')->setColumn('title')->listsFlattened($categories); 

    dd($categories);

    //Result (CASE 1):
    /**
      #items: array:7 [▼
        4 => "Electronics"
        5 => "|--Laptops"
        9 => "|--|--All Laptops"
        7 => "|--Mobiles"
        10 => "|--|--All Mobiles"
        8 => "|--Headphones"
        11 => "|--|--All Headphones"
      ]
    */

    //Result (CASE 2):
    /**
      #items: array:7 [▼
        5 => "Laptops"
        9 => "|-- All Laptops"
      ]
    */


```
```html

  <!-- In view -->
 <select class="border-gray-400" name="" id="">
      @foreach ($categories as $id => $name)
      <option value="{{$id}}"> {{$name}} </option>
      @endforeach
  </select>
```

#### Generate breadcrumbs for all categories

```php
    $categories = \App\Models\Category::orderByRaw('-position DESC')->get();
 
    $categories = NestifyX::setIndent(' \ ')->generateBreadCrumbs($categories);

    //will return flattened Result:
    
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


#### Generate current breadcrumbs 
```php

    $categories = Category::get();

    $categories = NestifyX::generateCurrentBreadCrumbs($categories,5); //2nd param: child id 

    array:2 [▼ 
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

```html
//in view

  <div class="flex gap-2">
      <a href="/"> Home </a> 
      @foreach ($categories as $category)
      <a href="{{route('shop-page',$category['category']['id'])}}"> \ {{$category['name']}} </a>
      @endforeach
  </div>
        
```


#### Get all parent ids of a child category
```php

    $categories = Category::get();
   
    $categories = NestifyX::collectParentIds($categories,11);

```

#### Get all child ids of a parent category
```php

    $categories = Category::get();

    $categories = NestifyX::collectChildIds($categories,4);

```



### Upcoming Feature
> - Add Nestable2 plugin feature in Categories <br>
> - Remove Alpine js dependency
> - Add support for bootstrap

<br>
New features suggestions are always welcome

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

<!-- ### Security

If you discover any security related issues, please email codeaxion77@gmail.com instead of using the issue tracker. -->

## Credits

-   [Code Axion](https://github.com/code-axion)
<!-- -   [All Contributors](../../contributors) -->

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

