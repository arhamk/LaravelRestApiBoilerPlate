<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\UserRequest;
use App\Post;
use App\Traits\CrudTrait;
use App\User;

class TestController extends Controller
{
   use CrudTrait;
   public $model = Post::class;

   public $validation = PostRequest::class;


}

