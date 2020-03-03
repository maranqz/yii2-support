<?php

namespace SSupport\Module\Core\Utils;

trait ModuleTrait
{
    public function getRoute($route)
    {
        return '/'.$this::$name.'/'.$route;
    }

    public static function appendArrayInPlace($array, $appendix)
    {
        $result = [];
        foreach ($appendix as $key => $item) {
            if (\is_string($key)) {
                $result[$key] = $item;
            } else {
                $result[$item] = $array[$item];
            }
        }

        return $result;
    }
}
