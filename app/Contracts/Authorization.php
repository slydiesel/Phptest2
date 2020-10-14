<?php

namespace App\Contracts;



interface Authorization
{

    public function user();

    public function respects($token);

    public function generate();

    public function refresh();

    public function expiration();

    public function isExpired();

}
