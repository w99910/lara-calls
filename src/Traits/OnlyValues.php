<?php

namespace Zlt\LaravelMacros\Traits;

use Illuminate\Support\Collection;

trait OnlyValues
{
    public function onlyValues()
    {
        Collection::macro('onlyValues', function () {
            return $this->map(function ($item, $key) {
                $keys = array_keys($item);
                foreach ($keys as $key) {
                    $a[] = $item[$key];
                }
                return $a;
            });
        });
    }
}
