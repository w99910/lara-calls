<?php

namespace Zlt\LaraCalls;

use Illuminate\Support\ServiceProvider;
use Zlt\LaraCalls\Traits\GroupAndSortBy;
use Zlt\LaraCalls\Traits\OnlyValues;
use Zlt\LaraCalls\Traits\PluckMultiple;
use Zlt\LaraCalls\Traits\SortInValue;
use Zlt\LaraCalls\Traits\UpdateOrCreateWhen;
use Zlt\LaraCalls\Traits\Validation;

class LaraCallsServiceProvider extends ServiceProvider
{
    use OnlyValues,
        PluckMultiple,
        UpdateOrCreateWhen,
        SortInValue,
        GroupAndSortBy,
        Validation;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/lara-calls.php' => config_path('lara-calls.php'),
        ]);
    }

    public function register()
    {
        $default_macros = ['onlyValues', 'pluckMultiple', 'updateOrCreateWhen', 'sortInValue', 'sortInValueDesc', 'groupAndSortBy', 'groupAndSortByDesc', 'validation'];
        $excluded = config('lara-calls.exclude_macros', []);
        foreach ($default_macros as $macro) {
            if (!in_array($macro, $excluded)) {
                if (method_exists($this, $macro)) $this->$macro();
            }
        }
        require_once(__DIR__ . '/Helpers/helpers.php');
    }
}
