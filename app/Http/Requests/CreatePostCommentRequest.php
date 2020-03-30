<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostCommentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message' => ['required', 'string', 'min:5', 'max:255'],
            'user_id' => ['required', 'int'],
            'post_id' => ['required', 'int'],
        ];
    }
}

