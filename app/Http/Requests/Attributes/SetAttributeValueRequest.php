<?php

namespace App\Http\Requests\Attributes;

use App\Rules\ValidAttributeEntityId;
use App\Rules\ValidAttributeEntityType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SetAttributeValueRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', Rule::exists('attributes', 'name')],
            'value' => ['required'],
            'entity_id' => ['required', new ValidAttributeEntityId($this->input('entity_type'))],
            'entity_type' => ['required', 'string', new ValidAttributeEntityType],
        ];
    }
}
