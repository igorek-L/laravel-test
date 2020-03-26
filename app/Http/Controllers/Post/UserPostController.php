<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Repositories\{PostRepository, UserRepository};
use Illuminate\Http\Request;

/**
 * Class UserPostController
 * @package App\Http\Controllers\Post
 */
class UserPostController extends Controller
{
    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserPostController constructor.
     * @param PostRepository $repository
     * @param UserRepository $userRepository
     */
    public function __construct(
        PostRepository $repository,
        UserRepository $userRepository
    )
    {
        $this->postRepository = $repository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPosts($userId)
    {
        $user = $this->userRepository->getUserById($userId);

        if (empty($user)) {
            return \response()->json(
                [
                    "status" => "not found",
                    "message" => "User with id " . $userId . " not found.",
                    "code" => 404
                ]
            );
        }

        $posts = $this->postRepository->getAllPablishedPostsByUserId($userId);

        return \response()->json(
            [
                'Author' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'posts' => $posts,
            ]
        );
    }

    /**
     * @param Request $request
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMostCommentedPostsByYear(Request $request, $userId)
    {
        $user = $this->userRepository->getUserById($userId);

        if (empty($user)) {
            return \response()->json(
                [
                    "status" => "not found",
                    "message" => "User with id " . $userId . " not found.",
                    "code" => 404
                ]
            );
        }

        $year = $request->year;

        $posts = $this->postRepository->getMostCommentedPostsByYearForUser($userId, $year);

        if (empty($posts->first())) {
            return \response()->json(
                [
                    "status" => "not found",
                    "code" => 404
                ]
            );
        }

        return \response()->json(
            [
                'Author' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'posts' => $posts,
            ]
        );
    }
}
