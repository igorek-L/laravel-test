<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

/**
 * Class CommentsRepository
 * @package App\Repositories
 */
class CommentsRepository
{
    /**
     * @param int $postId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getComments(int $postId)
    {
        return $comments = DB::table('comments')
            ->leftJoin('users', 'comments.user_id', '=', 'users.id')
            ->select(
                DB::raw('users.id as author_id'),
                DB::raw('users.name as author_name'),
                'comments.message', 'comments.created_at'
            )
            ->where('post_id', $postId)->orderBy('comments.created_at', 'desc')
            ->paginate(10);
    }
}
