<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        // return Auth::user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'max:100'],
            // 'password' => ['required', 'min:5'],
        ];
        // dd($this->input('type'));
        switch ($this->input('type')) {
            case 'create':
                $rules += [
                    'email' => ['required', 'unique:users,email'],
                    'password' => ['required', 'min:10', 'confirmed'],
                    'password_confirmation' => ['required', 'min:10']
                ];
                break;
            case 'update':
                $rules += [
                    'email' => ['required', 'unique:users,email'],
                    // 'password' => ['min:10', 'confirmed:password_confirm'],
                ];
                break;
            
            default:
                # code...
                break;
        }
        // dd($rules);
        return $rules;
    }
}
