<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Http\Request as LarryRequest;

class Request extends LarryRequest
{
    /**
     * container for rules.
     */
    protected $with = [];

    /**
     * Ensures a user is retrieved
     */
    public function user(){
        $user = Auth::user();
        if(empty($user)){
            AbortRequest(['Unauthorized: Session Expired, Please log in.'], 401);
        }
        return $user;
    }

    /**
     * Throw renderable response.
     */
    protected function failedValidation(ValidatorContract $validator){

        foreach($validator->errors() as $key => $value){
            $response[] = $value;
        }

        throw new HttpResponseException(response()->json($response,422));
    }


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

    /**
     * pass in rules and return instance
     * gives the ability to chain functions
     */
    public function with($rules){
        $this->with = $rules;
        return $this;
    }
}
