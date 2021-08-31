<?php

namespace Zlt\LaravelMacros;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class LaravelMacrosServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {

//        Builder::macro('updateOrCreateWhen',function(array $checkAttributes,array $updateAttributes,\Closure $closure){
//            $checkObject = $this->where($checkAttributes)->first();
//            if($checkObject){
//                $updateObject = $checkObject->replicate()->fill($updateAttributes);
//                if($closure($checkObject,$updateObject)){
//                    return $checkObject->update($updateAttributes);
//                }else{
//                    return false;
//                }
//            }else{
//                $this->create(array_merge($checkAttributes,$updateAttributes));
//                return true;
//            }
//        });

        Collection::macro('onlyValues', function () {
            return $this->map(function ($item, $key) {
                $keys = array_keys($item);
                foreach ($keys as $key) {
                    $a[] = $item[$key];
                }
                return $a;
            });
        });

        Collection::macro('pluckMultiple', function (array $keys) {
            return $this->map(function ($item) use ($keys) {
                foreach ($keys as $key) {
                    $a[$key] = preg_match('/^([a-zA-Z]+)\.([a-zA-Z]+)$/', $key) ? $item[explode('.', $key)[0]][explode('.', $key)[1]] : $item[$key];
                }
                return $a;
            });
        });


    }
}
