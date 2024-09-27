<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use App\Models\popular;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    function index(){
        $categories = Category::all();
        $tags = Tag::all();
        $posts = Post::where('status',1)->paginate(3);
        $sliders = Post::where('status',1)->latest()->take(3)->get();
        $popular_posts=popular::where('total_read','>=',5)->get();


        return view('frontend.index',[
            'categories'=> $categories,
            'tags'=>$tags,
            'posts'=>$posts,
            'sliders'=>$sliders,
            'popular_posts'=>$popular_posts,
        ]);
    }

    function author_login_page(){
        return view('frontend.author.login');
    }

    function author_register_page(){
        return view('frontend.author.register');
    }

    function post_details($slug){
        
        $post = Post::where('slug',$slug)->first();

        if(popular::where('post_id',$post->id)->exists()){
            popular::where('post_id',$post->id)->increment('total_read',1);

        }else{
            popular::insert([
                'post_id' => $post->id,
                'total_read'=>1,
            ]);
        }
       


        return view('frontend.post_details ',[
                'post'=>$post,
        ]);
    }
    
    function author_post($author_id){
        $author = Author::find($author_id);
        $posts = Post::where('author_id',$author_id)->where('status',1)->paginate(3);
        return view('frontend.author_post',[
            'author'=>$author,
            'posts'=>$posts,
        ]);

    }
    function category_post($category_id){
        $category = Category::find($category_id);
        $posts = Post::where('category_id',$category_id)->paginate(3);
        return view('frontend.category_post',[
            'category'=>$category,
            'posts'=>$posts,
        ]);
    }
    function search(Request $request){
        $data = $request->all();

        $search_posts = Post ::where(function($q) use ($data){
            if( !empty($data['q']) && $data ['q'] != '' && $data ['q'] != 'undefined' ){
            $q->where(function($q) use ($data){
                $q->where('title','LIKE','%'.$data['q'].'%');
                $q->orwhere('desp','LIKE','%'.$data['q'].'%');
                

            });
        }

        })->paginate(3);
        return view('frontend.search', [
            'search_posts' => $search_posts,
        ]);
        
        

    }
}
