<?php

namespace App\Http\Requests;

use App\Enums\TaskPriorityEnum;
use Illuminate\Validation\Rule;

class TaskRequest extends BaseRequest
{
    public $errorBag = 'task';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => ['string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => [Rule::in(TaskPriorityEnum::values())],
            'due_date' => ['nullable', 'date'],
            'is_completed' => ['boolean'],
            'category_ids' => ['nullable', 'array'],
            'category_ids.*' => ['integer', Rule::exists('categories', 'id')],
        ];

        if ($this->isMethod('post')) {
            $rules['title'][] = 'required';
            $rules['priority'][] = 'required';
        }

        return $rules;
    }
}
