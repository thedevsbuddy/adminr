<?php

namespace Devsbuddy\AdminrEngine;

use Illuminate\Database\Eloquent\Model;

class Database extends Model
{

    /**
     * Currently supported datatype
     * */
    static public function dataTypes()
    {
        return [
            'slug',
            'increments',
            'bigIncrements',
            'string',
            'file',
            'text',
            'longText',
            'integer',
            'tinyInteger',
            'unsignedInteger',
            'unsignedTinyInteger',
            'unsignedBigInteger',
            'double',
            'boolean',
            'enum',
            'json',
            'date',
            'dateTime',
            'time',
            'timestamp',
        ];
    }

    static public function timeTypes()
    {
        return [
            'date',
            'dateTime',
            'time',
            'timestamp',
        ];
    }

    static public function numericTypes()
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

    static public function integerTypes()
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

    static public function incrementTypes()
    {
        return [
            'increments',
            'bigIncrements',
        ];
    }


    static public function longTextDataTypes()
    {
        return [
            'text',
            'longText'
        ];
    }

    static public function relationshipIdentifiers()
    {
        return [
            'hasOne',
            'hasMany',
            'belongsTo',
            'belongsToMany',
            'manyToMany'
        ];
    }

    static public function htmlDataType($type = null){
        $types = [
            'slug' => 'text',
            'increments' => 'number',
            'bigIncrements' => 'number',
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
            'json' => 'text',
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
