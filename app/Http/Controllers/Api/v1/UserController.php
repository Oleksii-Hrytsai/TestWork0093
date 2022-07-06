<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\User\UserRegisterRequest;
use App\Http\Traits\UserTrait;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    use UserTrait;

    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function login(UserLoginRequest $request)
    {
        $credentials = $request->validated();

        if(Auth::attempt($credentials)) {
            $success = true;
            $message = "User login successfully";
        } else {
            $success = false;
            $message = "Unautorised";
        }

        $response = $this->stutus($success,$message);

        return response()->json($response);
    }


    public function register(UserRegisterRequest $request)
    {
        try {
            $this->repository->create($request->name, $request->email, $request->password);

            $success = true;
            $message = "User register successfully";

        } catch (QueryException $e) {
            $success = false;
            $message = $e->getMessage();
        }

        $response = $this->stutus($success,$message);

        return response()->json($response);

    }


    public function logout()
    {
        try {
            Session::flush();
            $success = true;
            $message = "Logout successfully";
        } catch (QueryException $e) {
            $success = false;
            $message = $e->getMessage();
        }

        $response = $this->stutus($success,$message);

        return response()->json($response);
    }
}
