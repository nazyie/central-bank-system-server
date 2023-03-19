<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMemberRequest extends FormRequest
{
    protected $redirectRoute = 'bad-request';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'code' => 'required|unique:members,code|max:255',
            'description' => 'required|max:255',
            'status' => 'required|max:20',
            'member_type' => 'required|max:3',
            'created_by' => 'required',
            'updated_by' => 'required',
        ];
    }

}
