<?php

namespace Zlt\LaraCalls\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Closure;
use Throwable;
use Exception;

class CollectionValidationHandler
{
    protected Enumerable $collection;
    protected $validator;
    protected bool $isSuccess;
    protected string $errorMessage;
    protected Collection $closures;

    public function __construct(Enumerable $collection, array|Closure $rulesOrClosure)
    {
        $this->collection = $collection;
        $this->closures = collect([]);
        if (is_array($rulesOrClosure)) $this->validator = \Validator::make($collection->all(), $rulesOrClosure);
        if ($rulesOrClosure && is_callable($rulesOrClosure)) {
            $response = $rulesOrClosure($collection);
            $this->isSuccess = gettype($response) !== 'boolean' ? false : $response;
        }
    }

    /**
     * @throws Exception
     */
    public function onSuccess(Closure $closure = null):self
    {
        if ($this->validator && $this->validator->fails()) {
            return $this;
        }
        if (!$this->validator && !$this->isSuccess) {
            return $this;
        }
        if (!$closure || !is_callable($closure)) {
            throw new \Exception('Closure must be valid and callable');
        }
        $this->closures->push(['name' => 'onSuccess','closure' => $closure]);
        return $this;
    }

    /**
     * @throws Exception
     */
    public function onError(Closure $closure = null)
    {
        if (($this->validator && !$this->validator->fails())||(!$this->validator && $this->isSuccess)) {
            $closure = $this->closures->where('name','onSuccess')->first();
            if(!$closure)return $this->collection;
            return $closure['closure']($this->collection);
        }
        if (!$closure || !is_callable($closure)) {
            throw new \Exception('Closure must be valid and callable');
        }
        if ($this->validator) {
            return $closure($this->validator->getMessageBag());
        }
        return $closure();
    }
}
