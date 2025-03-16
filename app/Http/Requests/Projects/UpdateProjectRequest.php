<?php

namespace App\Http\Requests\Projects;

use App\Enums\ProjectStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
        $project = request()->route()->parameter('project');

        return [
            'name' => ['required', 'string', Rule::unique('projects', 'name')->ignore($project->id)],
            'status' => ['required', 'string', 'in:'.implode(',', ProjectStatus::toArray())],
        ];
    }
}
