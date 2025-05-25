<?php

namespace App\Http\Requests;

use App\Models\TodoItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TodoItemRequest extends FormRequest
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
            'title' => ['required','string','max:255', Rule::unique(TodoItem::class)->ignore($this->route('todoItem'))],
            'description' => ['nullable','string','max:1000'],
            'due_date' => ['nullable'],
        ];
    }



    function save(): bool
    {
        $todoItem =  TodoItem::find($this->route('todoItem')) ?? new TodoItem();
        $todoItem->title = $this->title;
        $todoItem->description = $this->description;
        $todoItem->due_date = $this->due_date;
        $todoItem->user_id = auth()->id();

        return $todoItem->save();
    }
}
