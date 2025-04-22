<?php

namespace AlanRetubis\LaravelRete\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AlanRetubis\LaravelRete\ReteEngine
 */
class ReteEngine extends Facade
{
    /**
     * Get the registered name of the component in the service container.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'rete-engine';
    }
}
