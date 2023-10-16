<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserEditRequest extends FormRequest
{
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
   * @return array
   */
  public function rules()
  {
    return [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->route('id'))],
      'profile' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
      'type' => [],
      'phone' => ['nullable', 'digits:11'],
      'address' => ['max:255'],
      'dob' => [],
    ];
  }
}
