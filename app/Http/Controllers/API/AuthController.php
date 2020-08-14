<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmCustomer;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/login",
     *      operationId="loginUser",
     *      tags={"Auth"},
     *      summary="Logs user into the system",
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              @OA\Property(property="email", type="string", format="email", example="admin@gmail.com"),
     *              @OA\Property(property="password", type="string", format="password", example="admin123"),
     *          )
     *
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request")
     *     )
     *
     * Returns object
     */
    public function login(Request $request)
    {
        // return $request->all();
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Error in Login');
            }
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Login',
                'error' => $error,
            ]);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/logout",
     *      operationId="logoutUser",
     *      tags={"Auth"},
     *      summary="Logs out current logged in user session",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key": {}}
     *       }
     *     )
     *
     * Returns object
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response('logout', 201);
    }

    public function sendMail(Request $request)
    {
        // return $request->all();
        Mail::to($request->email)->send(new ConfirmCustomer($request));
        return response('Send Mail Success', 200);
    }
}
