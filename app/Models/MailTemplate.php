<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MailTemplate extends Model
{
    use HasFactory;

    protected $table = 'mail_templates';

    protected $guarded = ['id'];

    protected $casts = [
        "icon_type" => "string",
        "parent" => 'integer'
    ];

    public function submenus() : HasMany
    {
        return $this->hasMany(Menu::class, 'parent');
    }

    public function parent() : BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent');
    }

}
