<?php

namespace App\Traits;

trait CommonTrait
{
    public function columnToId($field = null, $column = null, $class)
    {
        if (!isset($class)) return;
        if (isset($field)) {
            $item = $class->where($column, '=', $field)->first();
            if ($item) {
                return $item['id'];
            } else {
                return 0;
            }
        }
        return null;
    }
}
