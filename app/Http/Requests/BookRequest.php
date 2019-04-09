<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;//or check()?
        //or on BookController
//         class LetterController extends Controller
// {
// protected $user;?????????????????????????
// public function __construct()
// {
//     $this->middleware(function ($request, $next){
//        $this->user = Auth::user();
//         return $next($request);
//     });

// }
// public function edit(Letter $letter)
// {
//     if($this->user->can('update', $letter)){           
//        //edit
//     }
//     else
//         abort('403', 'Access Denied');
// }
    //     $comment = Comment::find($this->route('comment'));

    // return $comment && $this->user()->can('update', $comment);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' =>'required|min:1|max:32',
            'author_name'   => 'required|min:1|max:32',
            'page' => 'required',
            'autor'   => 'required',
            'year' => 'required',
            'kindof' => 'required',
            'size'  => 'required',
            'price'   => 'required',
            'old_price' => '',
            'img' =>  'nullable|image',
            'discont_global' => 'required',
        ];
    }
    /*
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name' => 'The :attribute value is required :input is not between 1:min - 32:max.',
            'author_name'  => 'The :attribute value :input is no more then 32:max.',
        ];
    }
}
