<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function registerLog( $e, $chanel, $level ){      

        // create a log channel
        $log = new Logger($chanel);
        $log->pushHandler(new StreamHandler('logs/app.log', $level));
        $log->warning($e);
    }
}
