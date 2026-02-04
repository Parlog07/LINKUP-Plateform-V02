<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(){
        $posts = Post::with(['user'])
                    ->latest()
                    ->paginate(10);
                    
        return view('posts.index', compact('posts'));
    }

    public function store(Request $request){
        $request->validate([
            'content' => 'required_without:media|nullable|string|max:2500',
            'media' => 'nullable|mimes:jpg,png,jpeg,gif,mp4,mov,avi|max:30720'
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->content = $request->content;

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $path = $file->store('posts', 'public');
            $post->media_path = $path;

            $mime = $file->getMimeType();
            $post->media_type = str_contains($mime, 'video') ? 'video' : 'image';
        }

        $post->save();

        return redirect()->route('posts.index')->with('success', 'post created successfully!');
    }


    public function destroy(Post $post){
    if(Auth::id() !== $post->user_id){
        abort(403);
    }

    $post->delete();

    return redirect()->back()->with('success', 'Post deleted');
    }
}