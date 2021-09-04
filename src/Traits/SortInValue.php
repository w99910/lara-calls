<?php

namespace Zlt\LaraCalls\Traits;

use Illuminate\Support\Collection;

trait SortInValue
{
    function sortInValue(){
        Collection::macro('sortInValue', function ($attributeName , $sortKey = null) {
            return $this->map(function ($item, $key) use ($attributeName, $sortKey){
                $values = collect($item[$attributeName]);
                if($sortKey) {
                    $item[$attributeName] = $values->sortBy($sortKey);
                }else{
                    $item[$attributeName] = $values->sort();
                }
                return $item;
            });
        });
    }
    function sortInValueDesc(){
        Collection::macro('sortInValueDesc', function ($attributeName , $sortKey = null) {
            return $this->map(function ($item, $key) use ($attributeName, $sortKey){
                $values = collect($item[$attributeName]);
                if($sortKey) {
                    $item[$attributeName] = $values->sortByDesc($sortKey);
                }else{
                    $item[$attributeName] = $values->sortDesc();
                }
                return $item;
            });
        });
    }
}
