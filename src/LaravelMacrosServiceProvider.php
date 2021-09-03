<?php

namespace Zlt\LaravelMacros;

use Illuminate\Support\ServiceProvider;
use Zlt\LaravelMacros\Traits\GroupAndSortBy;
use Zlt\LaravelMacros\Traits\OnlyValues;
use Zlt\LaravelMacros\Traits\PluckMultiple;
use Zlt\LaravelMacros\Traits\SortInValue;
use Zlt\LaravelMacros\Traits\UpdateOrCreateWhen;

class LaravelMacrosServiceProvider extends ServiceProvider
{
    use OnlyValues, PluckMultiple, UpdateOrCreateWhen, SortInValue, GroupAndSortBy;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/laravelmacros.php' => config_path('laravelmacros.php'),
        ]);
    }

    public function register()
    {
        $default_macros = ['onlyValues', 'pluckMultiple', 'updateOrCreateWhen', 'sortInValue', 'sortInValueDesc', 'groupAndSortBy', 'groupAndSortByDesc'];
        $excluded = config('laravelmacros.exclude_macros', []);
        foreach ($default_macros as $macro) {
            if(!in_array($macro,$excluded)){
                if (method_exists($this, $macro)) $this->$macro();
            }
        }
        require_once(__DIR__.'/Helpers/helpers.php');
    }
}
