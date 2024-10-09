<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use App\Models\Comment;
use App\Models\popular;
use App\Models\Post;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    function index(){
        $categories = Category::all();
        $tags = Tag::all();
        $posts = Post::where('status',1)->paginate(3);
        $sliders = Post::where('status',1)->latest()->take(3)->get();
        $popular_posts = Popular::where('total_read', '>=', 5)
        ->orderBy('total_read', 'desc') // অবরোহণক্রমে সাজানো
        ->get();


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
        $comments=Comment::with('replies')->where('post_id',$post->id)->whereNull('parent_id')->get();

       


        return view('frontend.post_details ',[
                'post'=>$post,
                'comments'=>$comments,
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
        $tags = Tag::all();
        $categories = Category::all();
        $popular_posts = Popular::where('total_read', '>=', 5)
        ->orderBy('total_read', 'desc') // অবরোহণক্রমে সাজানো
        ->get();
        return view('frontend.search', [
            'search_posts' => $search_posts,
            'tags'=>$tags,
            'categories'=>$categories,
            'popular_posts'=>$popular_posts,
        
        ]);
        
        

    }
    function tag_post($tag_id){
        $all='';
        foreach(Post::all() as $post){
            $after_explode = explode(',', $post->tags);
            if(in_array($tag_id, $after_explode)){
                $all.=$post->id.',';
            }
        }
        $explode2=explode(',',$all);
        $tag_post =Post::find($explode2);


        $tag=Tag::find($tag_id);

        return view('frontend.tag_post',[
            'tag_post'=>$tag_post,
            'tag'=>$tag,
        ]);
    }

    // function tag_post($tag_id) {
    //     // Fetch posts that contain the $tag_id in the 'tags' column (comma-separated)
    //     $tag_post = Post::whereRaw("FIND_IN_SET(?, tags)", [$tag_id])->paginate(10); // Assuming you want pagination
    
    //     // Find the tag by its ID
    //     $tag = Tag::find($tag_id);
    
    //     return view('frontend.tag_post', [
    //         'tag_post' => $tag_post,
    //         'tag' => $tag,
    //     ]);
    // }
    function comment_store(Request $request){
        Comment::insert([
            'author_id' => Auth::guard('author')->id(),
            'post_id' =>$request->post_id,
            'comments' =>$request->comments,
            'parent_id' =>$request->parent_id,
            'created_at' =>Carbon::now(), 

        ]);
        return back();
    }

    function author_list(){
        $authors = Author::where('status',1)->paginate(5);
        return view('frontend.author.author_list',[
            'authors'=>$authors,
        ]);
    }
    
}
