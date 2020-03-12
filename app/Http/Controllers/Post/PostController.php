<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MediaService;
use App\Services\PostService;

class PostController extends Controller
{
    protected $mediaService;

    protected $postService;

    /**
     * PostController constructor.
     * @param MediaService $mediaService
     * @param PostService $postService
     */
    public function __construct(
        MediaService $mediaService,
        PostService $postService
    )
    {
        $this->mediaService = $mediaService;
        $this->postService = $postService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request)
    {

        if (!$request->hasFile('image')) {
            return response()->json(['upload_file_not_found'], 400);
        }
        $file = $request->file('image');
        if (!$file->isValid()) {
            return response()->json(['invalid_file_upload'], 400);
        }
        $result = $this->mediaService->uploadImage($file);


        return response()->json([
            'status' => "200",
            'message' => "Image uploaded successfully",
            'path' => $result['path'],
            'image_name' => $result['image'],
        ]);


    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPost(Request $request)
    {
        if($this->postService->createPost($request)){

        return \response()->json(
            [
                "status" => "success",
                "message" => "Post created",
                "code" => 201
            ]
        );
    }
        return \response()->json(
            [
                'status' => "304",
                'message' => "Something went wrong please try again later",
            ]
        );

    }
}
