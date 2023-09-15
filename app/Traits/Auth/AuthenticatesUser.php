<?php


namespace App\Traits\Auth;


use App\Events\Auth\Authenticated;
use Illuminate\Http\Request;
use App\Traits\HasApiResponse;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

trait AuthenticatesUser
{
    use HasApiResponse;

    /**
     * @param Request $request
     * @param Authenticatable $user
     * @return string
     */
    private function authenticate(Request $request, Authenticatable $user): string
    {
        $credentials = $request->only(['email', 'password']);
        $token = Auth::attempt($credentials);

        event(new Authenticated($user, [
            'user_agent' => $request->header('user-agent'),
            'ip' => $request->ip(),
            'login_at' => now(),
        ]));

        return $token;
    }

}
