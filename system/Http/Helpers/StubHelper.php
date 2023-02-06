<?php

namespace Adminr\System\Stubs;

class StubHelper
{
    public static $datatypes = [
        'slug' => 'text',
        'foreignId' => 'select',
        'string' => 'text',
        'file' => 'file',
        'text' => 'textarea',
        'longText' => 'textarea',
        'integer' => 'number',
        'tinyInteger' => 'number',
        'unsignedInteger' => 'number',
        'unsignedTinyInteger' => 'number',
        'unsignedBigInteger' => 'number',
        'double' => 'number',
        'boolean' => 'checkbox',
        'enum' => 'select',
        'date' => 'date',
        'dateTime' => 'datetime_local',
        'time' => 'time',
        'timestamp' => 'datetime_local',
    ];
}
