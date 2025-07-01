<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class ApiRequest extends FormRequest
{
    /**
     * ignore unuse params and get validated data.
     */
    public function safeParam($keys = null)
    {
        return $this->only(array_keys($this->rules()));
    }
}
