<?php


if(!function_exists('found')){
    function found($object){
        if($object instanceof \Countable && count($object) <= 0){ return false; }
        if(empty($object)){ return false; }
        return true;
    }
}

if(!function_exists('Attempt')){
    function Attempt($function,$object=null,$payload=null){
        return resolve(contract('Attempt'),['function' => $function, 'object' => $object,'payload' => $payload]);
    }
}


if(!function_exists('contract')){
    function contract(string $name, string $namespace='App\\Contracts\\') {
        return $namespace.$name;
    }
}

if(!function_exists('controller')){
    function controller(string $name) {
        if(app('request')->segment(1) == 'api'){
            $version = app('request')->segment(2);
            $namespace = config('app.api.controllers.namespace.'.$version);
            if(empty($namespace)){
                AbortRequest(['Invalid Version'],404);
            }
            return $namespace.$name;
        }
    }
}


// if(!function_exists('mappify')){
//     function mappify(array $keys, array $values){
//         if(count($keys) != count($values)){ Reject('key and value counts do not match.'); }
//         $map = array();
//         foreach($keys as $index => $key){
//             $map[$key] = $values[$index];
//         }
//         return $map;
//     }
// }

if(!function_exists('isProduction')){
    function isProduction(){
        return config('app.env') == 'production';
    }
}