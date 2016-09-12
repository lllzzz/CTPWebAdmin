<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function __construct(Request $req)
    {
        $env = $req->cookie('env') ?: 'dev';
        $this->tickDB = DB::connection('tick_' . $env);
        $this->orderDB = DB::connection('order_' . $env);
        $this->klineDB = DB::connection('kline_' . $env);
        $this->data['env'] = $env;
    }
}
