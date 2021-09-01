<?php

return [
    /*
     * Define your eloquent builder class so that you can use custom Eloquent macros provided by package.
     */
    'builder' => \Illuminate\Database\Eloquent\Builder::class,

    /*
     * You may customize which macros you want to use.
     * Only macros provided below will be registered.
     * Available Macros are 'onlyValues','pluckMultiple','updateOrCreateWhen','sortInValue','sortInValueDesc','groupAndSortBy','groupAndSortByDesc'.
     */
    'macros' => ['onlyValues', 'pluckMultiple', 'updateOrCreateWhen', 'sortInValue', 'sortInValueDesc', 'groupAndSortBy', 'groupAndSortByDesc'],
];
