<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;
use Validator;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\UserResource as UserResource;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function indexofuser()
    {
       $id=Auth::id();

         if(Post::where('user_id',$id)->exists()){
             $post=Post::where('user_id',$id)->get();

return $this->sendresponse(UserResource::collection($post),'these is the post of this user');

         }else{return $this->senderror('there is error','you are not the user of these post');}


    }
    public function index()
    {
       $post =Post::all();
       if(is_null($post)){return $this->senderror('there is error','emtey');}
       else{return $this->sendresponse(UserResource::collection($post),'these is the posts');}

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate=Validator::make($request->all(),[
            'name'=>'required',
            'price'=>'required',
            'content'=>'required'


          ]);
          if($validate->fails()){

              return $this->senderror($validate->errors(),"there is error ");
          }
          else{
            $input=$request->all();
            $input['user_id']=Auth::id();
            $post=Post::create($input);

            return $this->sendresponse(new UserResource ($post),'the post is created');
          }
    }

    /**
     * Display the specified resource.
     */
    public function show($post)
    {
        $posts=Post::where('id',$post)->first();
        if(is_null($posts)){return $this->senderror('there is error','emtey');}
        else{ return $this->sendresponse(new UserResource ($posts),'the post is created');}

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $post)
    {
        $posts=Post::where("id",$post)->first();
        if($posts->user_id !=Auth::id()){return $this->senderror('there is error','emtey');}
        else{$validate=Validator::make($request->all(),[
            'name'=>'required',
            'price'=>'required',
            'content'=>'required'


          ]);
          if($validate->fails()){

              return $this->senderror($validate->errors(),"there is error ");
          }
          else{
                 $posts=$posts;
                 $posts->update($request->all());
                 $posts->save();

                 return $this->sendresponse(new UserResource ($posts),'the post is updated');
        }}


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $post)
    {
        $id=Auth::id();
        $posts=Post::where('id',$post)->first();
        if($posts->user_id==$id){

            $posts->delete();
            return $this->sendresponse('is done','deleted');
        }
        else{return $this->senderror(new UserResource($posts) ,"you donnot have permation to do these  ");}
    }
}
