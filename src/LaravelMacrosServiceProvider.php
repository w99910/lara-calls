<?php

namespace Zlt\LaravelMacros;

use Illuminate\Support\ServiceProvider;
use Zlt\LaravelMacros\Traits\OnlyValues;
use Zlt\LaravelMacros\Traits\PluckMultiple;
use Zlt\LaravelMacros\Traits\UpdateOrCreateWhen;

class LaravelMacrosServiceProvider extends ServiceProvider
{
    use OnlyValues, PluckMultiple, UpdateOrCreateWhen;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/laravelmacros.php' => config_path('laravelmacros.php'),
        ]);
    }

    public function register()
    {
        $default = ['onlyValues', 'pluckMultiple', 'updateOrCreateWhen'];
        $macros = config('laravelmacros.macros', $default);
        foreach ($macros as $macro) {
            if (method_exists($this, $macro)) $this->$macro();
        }
    }
}
