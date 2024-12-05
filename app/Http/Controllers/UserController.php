<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends BaseController

{
    public function register(Request $request){
    $validate=Validator::make($request->all(),[
      'name'=>'required',
      'email'=>'required|email|unique:users,email',
      'password'=>'required'


    ]);
    if($validate->fails()){

        return $this->senderror($validate->errors(),"there is error in registration");
    }
      else{
        if(User::where('email',$request->email)->exists()){
            return $this->senderror('the email is eleardy exist',"there is error in registration");
        }else{
         $input=$request->all();
         $input['password']=Hash::make($request->password);
         $user=User::create($input);

         $resource['token']=$user->createToken('lastapi')->accessToken;
         $resource['name']=$user->name;
         return $this->sendresponse($resource,'you have register successfuly');


        }

    }

}
public function login(Request $request){
    if(Auth::attempt(['email'=>$request->email,"password"=>$request->password])){

        $user=Auth::user();
        $input['token']=$user->createToken('lastapi')->accessToken;
        $input['name']=$user->name;
        return $this->sendresponse($input,'you have login successfuly');
    }
    else{return $this->senderror('The password or email is wrong', ['auth' => 'is wrong']);}
}

}
