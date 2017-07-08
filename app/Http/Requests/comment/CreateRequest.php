<?php namespace App\Http\Requests\comment;


use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Request;

class CreateRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
      return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'text'    => 'required',
            'group_id' => 'required',
        ];
    }

}