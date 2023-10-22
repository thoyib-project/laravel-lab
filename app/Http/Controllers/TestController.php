<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\testTrait;

class TestController extends Controller
{
    use testTrait;

    function index() {
        $string = $this->ngetestTrait();
        return $string;
    }
}
