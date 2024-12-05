<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendresponse($data,$mess){

        $response=[
      'success' => True,
      'data'=>$data,
      'message'=>$mess


        ];
         return response()->json($response,200);
    }
    public function senderror($data,$errormess){
        $response=[

            'success' => False,
            'data'=>$data,
            'message'=>$errormess


        ];
        return response()->json($response, 404);
    }
}
