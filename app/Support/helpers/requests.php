<?php 

if(!function_exists('FindOrAbort')){
    function FindOrAbort($object,array $errors=null,$httpCode=404){
        if(!found($object)){ AbortRequest($errors, $httpCode); }
        return $object;
    }
}

if(!function_exists('AbortOnFail')){
    function AbortOnFail($attempt){
        if($attempt instanceof \Exception){
            AbortRequest(error([$attempt->getMessage()]));
        }
        return $attempt;
    }
}

if(!function_exists('AbortIfTrue')){
    function AbortIfTrue($boolean,array $errors=null,$httpCode=404){
        if($boolean){ AbortRequest($errors, $httpCode); }
        return $boolean;
    }
}
if(!function_exists('AbortIfTrue')){
    function AbortIfFalse($boolean,array $errors=null,$httpCode=404){
        if(!$boolean){ AbortRequest($errors, $httpCode); }
        return $boolean;
    }
}

if(!function_exists('AbortOnFind')){
    function AbortOnFind($object,array $errors=null,$httpCode=409){
        if(found($object)){ AbortRequest($errors, $httpCode); }
    }
}

if(!function_exists('AbortRequest')){
    function AbortRequest(array $errors=null,$httpCode=400){
        throw resolve(contract('RenderableException'),['errors'=>$errors,'httpCode'=>$httpCode]);
    }
}
