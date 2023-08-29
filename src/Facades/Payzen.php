<?php

namespace Humayunjavaid\Payzen\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Humayunjavaid\Payzen\Payzen
 */
class Payzen extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Humayunjavaid\Payzen\Payzen::class;
    }
}
