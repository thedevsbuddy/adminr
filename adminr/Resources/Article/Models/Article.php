<?php

namespace Adminr\Resources\Article\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Adminr\Core\Traits\HasPagination;

class Article extends Model
{
    use HasFactory, HasPagination;
    protected $table = "articles";
    protected $guarded = ['id'];

    public function featuredImage(): Attribute
	{
		return Attribute::make(
			get: function ($value) {
				if (Str::contains(request()->url(), 'api')){
					return asset($value);
				}
				return $value;
			}
		);
	}

	
}
