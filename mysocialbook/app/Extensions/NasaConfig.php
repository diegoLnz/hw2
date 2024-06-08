<?php

namespace Mysocialbook\App\Extensions;

class NasaConfig 
{
    public static function getApiKey(): string
    {
        return env("NASA_APIKEY");
    }
}