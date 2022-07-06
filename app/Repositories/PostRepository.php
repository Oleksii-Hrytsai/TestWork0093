<?php

namespace App\Repositories;

use App\Models\Posts;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{

    public function all():array
    {
       return Posts::all()->toArray();
    }

    public function findPost(int $id):Posts
    {
        return Posts::find($id);
    }

    public function create($request): Posts
    {
        return Posts::create($request);
    }

    public function edit(int $id):Posts
    {
        return $this->findPost($id);
    }

    public function update(int $id, $request):Posts
    {
        $post = $this->findPost($id);

        $input = $request->validated();

        $post->update($input);

        return $post;
    }

    public function delete(int $id):bool
    {
        $post = $this->findPost($id);

        return $post->delete();
    }


}
