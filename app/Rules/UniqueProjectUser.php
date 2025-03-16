<?php

namespace App\Rules;

use App\Models\ProjectUser;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueProjectUser implements ValidationRule
{
    protected string $projectId;

    public function __construct(string $projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $projectUser = ProjectUser::query()->where(function ($query) use ($value) {
            $query->where('project_id', $this->projectId)
                ->where('user_id', $value);
        })->first();

        if ($projectUser) {
            $fail(trans('User is already assigned to the selected project.'));

            return;
        }
    }
}
