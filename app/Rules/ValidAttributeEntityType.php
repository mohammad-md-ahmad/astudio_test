<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Model;

class ValidAttributeEntityType implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $modelClass = 'App\\Models\\'.ucfirst($value);

        if (! class_exists($modelClass)) {
            $fail(trans('The specified entity type does not exist.'));

            return;
        }

        if (! is_subclass_of($modelClass, Model::class)) {
            $fail(trans('The specified entity type is not a valid model.'));
        }
    }
}
