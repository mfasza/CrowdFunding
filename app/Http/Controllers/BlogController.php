<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Http\Requests\BlogStoreRequest;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    
    public function random($count)
    {
        $blogs = Blog::getRandomBlogs($count);
        
        $data['blogs'] = $blogs;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Data blog berhasil ditampilkan',
            'response_data' => $data
        ], 200);

    }

    public function store(BlogStoreRequest $request)
    {
        $blog = Blog::create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        $data['blog'] = $blog;

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $image_extension = $image->getClientOriginalExtension();
            $image_name = $blog->blog_id . '.' . $image_extension;
            $image_folder = '/photos/blog/';
            $image_location = $image_folder . $image_name;

            try {
                $image->move(public_path($image_folder), $image_name);

                $blog->update([
                    'image' => $image_location
                ]);

                $data['blog'] = $blog;
            } catch (\Exception $e) {
                return response()->json([
                    'response_code' => '01',
                    'response_message' => 'Gambar gagal diunggah',
                    'response_data' => $data
                ], 200);
            }

        }

        return response()->json([
            'response_code' => '01',
            'response_message' => 'Data blog berhasil ditambahakan',
            'response_data' => $data
        ], 200);

    }

}
