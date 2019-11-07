<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AskQuestionRequest extends FormRequest
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
      'title' => 'required|max:255',
      'body' => 'required'
    ];
  }

  public function messages()
  {
    return [
      'title.required' => 'Vui lòng nhập tiều đề câu hỏi',
      'title.max' => 'Vui lòng nhập không quá 255 kí tự',
      'body.required' => 'Vui lòng nhập nội dung câu hỏi'
    ];
  }
}
