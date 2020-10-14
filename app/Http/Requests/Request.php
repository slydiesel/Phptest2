<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Http\Request as LarryRequest;

class Request extends LarryRequest
{
    public function user(){
        $user = Auth::user();
        if(empty($user)){
            AbortRequest(['Unauthorized: Session Expired, Please log in.'], 401);
        }
        return $user;
    }

    protected $with = [];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->with;
    }

    public function with($rules){
        $this->with = $rules;
        return $this;
    }
}
