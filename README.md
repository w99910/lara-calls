## Some useful macros for Laravel

- [Installation](#installation)
- [Available Methods](#available-methods)
    - [updateOrCreateWhen](#updateorcreatewhen)
    - [onlyValues](#onlyvalues)
    - [pluckMultiple](#pluckmultiple)
    - [sortInValue](#sortinvalue)
    - [sortInValueDesc](#sortinvaluedesc)

> Note: This package is still under development.

### Installation

Install via composer

```bash
composer require zlt/laravel-macros
``` 

Publish config file.

```bash
php artisan vendor:publish --provider="Zlt\LaravelMacros\LaravelMacrosServiceProvider"
```

### Available Methods

- #### updateOrCreateWhen
  This method is like Laravel's `updateOrCreate` method, but it accepts closure whether it should update or not if value
  is already existed. You can use this method with Eloquent.
    ```php
    $food = Food::updateOrCreateWhen(['name' => 'sushi',], [
        'price' => 100,
    ]);
    
    dd($food->price); //100

    $food = Food::updateOrCreateWhen(['name' => 'sushi'], [
        'price' => 200
    ], function ($oldValue, $newValue) {
        return true;
    });

    dd($food->price); //200;

    $food = Food::updateOrCreateWhen(['name' => 'sushi'], [
        'price' => 300
    ], function ($oldValue, $newValue) {
        return false;
    });

    dd($food->price); //200;
    ```
- #### OnlyValues
  This method can be used on `Collection` instance. This will return only values and will discard first level array
  keys.
   ```php
  $collection = collect([
            [
                'a' => 123,
                'b' => 12,
            ],
            [
                'a' => 12,
                'b' => 31,
            ]
        ]);
  dd($collection->onlyValues()->toArray()); // [ [123,12],[12,31] ]; 
   ```
- #### PluckMultiple
  This method can be used on `Collection` instance. This method is similar to `get()` on Eloquent Builder. You can pluck
  columns and their values that you only want. You can also pluck nested attributes if exists.

   ```php
  $collection = collect([
            [
                'a' => 123,
                'b' => 12,
            ],
            [
                'a' => 12,
                'b' => 31,
                'c' => 32,
            ]
        ]);
   
  dd($collection->pluckMultiple(['a', 'b']));
  /*
  Illuminate\Support\Collection {
    all: [
           [ "a" => 123, "b" => 12,],
           [ "a" => 12, "b" => 31,],
      ],
  }
  */
  
  $collection = collect([
            [
                'a' => 123,
                'b' => 12,
                'c' => [
                    'x' => 1,
                ]
            ],
            [
                'a' => 12,
                'b' => 31,
                'c' => [
                    'x' => 2,
                ],
            ]
        ]);
    
  dd($collection->pluckMultiple(['a', 'c.x']));
  /*
  Illuminate\Support\Collection {
     all: [
            [ "a" => 123, "c.x" => 1,],
            [ "a" => 12, "c.x" => 2,],
          ],
       }
   */
   ```
- #### SortInValue
  This method will sort values of certain attribute in ascending order. 
  You can also specify key to sort values of that attribute. To sort in descending order, use [`sortInValueDesc`](#sortinvaluedesc)
    ```php
   $collection = collect([
          [
           'a' => [4,5,1,3]
          ],
          [
            'a' => [5,6,1,8]
          ]
    ]);
    $collection->sortInValue('a');
  /*
  Illuminate\Support\Collection {#4325
     all: [
       [
         "a" => Illuminate\Support\Collection {#4328
           all: [
             2 => 1,
             3 => 3,
             0 => 4,
             1 => 5,
           ],
         },
       ],
       [
         "a" => Illuminate\Support\Collection {#4322
           all: [
             2 => 1,
             0 => 5,
             1 => 6,
             3 => 8,
           ],
         },
       ],
     ],
   }
  */
   
  $collection = collect([
       [
           'a' => [['b'=>4],['b'=>5],['b'=>1],['b'=>3]]
       ],
        [
            'a' => [['b'=>5],['b'=>2],['b'=>6],['b'=>1]]
        ]
    ]);
    $collection->sortInValue('a'); 
  /*
  Illuminate\Support\Collection {#4306
     all: [
       [
         "a" => Illuminate\Support\Collection {#4325
           all: [
             2 => [
               "b" => 1,
             ],
             3 => [
               "b" => 3,
             ],
             0 => [
               "b" => 4,
             ],
             1 => [
               "b" => 5,
             ],
           ],
         },
       ],
       [
         "a" => Illuminate\Support\Collection {#4296
           all: [
             3 => [
               "b" => 1,
             ],
             1 => [
               "b" => 2,
             ],
             0 => [
               "b" => 5,
             ],
             2 => [
               "b" => 6,
             ],
           ],
         },
       ],
     ],
   }
  */  
    ```
- #### SortInValueDesc
   This method is similar to [`sortInValue`](#sortinvalue) but will sort in descending order.

  




