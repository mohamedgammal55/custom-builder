<?php

namespace CustomBuilder;
use Illuminate\Database\Eloquent\Builder;

class CustomBuilder extends Builder
{
    public function createOrDelete(array $attributes, array $values = [])
    {
        return tap($this->deleteOrNew($attributes), function ($instance) use ($values) {
            $instance->fill($values)->save();
        });
    }//end fun

    public function deleteOrNew(array $attributes = [], array $values = [])
    {
        if (! is_null($instance = $this->where($attributes)->first())) {
            $this->where($attributes)->delete();
            return $instance;
        }

        return $this->newModelInstance($attributes + $values);
    }
}//end fun
