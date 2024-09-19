<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    function add_post(){
        $categories = Category::all();
        $tags =Tag::all();
        return view('frontend.author.add_post',[
            'categories'=>$categories,
            'tags'=>$tags,
        ]);
    }
}
