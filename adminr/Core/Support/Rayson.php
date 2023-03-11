<?php

namespace Adminr\Core\Support;

use Illuminate\Support\Fluent;

class Rayson extends Fluent
{
    protected bool $recursive;

    public function __construct($attributes = [], $recursive = true)
    {
        $this->recursive = $recursive;
        parent::__construct($attributes);
        foreach ($this->attributes as $key => $value) {
            if(is_array($value)){
                if($this->recursive){
                    $this->attributes[$key] = new static($value);
                } else {
                    $this->attributes[$key] = $value;
                }
            } else {
                $this->attributes[$key] = $value;
            }
        }
    }
}
