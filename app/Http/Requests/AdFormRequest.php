<?php namespace App\Http\Requests;

use Auth;
use App\User;
use App\Http\Requests\Request;

class AdFormRequest extends Request {
  
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {    
    return ($this->user()->canPost()) ? true : false;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    $id = $this->input('ad_id');

    return [
      'title' => 'required|max:255|Regex:/^[A-Za-z0-9 ]+$/|unique:ads,title,'.$id,
      'description' => 'required',
    ];
  }

}