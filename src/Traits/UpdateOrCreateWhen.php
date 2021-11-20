<?php

namespace Zlt\LaraCalls\Traits;

trait UpdateOrCreateWhen
{
    function updateOrCreateWhen()
    {
        $builder = config('laravelmacros.builder', \Illuminate\Database\Eloquent\Builder::class);
        $builder::macro('updateOrCreateWhen', function (array $checkAttributes, array $updateAttributes, \Closure $closure = null) {
            $checkObject = $this->where($checkAttributes)->first();
            if ($checkObject&&is_callable($closure)) {
                $updateObject = $checkObject->replicate()->fill($updateAttributes);
                if ($closure($checkObject, $updateObject)) {
                    $checkObject->update($updateAttributes);
                    return $checkObject;
                }
                return false;
            } else {
                return $this->create(array_merge($checkAttributes, $updateAttributes));
            }
        });
    }
}
