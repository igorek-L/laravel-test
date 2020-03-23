<?php

namespace App\Http\Controllers\Comment;

use App\Services\CommentsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        if($this->commentsService->addComment($request)){
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
                'status' => "304",
                'message' => "Something went wrong please try again later",
            ]
        );
    }
}
