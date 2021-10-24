<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePost extends FormRequest
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
        //bail - if prefer the first error to stop the rest of the rules from running. All errors are added(flashed) to
        // session errors var in blade template thanks to Illuminate\View\Middleware\ShareErrorsFromSession:class
        return [
            'title' => 'bail|required|min:5|max:100',
            'content' => 'required|min:10',
        ];
    }
}
