<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UtilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    //
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        Log::debug("Step 0: check validation which whether valid or not : " . $validator->errors()->first());
        if ($validator->fails()) {
            Log::debug("Step 1: username or password validation error : " . $validator->errors()->first());
            return UtilityService::response(RESPONSE_NO, $validator->errors()->first(), RESPONSE_NULL);
        }
        Log::info("Step 2 username and password are validated so login is processing , $request->email, $request->password");

        // $credentials = request(['email', 'password']);
        Log::info("Step 3 Check username and password is valid or not from database");
        if (!$token = auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return UtilityService::response(RESPONSE_NO, MSG_USER_LOGIN_FAIL, RESPONSE_NULL);
            Log::info("Step 4 Check username or password are not valid");
        }
        Log::info("Step 4 token is generated :- " . $token);
        //return Auth::user();
        $user = Auth::user();
        return $this->respondWithToken($token);
    }
    public function updateProfile(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'email' => ['required'],
            'first_name' => ['required'],
            'last_name' => ['required'],
        ]);
        Log::info("Step 1: check validation which whether valid or not : " . $validator->errors()->first());
        if ($validator->fails()) {
            Log::debug("Step 2:  validation error : " . $validator->errors()->first());
            return UtilityService::response(RESPONSE_NO, $validator->errors()->first(), RESPONSE_NULL);
        }
        Log::info("Step 2 validation success");
        $user = Auth::user();
        if ($user) {
            if (User::where('email', $request->email)->where('id', '!=', $user->id)->first()) {
                Log::info("Step 3 email already exist" . $request->email);
                return UtilityService::response(RESPONSE_NO, MSG_EMAIL_ALREADY_EXIST, RESPONSE_NULL);
            }
            $userData = User::where('id', Auth::user()->id)->update(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'email' => $request->email, 'phone_no' => $request->phone_no]);
            Log::info("Step 3 Update profile successfully user_id" . $user->id);
            // unset($user->access_token);
            // $userData->user = $user;
            $data = compact('userData');
            return UtilityService::response(RESPONSE_YES, MSG_PROFILE_CHANGE_SUCESS, $data);
        }
        return UtilityService::response(RESPONSE_YES, MSG_UNAUTHORISED_USER, RESPONSE_NULL);
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Log::info("Step 1: check auth status which whether valid or not : ");
        if (Auth::check()) {
            Log::info("Step 2: user successfully logout user_id: " . Auth::user()->id);
            auth::logout();
            return UtilityService::response(RESPONSE_YES, MSG_USER_LOGOUT_SUCCESS, RESPONSE_NULL);
        }
        Log::debug("Step 2: user is not valid ");
        return UtilityService::response(RESPONSE_NO, MSG_UNAUTHORISED_USER, RESPONSE_NULL, 401);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
