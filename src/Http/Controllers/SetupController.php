<?php

/**
 * Created by PhpStorm.
 * User: Fabian
 * Date: 19.07.16
 * Time: 06:17
 */

namespace Quickweb\DotenvEditor\Http\Controllers;

use Quickweb\DotenvEditor\DotenvEditor as Env;
use Quickweb\DotenvEditor\Exceptions\DotEnvException;
use Illuminate\Http\Request;

class SetupController extends EnvController
{

    public function getConfig()
    {
        return new Env('setupeditor');
    }
}
