<?php

namespace App\Http\Requests\Attributes;

use App\Enums\AttributeType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAttributeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var \App\Models\Attribute $attribute */
        $attribute = request()->route()->parameter('attribute');

        return [
            'name' => ['required', 'string', Rule::unique('attributes', 'name')->ignore($attribute->id)],
            'type' => ['required', 'string', 'in:'.implode(',', AttributeType::toArray())],
        ];
    }
}
