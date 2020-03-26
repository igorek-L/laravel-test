<?php

namespace App\Repositories;

use App\Post;
use Illuminate\Support\Facades\DB;

/**
 * Class PostRepository
 * @package App\Repositories
 */
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
     * @param int $postId
     * @return bool|\Illuminate\Support\Collection
     */
    public function getPost(int $postId)
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
     * @param int $postId
     * @return bool
     */
    public function checkIsPostPublishedById(int $postId): bool
    {
        return Post::POST_STATUS_PUBLISHED == DB::table('posts')
            ->select('post_status')
            ->where('id', $postId)->get()->first()->post_status ? true : false;
    }

    /**
     * @param int $userId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllPablishedPostsByUserId(int $userId)
    {
        return DB::table('posts')->select(
            'id', 'title', 'description', 'post_status',
            'image', 'relative_path_to_image'
        )
            ->where([
                ['post_status', '=', Post::POST_STATUS_PUBLISHED],
                ['user_id', '=', $userId]
            ])->paginate(10);
    }

    /**
     * @param int $userId
     * @param $year
     * @return \Illuminate\Support\Collection
     */
    public function getMostCommentedPostsByYearForUser(int $userId, $year)
    {
        return DB::table('posts')
            ->Join('users', 'users.id', '=', 'posts.user_id')
            ->Join('comments', 'posts.id', '=', 'comments.post_id')
            ->select(
                DB::raw('users.id as author_id'),
                DB::raw('posts.id as post_id'),
                'posts.title', 'posts.description', 'posts.image', 'posts.relative_path_to_image',
                DB::raw('count(comments.id) as number_of_comments'))
            ->where([
                ['posts.post_status', '=', Post::POST_STATUS_PUBLISHED],
                ['users.id', '=', $userId],
                ['posts.created_at', 'like', $year . '%']
            ])
            ->groupBy('posts.id', 'users.id')
            ->orderBy('number_of_comments', 'desc')
            ->get();
    }

    /**
     * @param $year
     * @return \Illuminate\Support\Collection
     */
    public function getMostCommentedPostsByYear($year)
    {
        return DB::table('posts')
            ->Join('comments', 'posts.id', '=', 'comments.post_id')
            ->select(
                DB::raw('posts.id as post_id'),
                'posts.title', 'posts.description', 'posts.image', 'posts.relative_path_to_image',
                DB::raw('count(comments.id) as number_of_comments'))
            ->where([
                ['posts.post_status', '=', Post::POST_STATUS_PUBLISHED],
                ['posts.created_at', 'like', $year . '%']
            ])
            ->groupBy('posts.id')
            ->orderBy('number_of_comments', 'desc')
            ->limit(10)->get();
    }
}
