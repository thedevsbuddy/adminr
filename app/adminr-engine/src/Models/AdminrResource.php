<?php

namespace Devsbuddy\AdminrEngine\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AdminrResource extends Model
{
    use HasFactory;

    protected $table = 'adminr_resources';

    protected $guarded = ['id'];

    protected $casts = [
        'controllers' => 'object',
        'payload' => 'object',
        'table_structure' => 'object',
    ];

    public function menu(): HasOne
    {
        return $this->hasOne(Menu::class, 'resource');
    }
}
