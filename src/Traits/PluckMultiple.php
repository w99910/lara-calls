<?php

namespace Zlt\LaravelMacros\Traits;

use Illuminate\Support\Collection;

trait PluckMultiple
{
    function pluckMultiple()
    {
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
