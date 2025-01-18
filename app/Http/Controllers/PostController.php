<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource (for web).
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts')); // Menampilkan Blade view untuk web
    }

    /**
     * Display a listing of the resource (for API).
     */
    public function indexApi()
    {
        $posts = Post::all();
        return response()->json($posts); // Menampilkan data JSON untuk API
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create'); // Menampilkan Blade view untuk form create
    }

    /**
     * Store a newly created resource in storage (for web).
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
    
        $data = $request->all();
    
        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $fileName);
            $data['image'] = $fileName;
        }
    
        Post::create($data);
    
        return redirect()->route('posts.index')->with('success', 'Post created successfully.'); // Redirect setelah store
    }

    /**
     * Store a newly created resource in storage (for API).
     */
    public function storeApi(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
    
        $data = $request->all();
    
        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $fileName);
            $data['image'] = $fileName;
        }
    
        $post = Post::create($data);
    
        return response()->json($post, 201); // Mengembalikan data baru dalam format JSON
    }

    /**
     * Display the specified resource (for web).
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post')); // Menampilkan Blade view untuk post tertentu
    }

    /**
     * Display the specified resource (for API).
     */
    public function showApi($id)
    {
        $post = Post::findOrFail($id);
        return response()->json($post); // Menampilkan data JSON untuk post tertentu
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post')); // Menampilkan Blade view untuk edit form
    }

    /**
     * Update the specified resource in storage (for web).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
    
        $post = Post::findOrFail($id);
        $data = $request->all();
    
        if ($request->hasFile('image')) {
            if ($post->image && file_exists(public_path('images/' . $post->image))) {
                unlink(public_path('images/' . $post->image));
            }
            $fileName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $fileName);
            $data['image'] = $fileName;
        }
    
        $post->update($data);
    
        return redirect()->route('posts.index')->with('success', 'Post updated successfully.'); // Redirect setelah update
    }

    /**
     * Update the specified resource in storage (for API).
     */
    public function updateApi(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
    
        $post = Post::findOrFail($id);
        $data = $request->all();
    
        if ($request->hasFile('image')) {
            if ($post->image && file_exists(public_path('images/' . $post->image))) {
                unlink(public_path('images/' . $post->image));
            }
            $fileName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $fileName);
            $data['image'] = $fileName;
        }
    
        $post->update($data);
    
        return response()->json($post); // Mengembalikan data yang sudah diperbarui dalam format JSON
    }

    /**
     * Remove the specified resource from storage (for web).
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->image && file_exists(public_path('images/' . $post->image))) {
            unlink(public_path('images/' . $post->image));
        }
        $post->delete();
    
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.'); // Redirect setelah delete
    }

    /**
     * Remove the specified resource from storage (for API).
     */
    public function destroyApi($id)
    {
        $post = Post::findOrFail($id);
        if ($post->image && file_exists(public_path('images/' . $post->image))) {
            unlink(public_path('images/' . $post->image));
        }
        $post->delete();
    
        return response()->json(null, 204); // Mengembalikan status 204 untuk berhasil menghapus
    }
}
