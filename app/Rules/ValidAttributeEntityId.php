<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Model;

class ValidAttributeEntityId implements ValidationRule
{
    protected string $entityType;

    public function __construct(string $entityType)
    {
        $this->entityType = ucfirst($entityType);
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $modelClass = 'App\\Models\\'.$this->entityType;

        if (! class_exists($modelClass) || ! is_subclass_of($modelClass, Model::class)) {
            $fail(trans('Invalid entity type provided.'));

            return;
        }

        if (! $modelClass::where('id', $value)->exists()) {
            $fail(trans('The specified entity does not exist.'));
        }
    }
}
