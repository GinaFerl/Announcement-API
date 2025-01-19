<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
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
        return view('posts.index', compact('posts'));
    }

    /**
     * Display a listing of the resource (for API).
     */
    public function indexApi()
    {
        $posts = Post::all();
        return response()->json([
            'status' => 'success',
            'data' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage (for web).
     */
    public function store(PostRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->handleImageUpload($request);

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Store a newly created resource in storage (for API).
     */
    public function storeApi(PostRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->handleImageUpload($request);

        $post = Post::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Post created successfully.',
            'data' => $post,
        ], 201);
    }

    /**
     * Display the specified resource (for web).
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Display the specified resource (for API).
     */
    public function showApi($id)
    {
        try {
            $post = Post::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $post,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found.',
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage (for web).
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $data = $request->validated();
        $data['image'] = $this->handleImageUpload($request, $post->image);

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Update the specified resource in storage (for API).
     */
    public function updateApi(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $data = $request->validated();
        $data['image'] = $this->handleImageUpload($request, $post->image);

        $post->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Post updated successfully.',
            'data' => $post,
        ]);
    }

    /**
     * Remove the specified resource from storage (for web).
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $this->deleteImage($post->image);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    /**
     * Remove the specified resource from storage (for API).
     */
    public function destroyApi($id)
    {
        $post = Post::findOrFail($id);

        $this->deleteImage($post->image);
        $post->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully.',
        ], 204);
    }

    /**
     * Handle image upload.
     */
    private function handleImageUpload(Request $request, $existingImage = null)
    {
        if ($request->hasFile('image')) {
            if ($existingImage && file_exists(public_path('images/' . $existingImage))) {
                unlink(public_path('images/' . $existingImage));
            }
            $fileName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $fileName);
            return $fileName;
        }
        return $existingImage;
    }

    /**
     * Delete image file.
     */
    private function deleteImage($image)
    {
        if ($image && file_exists(public_path('images/' . $image))) {
            unlink(public_path('images/' . $image));
        }
    }
}