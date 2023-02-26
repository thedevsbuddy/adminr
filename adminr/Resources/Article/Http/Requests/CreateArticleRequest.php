<?php

namespace Adminr\Resources\Article\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "title" => ["required"],
				"featured_image" => ["required"],
			
        ];
    }
}
