<?php

namespace App\Repositories;

use App\Post;
use Illuminate\Support\Facades\DB;

class PostRepository
{

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPosts()
    {

        return $posts = DB::table('posts')->select('title', 'description', 'created_at')
            ->where('post_status', Post::POST_STATUS_PUBLISHED)
            ->orderBy('created_at', 'desc')->paginate(10);
    }

    /**
     * @param $postId
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getPost($postId)
    {
        $postStatus = $this->checkIsPostPublishedById($postId);
        if ($postStatus) {
            return $post = DB::table('posts')
                ->leftJoin('users', 'users.id', '=', 'posts.user_id')
                ->select('posts.title', 'posts.description', 'posts.post_status',
                    DB::raw('users.id as author_id'),
                    DB::raw('users.name as author_name'),
                    'posts.image', 'posts.relative_path_to_image')
                ->where('posts.id', $postId)->get();
        }

        return $postStatus;
    }

    /**
     * @param $postId
     * @return bool
     */
    public function checkIsPostPublishedById($postId)
    {
        return
            Post::POST_STATUS_PUBLISHED == DB::table('posts')
                ->select('post_status')
                ->where('id', $postId)->get()->first()->post_status ? true : false;
    }
}
