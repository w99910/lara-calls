# A bunch of useful methods for Laravel
## Table Of Contents
- [Installation](#installation)
- [Available Methods](#available-methods)
    - [Collection Macros](#collection-macros)
      - [onlyValues](#onlyvalues)
      - [pluckMultiple](#pluckmultiple)
      - [sortInValue](#sortinvalue)
      - [sortInValueDesc](#sortinvaluedesc)
      - [groupAndSortBy](#groupandsortby)
      - [groupAndSortByDesc](#groupandsortbydesc)
      - [validation](#validation)
    - [Builder Macros](#builder-macros)
      - [updateOrCreateWhen](#updateorcreatewhen)
    - [Global Helpers](#global-helpers)
      - [Calculate Execution Time](#calculate-execution-time)
    
## Installation

Install via composer

```bash
composer require zlt/lara-calls
``` 

Publish config file.

```bash
php artisan vendor:publish --provider="Zlt\LaraCalls\LaraCallsServiceProvider"
```

Config file will contain 
```php
return [
    /*
     * Define your eloquent builder class so that you can use custom Eloquent macros provided by package.
     */
    'builder' => \Illuminate\Database\Eloquent\Builder::class,

    /*
     * You may customize which macros you don't want to use.
     * Only macros provided below will not be registered.
     * Available Macros are 'onlyValues','pluckMultiple','updateOrCreateWhen','sortInValue','sortInValueDesc','groupAndSortBy','groupAndSortByDesc','calc_exec_time'.
     */
    'exclude_macros' => [],
];
```


> Note: If you've already published config, update your 'macros' in 'laravel-macros' config to use the latest methods.

## Available Methods

### Collection Macros
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
                'a' => [
                    ['b' => 4],
                    ['b' => 5],
                    ['b' => 1],
                    ['b' => 3]]
            ],
            [
                'a' => [
                    ['b' => 5],
                    ['b' => 2],
                    ['b' => 6],
                    ['b' => 1]]
            ]
        ]);
    $collection->sortInValue('a','b'); 
  /*
  Illuminate\Support\Collection {#4348
     all: [
       [
         "a" => Illuminate\Support\Collection {#4347
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
         "a" => Illuminate\Support\Collection {#4346
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
- #### GroupAndSortBy
   This method is similar to `groupBy` but you can sort the returned collection.
   You can also provide a callback to modify the returned collection as you like. 
   In order to sort the returned collection in descending order, you may use [`groupAndSortByDesc`](#groupandsortbydesc) method.
  ```php
   $collection = collect([
            [
                'name' => 'James',
                'age' => 20,
            ],
            [
                'name' => 'Watson',
                'age' => 24,
            ],
            [
                'name' => 'James',
                'age' => 15,
            ]
        ]);

   dd($collection->groupAndSortBy('name','age'));
  /*
   Illuminate\Support\Collection^ {#4321
             #items: array:2 [
         "James" => Illuminate\Support\Collection^ {#4322
           #items: array:2 [
             1 => array:2 [
               "name" => "James"
               "age" => 15
             ]
             0 => array:2 [
               "name" => "James"
               "age" => 20
             ]
           ]
         }
         "Watson" => Illuminate\Support\Collection^ {#4325
           #items: array:1 [
             0 => array:2 [
               "name" => "Watson"
               "age" => 24
             ]
           ]
         }
       ]
    }
    */
  
   $collection = collect([
            [
                'name' => 'James',
                'age' => 20,
            ],
            [
                'name' => 'Watson',
                'age' => 24,
            ],
            [
                'name' => 'James',
                'age' => 15,
            ]
        ]);

   dd($collection->groupAndSortBy('name','age',function($collection){
       return $collection->where('age','>=',24);
   }));
        /*
   Illuminate\Support\Collection^ {#4313
       #items: array:2 [
         "James" => Illuminate\Support\Collection^ {#4311
           #items: []
         }
         "Watson" => Illuminate\Support\Collection^ {#4309
           #items: array:1 [
             0 => array:2 [
               "name" => "Watson"
               "age" => 24
             ]
           ]
         }
       ]
     }
    */
  ```
- #### GroupAndSortByDesc
  The `groupAndSortByDesc` method is similar to [`groupAndSortBy`](#groupandsortby) but the returned collection is sorted in descending order.
- #### Validation
  Validate the collection and perform subsequent `onSuccess` or `onError` processes. In order to validate,
you may provide **array of validation rules or closure**. If you provide validation rules, you can provide a parameter inside closure in `onError` and that parameter would
be an instance of `\Illuminate\Support\MessageBag`.
  
    ```php
  $collection = collect(['name'=>'John','email'=>'email']);
  
  $collection->validation(['name'=>'string','email'=>'email'])
             ->onSuccess(function($collection){
                return $collection;})
             ->onError(function($messageBag){
              return $messageBag->toArray();
             }); // [ "email" => [ "The email must be a valid email address.", ], ]
  
  $collection->validation(function($collection){
               return false; //Return type must be 'boolean'.Otherwise, it will always return false.})
             ->onSuccess(function($collection){
                return $collection;})
             ->onError(function(){
              //Perform some process after failing validation
             }); // [ "email" => [ "The email must be a valid email address.", ], ]
    ```

## Builder Macros
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



## Global Helpers

- #### Calculate Execution Time
    Calculate your function execution time in seconds. 
    ```php
   $time = calc_exec_time(function(){
   sleep(5);
  return 'test';
  });
   dd($time); //"5.0008"
    ```






