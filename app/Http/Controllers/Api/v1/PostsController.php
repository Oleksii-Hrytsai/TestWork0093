<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostCreateRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostsController extends Controller
{
    private PostRepositoryInterface $repository;

    public function __construct(PostRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $posts = $this->repository->all();

        return array_reverse($posts);
    }

    public function create(PostCreateRequest $request)
    {
        $data = $request->validated();

        $this->repository->create($data);

        return response()->json(['success' => 'Post created successfully']);
    }

    public function edit($id)
    {
        $post = $this->repository->edit($id);

        return response()->json($post);
    }

    public function update($id, PostUpdateRequest $request)
    {
        $this->repository->update($id,$request);

        return response()->json(['success' => 'Post update successfully']);
    }

    public function delete($id)
    {
        $this->repository->delete($id);

        return response()->json(['success'=> 'Post deleted successfully']);
    }
}
