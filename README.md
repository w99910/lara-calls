## Some useful macros for Laravel
- [Installation](#installation)
- [Available Methods](#available-methods)
    - [updateOrCreateWhen](#updateorcreatewhen)
    - [onlyValues](#onlyvalues)
    - [pluckMultiple](#pluckmultiple)

> Note: This package is still under development.


### Installation

Install via composer 
```bash
composer require zlt/laravelmacros
``` 
Publish config file.
```bash
php artisan vendor:publish --provider="Zlt\LaravelMacros\LaravelMacrosServiceProvider"
```


### Available Methods

- #### updateOrCreateWhen
    This method is like Laravel's `updateOrCreate` method, but it accepts closure whether it should update or not if value is already existed.
    You can use this method with Eloquent.
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

    dd($food->price); //returns 200;

    $food = Food::updateOrCreateWhen(['name' => 'sushi'], [
        'price' => 300
    ], function ($oldValue, $newValue) {
        return false;
    });

    dd($food->price); //returns 200;
    ```
- #### OnlyValues
    This method can be used on `Collection` instance. This will return only values and will discard first level array keys.
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
  This method can be used on `Collection` instance. This method is similar to `get()` on Eloquent Builder.
  You can pluck columns and their values that you only want.

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





