<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Events\Auth\SignedOut;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Traits\Auth\AuthenticatesUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group Authentication
 *
 * API forr user authentication on the platform
 *
 * Class LoginController
 * @package App\Http\Controllers\Api\Auth
 */
class LoginController extends Controller
{
    use AuthenticatesUser;


    public function __construct(
        private readonly UserRepositoryContract $userRepository
    ){}


    /**
     * Sign In
     *
     * Authenticate a guest user
     * @unauthenticated
     *
     * Sign in a guest user
     *
     * @bodyParam email string required The email of the user
     * @bodyParam password string required The password of the user
     *
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $fields = $request->validated();

        $request_user = $this->userRepository->getByEmail($fields['email']);

        if(!$request_user || !Hash::check($fields['password'], $request_user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials!'
            ], HTTP_STATUS_UNAUTHENTICATED);
        }

        $token = $this->authenticate($request, $request_user);
        return $this->sendResponse([
            'user' => new UserResource($request_user),
            'token' => $token,
        ],'User Authenticated!');
    }


    /**
     * Sign Out
     *
     * Sign out an authenticated user from current active device
     * @authenticated
     *
     * @response {
     * "status" => "success",
     * "message" => "Signed out!"
     * }
     *
     * @param LogoutRequest $request
     * @return JsonResponse
     */
    final public function logout(LogoutRequest $request): JsonResponse
    {
        
        $user = $request->user();
        $requestData = [
            'last_activity_at' => now(),
        ];

        auth()->logout();

        event(new SignedOut($user, $requestData));

        return $this->sendSuccess('Signed out!');
    }

  

    /**
     * Get User Data
     *
     * Get an authenticated user data
     * @authenticated
     *
     * @responseFile status=200 storage/responses/user.get.json
     *
     * @param GetUserRequest $request
     * @return JsonResponse
     */
    final public function getUser(GetUserRequest $request): JsonResponse
    {

        return $this->sendResponse(new UserResource($request->user()));
    }
}
