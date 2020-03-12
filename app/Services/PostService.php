<?php

namespace App\Services;


use App\Post;

class PostService
{
    /**
     * @param $request
     * @return bool
     */
    public function createPost($request)
    {
        $data = $request->all();
        $post = new Post();
        $post->title = $data['title'];
        $post->description = $data['description'];
        $post->relative_path_to_image = $data['path'];
        $post->image = $data['image_name'];
        $post->user_id = $request->user()->id;
        $post->post_status = Post::POST_STATUS_DRAFT;

        return $post->save() ? true : false;

    }
}
