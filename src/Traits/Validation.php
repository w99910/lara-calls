<?php

namespace Zlt\LaraCalls\Traits;

use Zlt\LaraCalls\Helpers\CollectionValidationHandler;
use Illuminate\Support\Collection;

trait Validation
{
   public function validation(){
       Collection::macro('validation', function (array|\Closure $rulesOrClosure) {
           return new CollectionValidationHandler($this,$rulesOrClosure);
    });
   }
}
