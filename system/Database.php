<?php

namespace Devsbuddy\AdminrEngine;

use Illuminate\Database\Eloquent\Model;

class Database extends Model
{

    static public function dataTypes(): array
    {
        return [
            'uuid',
            'integer',
            'foreignId',
            'tinyInteger',
            'unsignedInteger',
            'unsignedTinyInteger',
            'unsignedBigInteger',
            'double',
            'boolean',
            'string',
            'slug',
            'text',
            'longText',
            'enum',
            'date',
            'dateTime',
            'time',
            'timestamp',
            'file',
        ];
    }

    static public function timeTypes(): array
    {
        return [
            'date',
            'dateTime',
            'time',
            'timestamp',
        ];
    }

    static public function numericTypes(): array
    {
        return [
            'integer',
            'tinyInteger',
            'bigInteger',
            'unsignedInteger',
            'unsignedTinyInteger',
            'unsignedBigInteger',
            'double',
            'boolean',
        ];
    }

    static public function integerTypes(): array
    {
        return [
            'integer',
            'tinyInteger',
            'bigInteger',
            'unsignedInteger',
            'unsignedTinyInteger',
            'unsignedBigInteger',
            'boolean',
        ];
    }

    static public function incrementTypes(): array
    {
        return [
            'increments',
            'bigIncrements',
        ];
    }


    static public function longTextDataTypes(): array
    {
        return [
            'text',
            'longText'
        ];
    }

    static public function relationshipIdentifiers(): array
    {
        return [
            'hasOne',
            'hasMany',
            'belongsTo',
            'belongsToMany',
            'manyToMany'
        ];
    }

    static public function htmlDataType($type = null): array|string
    {
        $types = [
            'slug' => 'text',
            'foreignId' => 'select',
//            'increments' => 'number',
//            'bigIncrements' => 'number',
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
//            'json' => 'text',
            'date' => 'date',
            'dateTime' => 'datetime_local',
            'time' => 'time',
            'timestamp' => 'datetime_local',
        ];

        if ($type == null){
            return $types;
        }
        return $types[$type];
    }
}
