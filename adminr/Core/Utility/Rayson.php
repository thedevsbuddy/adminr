<?php

namespace Adminr\Core\Utility;

use Illuminate\Support\Fluent;

class Rayson extends Fluent
{
    public static function make(array $attrs, bool $recursive = false): static
    {
        $attrs = new self($attrs);
        if($recursive){
            foreach ($attrs->toArray() as $key => $attr){
                if(is_array($attr)){
                    $attrs->{$key} = new self($attr);
                } else{
                    $attrs->$key = $attr;
                }
            }
        } else {
            foreach ($attrs->toArray() as $key => $attr){
                $attrs->$key = $attr;
            }
        }

        return $attrs;
    }
}
