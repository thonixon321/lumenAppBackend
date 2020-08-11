<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => [
            'showOneAuthor',
            'store',
            'update',
            'delete'
        ]]);
    }

    public function showAllAuthors()
    {
        // print_r(response()->json(Author::all()));
        $posts = Author::with('user')->get();

        return response()->json($posts);
    }

    public function showOneAuthor($id)
    {
        return response()->json(Author::find($id));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'blog_title' => 'required',
            'blog_body' => 'required',
            'blog_image' => 'image|nullable|max:1999', //max of just under 2 mega bytes
            'author_image' => 'image|nullable|max:1999' //max of just under 2 mega bytes
        ]);

        //Handle File Upload
        // if($request->hasFile('blog_image')) {
        //     // Get filename with extension
        //     $filenameWithExt = $request->file('blog_image')->getClientOriginalImage();
        //     // Get just filename
        //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //     // Get just ext
        //     $extension = $request->file('blog_image')->getOriginalClientExtension();
        //     //Filename to store (timestamp makes this name unique)
        //     $fileNameToStore = $filename.'_'.time().'.'.$extension;
        //     // Upload image (puts in public folder in storage/app/public/images - need sym link to other public folder)
        //     $path = $request->file('blog_image')->storeAs('public/images', $fileNameToStore);
        // } else {
        //     $fileNameToStore = 'noimage.jpg';
        // }

        $author = Author::create($request->all());

        return response()->json($author, 201);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'author' => 'required',
            'blog_title' => 'required',
            'blog_body' => 'required',
            'blog_image' => 'image|nullable|max:1999', //max of just under 2 mega bytes
            'author_image' => 'image|nullable|max:1999' //max of just under 2 mega bytes
        ]);
        
        $author = Author::findOrFail($id);
        $author->update($request->all());

        return response()->json($author, 200);
    }

    public function delete($id)
    {
        Author::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}