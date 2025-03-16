<?php

namespace App\Http\Requests\ProjectUsers;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteProjectUserRequest extends FormRequest
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
        /** @var Project $project */
        $project = request()->route()->parameter('project');

        return [
            'user_id' => ['required', Rule::exists('project_users')->where(function (Builder $query) use ($project) {
                $query->where('project_id', $project->id)
                    ->where('user_id', $this->input('user_id'));
            })],
        ];
    }
}
