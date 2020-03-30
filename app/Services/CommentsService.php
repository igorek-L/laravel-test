<?php

namespace App\Services;

use App\Comments;
use App\Http\Requests\CreatePostCommentRequest;

/**
 * Class CommentsService
 * @package App\Services
 */
class CommentsService
{
    /**
     * @param CreatePostCommentRequest $request
     * @return bool
     */
    public function addComment(CreatePostCommentRequest $request): bool
    {
        $data = $request->all();

        $comment = new Comments();
        $comment->message = $data['message'];
        $comment->comment_status = Comments::COMMENT_STATUS_READY_FOR_REVIEW;
        $comment->user_id = $request->user()->id;
        $comment->post_id = $data['post_id'];

        return $comment->save() ? true : false;
    }
}
