<?php

namespace App\Services;

use App\Post;

class PostService
{
    /**
     * @var MediaService
     */
    protected $mediaService;

    /**
     * PostService constructor.
     * @param MediaService $mediaService
     */
    public function __construct(
        MediaService $mediaService
    )
    {
        $this->mediaService = $mediaService;
    }

    /**
     * @param $request
     * @return bool
     */
    public function createPost($request)
    {
        $post = new Post();

        $data = $request->all();

        $file = public_path() . $data['path'] . $data['image_name'];

        if (file_exists($file)) {
            $this->mediaService->resizeAndSaveImageByConfig($data['path'], $data['image_name'], Post::POST_KEY_CONFIG);
        }

        $post->title = $data['title'];
        $post->description = $data['description'];
        $post->relative_path_to_image = $data['path'];
        $post->image = file_exists($file) ? $data['image_name'] : '';
        $post->user_id = $request->user()->id;
        $post->post_status = Post::POST_STATUS_DRAFT;

        return $post->save() ? true : false;
    }
}
