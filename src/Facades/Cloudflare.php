<?php

namespace YandiNovriandi\Cloudflare\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Cloudflare\Api\HttpClient
 */
class Cloudflare extends Facade
{
    /**
     * Return facade accessor.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Cloudflare';
    }
}
