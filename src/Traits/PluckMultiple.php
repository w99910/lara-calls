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
                    if (preg_match('/^([a-zA-Z]+)\.([a-zA-Z]+)/', $key)) {
                        $exploded = explode('.', $key);
                        $temp = $item;
                        $key = $exploded[0];
                        foreach ($exploded as $index => $explode) {
                            if (!isset($temp[$explode])) {
                                break;
                            }
                            $temp = $temp[$explode];
                            $key = $index === 0 ? $explode: $key .'.' . $explode;
                        }
                        $a[$key] = $temp;
                    } else {
                        $a[$key] = $item[$key];
                    }
                }
                return $a ?? $item;
            });
        });
    }
}
