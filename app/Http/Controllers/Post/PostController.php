<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MediaService;
use App\Services\PostService;
use App\Repositories\PostRepository;
use App\Repositories\CommentsRepository;
use App\Post;

class PostController extends Controller
{
    protected $mediaService;

    protected $postService;

    protected $postRepository;

    protected $commentsRepository;

    protected $post;


    /**
     * PostController constructor.
     * @param MediaService $mediaService
     * @param PostService $postService
     */
    public function __construct(
        MediaService $mediaService,
        PostService $postService,
        PostRepository $postRepository,
        CommentsRepository $commentsRepository,
        Post $post
    )
    {
        $this->mediaService = $mediaService;
        $this->postService = $postService;
        $this->postRepository = $postRepository;
        $this->commentsRepository = $commentsRepository;
        $this->post = $post;
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
        $result = $this->mediaService->saveImage($file);


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
        if ($this->postService->createPost($request)) {

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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPosts()
    {
        $posts = $this->postRepository->getPosts();

        if (empty($posts)) {
            return \response()->json(
                [
                    "status" => "not found",
                    "code" => 404
                ]
            );
        }
        return \response()->json($posts);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPost(Request $request)
    {
        $postId = $request->id;
        $post = $this->postRepository->getPost($postId);

        if (empty($post)) {
            return \response()->json(
                [
                    "status" => "not found",
                    "message" => "Post with id " . $postId . " not found or post status is not published",
                    "code" => 404
                ]
            );
        }
        $comments = $this->commentsRepository->getComments($postId);

        return \response()->json(
            [
                'post' => $post->first(),
                'comments' => $comments
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMostCommentedPostsByYear(Request $request)
    {
        $year = $request->year;
        if (empty($year)) {
            return \response()->json(
                [
                    "status" => "not found",
                    "messsage" => 'Request not valid',
                    "code" => 404
                ]
            );
        }

        $posts = $this->postRepository->getMostCommentedPostsByYear($year);
        if (empty($posts->first())) {
            return \response()->json(
                [
                    "status" => "not found",
                    "code" => 404
                ]
            );
        }
        return \response()->json(
            [
                'posts' => $posts
            ]
        );
    }
}
