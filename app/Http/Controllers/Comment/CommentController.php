<?php

namespace App\Http\Controllers\Comment;

use App\Http\Requests\CreatePostCommentRequest;
use App\Services\CommentsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class CommentController
 * @package App\Http\Controllers\Comment
 */
class CommentController extends Controller
{
    /**
     * @var CommentsService
     */
    protected $commentsService;

    /**
     * CommentController constructor.
     * @param CommentsService $commentsService
     */
    public function __construct(
        CommentsService $commentsService
    )
    {
        $this->commentsService = $commentsService;
    }

    /**
     * @param CreatePostCommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreatePostCommentRequest $request)
    {
        if ($this->commentsService->addComment($request)) {
            return \response()->json(
                [
                    "status" => "success",
                    "message" => "Comment has been added successfully",
                    "code" => 201
                ]
            );
        }

        return \response()->json(
            [
                'status' => 304,
                'message' => "Something went wrong please try again later",
            ]
        );
    }
}
