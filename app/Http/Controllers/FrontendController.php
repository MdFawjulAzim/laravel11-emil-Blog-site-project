<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    function index(){
        $categories = Category::all();
        $tags = Tag::all();
        return view('frontend.index',[
            'categories'=> $categories,
            'tags'=>$tags,
        ]);
    }
}
