<?php

namespace App\Bundles;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TimezoneBundle extends Bundle
{
    public function boot()
    {

        date_default_timezone_set("Europe/Madrid");
    }
}
