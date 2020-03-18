<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CommentsRepository
{
    /**
     * @param $postId
     * @return \Illuminate\Support\Collection
     */
    public function getComments($postId)
    {
        return  $comments = DB::table('comments')
            ->leftJoin('users', 'comments.user_id', '=', 'users.id')
            ->select(
                DB::raw('users.id as author_id'),
                DB::raw('users.name as author_name'),
                'comments.message', 'comments.created_at'
            )
            ->where('post_id',$postId)->orderBy('comments.created_at', 'desc')
            ->paginate(10);
    }
}
