<?php

namespace Devsbuddy\AdminrEngine\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminrRelationship extends Model
{
    use HasFactory;

    protected $table = 'adminr_relationships';

    protected $guarded = ['id'];

    protected $casts = [

    ];

}
