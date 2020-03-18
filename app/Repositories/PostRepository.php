<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class PostRepository
{

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPosts()
    {

        return  $posts = DB::table('posts')->select('title', 'description', 'created_at')
            ->where('post_status','Published / Declined')
            ->orderBy('created_at','desc')->paginate(10);
    }

    /**
     * @param $postId
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getPost($postId)
    {
     return   $post =  DB::table('users')
            ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
            ->select('posts.title', 'posts.description', 'posts.post_status',
                DB::raw('users.id as author_id'),
                DB::raw('users.name as author_name'),
                'posts.image', 'posts.relative_path_to_image')
            ->where('posts.id',$postId)->get();
    }
}
