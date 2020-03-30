<?php

namespace App\Services;

use App\Http\Requests\CreatePostRequest;
use App\Post;

/**
 * Class PostService
 * @package App\Services
 */
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
     * @param CreatePostRequest $request
     * @return bool
     */
    public function createPost(CreatePostRequest $request): bool
    {
        $post = new Post();

        $data = $request->all();

        if (!empty($data['path']) && !empty($data['image_name'])) {
            $file = public_path() . $data['path'] . $data['image_name'];
        }
        if (isset($file) && file_exists($file)) {
            $this->mediaService->resizeAndSaveImageByConfig($data['path'], $data['image_name'], Post::POST_KEY_CONFIG);
            $post->image = $data['image_name'];
            $post->relative_path_to_image = $data['path'];
        }

        $post->title = $data['title'];
        $post->description = $data['description'];
        $post->user_id = $request->user()->id;
        $post->post_status = Post::POST_STATUS_DRAFT;

        return $post->save() ? true : false;
    }
}
