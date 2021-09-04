<?php

if (!function_exists('calc_exec_time')&&!in_array('calc_exec_time',config('lara-calls.exclude_macros', []))) {
    function calc_exec_time(\Closure $closure = null): ?string
    {
        if(!$closure||!is_callable($closure))return null;
        $start = microtime(true);
        $closure();
        return number_format(( microtime(true) - $start), 4);
    }
}
