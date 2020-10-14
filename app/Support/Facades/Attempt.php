<?php

namespace App\Support\Facades;

use ReflectionClass;
use ReflectionFunction;
use App\Support\Contracts\Attempt as AttemptContract;

class Attempt implements AttemptContract {

    /**
     * The object housing this function
     */
    protected $object;
    /**
     * The function to be called.
     */
    protected $function;
    /**
     * The parameters to be given to the function
     */
    protected $with;

    /**
     * The mapping of parameter names to values.
     */
    protected $payload;

    /**
     * Custom exception defintion
     */
    protected $exception;

    /**
     * returns the current function
     */
    protected function getFunction(){
        return $this->function;
    }
    /**
     * determines if a base object has been specified.
     */
    protected function hasObject(){
        return isset($this->object);
    }

    /**
     * determines if a payload has been specified.
     */
    protected function hasPayload(){
        return (count($this->payload) > 0);
    }

    /**
     * Throws an exception. 
     */
    protected function throw($exception,$httpCode,$errors){
        if(empty($errors)){
            $errors[] = $excetion->getMessage();
        }
        throw new \App\Exceptions\APIRequestException($httpCode,$errors);
    }   
    
    /**
    * returns the expected parameters for the defined function.
    */
   protected function RequiredParameters(){
       if($this->hasObject()){
           return $this->getParamsForObjectMethod();
       }
       return $this->getParamsForFunction();
   }

   /**
    * returns params for function that has a defined object.
    */
   protected function getParamsForObjectMethod(){
    $reflector = new ReflectionClass($this->object);
        if($refMethod = $reflector->getMethod($this->getFunction())){
            return $refMethod->getParameters();
        }
    }
    /**
     * returns params for a function.
     */
    protected function getParamsForFunction(){
        $reflector = new ReflectionFunction($this->getFunction());
        return $reflector->getParameters();
    }
        
    /**
     * performs the specified function
     */
    protected function perform(){
        $function = $this->getFunction();
        if($this->hasObject()){
            return $this->object->$function(...$this->with);
        }
        return $this->object->$function(...$this->with);
    }

    /**
     * builds the parameters to be used in the function.
     */
    protected function build($params){
        foreach($params as $param){
            $this->with[] = $this->getParameterToPush($param);
        }
    }

    /**
     * retrieves specific patameter from payload
     */
    protected function getParameterToPush($param){
        $name = $param->getName();
        $position = $param->getPosition();
        return $this->payload[$name];
    }

    /**
     * constructs the instance
     */
    public function __construct($function, $object=null, array $payload=[]){
        $this->function = $function;
        $this->object = $object;
        $this->payload = $payload;
        $this->with = [];
    }

    /**
     * add a payload to be used in the action. 
     */
    public function with(array $payload){
        $this->payload = $payload;
        return $this;
    }

    /**
     * Specify an object that this function belongs to.
     */
    public function on($object){
        $this->object = $object;
        return $this;
    }

    /**
     *  builds are performs the currently defined action.
     */
    public function action(){
        if($params = $this->RequiredParameters()){
            $this->build($params);
        }
        return $this->perform();
    }

    /**
     * This should try to perform the action
     * If the action is successful return the result,
     * If is it not return the caught exception.
     */
    public function try(){
        try{
            return $this->action();
        } catch(\Exception $ex){
            return $ex;
        }
    }

    /**
     * Same as try, except it will throw an exception 
     * throw the exception instead of handing it back.
     */
    public function AbortOnFail($httpCode=400,$errors=null){
        $outcome = $this->try();
        if($outcome instanceof \Exception){
            $this->throw($outcome,$httpCode,$errors);
        }
        return $outcome;
    }

    /**
     * Needs to be re-worked. or dropped all together.
     */
    public function throwOnFail($ExceptionClass, $httpCode=400,$errors=['']){
        $this->exception = [
            'class'    => $ExceptionClass,
            'httpCode' => $httpCode,
            'errors'   => $errors,
        ];
        return $this;
    }
}