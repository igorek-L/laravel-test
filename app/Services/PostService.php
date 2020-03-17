<?php

namespace App\Services;


use App\Post;
use App\Services\MediaService;
use Illuminate\Support\Facades\DB;

class PostService
{
    protected $mediaService;

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

        $file = public_path().$data['path'] . $data['image_name'];

        if(file_exists($file)){
            $this->mediaService->resizeAndSaveImageByConfig($data['path'], $data['image_name'], Post::POST_KEY_CONFIG);
        }


        $post->title = $data['title'];
        $post->description = $data['description'];
        $post->relative_path_to_image = $data['path'];
        $post->image = file_exists($file) ? $data['image_name']: '';
        $post->user_id = $request->user()->id;
        $post->post_status = Post::POST_STATUS_DRAFT;

        return $post->save() ? true : false;

    }

    /**
     * @param int $pagination
     * @return mixed
     */
    public function getPosts($pagination = 1)
    {

        $posts = DB::table('posts')->select('title', 'description', 'created_at')
            ->where('post_status','Published / Declined')
            ->orderBy('created_at','desc')->paginate(10);

        return $posts->toJson(JSON_PRETTY_PRINT);
    }
}
