<?php

namespace Zlt\LaravelMacros\Traits;

use Illuminate\Support\Collection;

trait GroupAndSortBy
{
    function groupAndSortBy(){
        Collection::macro('groupAndSortBy', function ($groupKey, $sortKey, \Closure $closure = null) {
            $temp = [];
            $distinct = [];
            foreach($this as $value){
                if(is_array($value)&&!array_key_exists($groupKey,$value))continue;
                if(is_object($value)&&!isset($value->$groupKey))continue;

                $key = $value->$groupKey ?? $value[$groupKey];
                $temp[$key][] = $value;
                if(!in_array($key,$distinct))$distinct[] = $key;
            }
            foreach($distinct as $key){
                $collection = collect($temp[$key]);
                $sortedCollection = $collection->sortBy($sortKey);
                if($closure && is_callable($closure)){
                    $returnValue = $closure($sortedCollection);
                    if($returnValue instanceof Collection) $sortedCollection = $returnValue;
                }
                $temp[$key] = $sortedCollection;
            }
            return collect($temp);
        });
    }
    function groupAndSortByDesc(){
        Collection::macro('groupAndSortByDesc', function ($groupKey, $sortKey, \Closure $closure = null) {
            $temp = [];
            $distinct = [];
            foreach($this as $value){
                if(is_array($value)&&!array_key_exists($groupKey,$value))continue;
                if(is_object($value)&&!isset($value->$groupKey))continue;

                $key = $value->$groupKey ?? $value[$groupKey];
                $temp[$key][] = $value;
                if(!in_array($key,$distinct))$distinct[] = $key;
            }
            foreach($distinct as $key){
                $collection = collect($temp[$key]);
                $sortedCollection = $collection->sortByDesc($sortKey);
                if($closure && is_callable($closure)){
                    $returnValue = $closure($sortedCollection);
                    if($returnValue instanceof Collection) $sortedCollection = $returnValue;
                }
                $temp[$key] = $sortedCollection;
            }
            return collect($temp);
        });
    }
}
