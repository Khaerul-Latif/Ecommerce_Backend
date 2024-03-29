<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="User"
 * )
 */
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Registration for user
     * @OA\Post (
     *     path="/api/register",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *
     *                      @OA\Property(
     *                          property="password",
     *                          type="integer"
     *                      )
     *                 ),
     *                 example={
     *                     "name":"John",
     *                     "email":"john@test.com",
     *                     "password": 123456
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *            @OA\Property(property="message", type="string", example=null),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="number", example=422),
     *                  @OA\Property(property="status", type="string", example="error"),
     *                  @OA\Property(property="message", type="object",
     *                      @OA\Property(property="email", type="array", collectionFormat="multi",
     *                        @OA\Items(
     *                          type="string",
     *                          example="The email has already been taken.",
     *                          )
     *                      ),
     *                  ),
     *              ),
     *              @OA\Property(property="data", type="object", example={}),
     *          )
     *      )
     * )
     */
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            'role' => 'nullable|in:admin,user', // 'admin' or 'user
            "password" => "required",
        ]);


        $role = $request->filled('role') ? $request->role : 'user';

        // User Model
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role" => $role
        ]);

        // Response
        return response()->json([
            "status" => "success",

            "message" => "User registered successfully"
        ]);
    }


    /**
     * Logs user into the system
     * @OA\Post (
     *     path="/api/login",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     type="object",
     *                     @OA\Property(
     *                         property="email",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="password",
     *                         type="integer"
     *                     )
     *                 ),
     *                 example={
     *                     "email":"john@test.com",
     *                     "password": 123456
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="User logged in succcessfully"),
     *              @OA\Property(property="role", type="string", example="user"),
     *               @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL3JlZnJlc2giLCJpYXQiOjE3MDk2ODgxOTIsImV4cCI6MTcwOTY5MjE1NiwibmJmIjoxNzA5Njg4NTU2LCJqdGkiOiJ2YW9KcmVpYTljQnJFMk9JIiwic3ViIjoiMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.ZkAy7rkEYenIctn3xJujwAanqJuFf4KoRH-QvA_hO38"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Unauthorized"),
     *          )
     *      )
     * )
     */

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);


        $token = JWTAuth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ]);
        $role = auth()->user()->role;

        if (!empty($token)) {


            return response()->json([
                "status" => true,
                "message" => "User logged in succcessfully",
                "role" => $role,
                "token" => $token
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Invalid details"
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * Get the authenticated User.
     * @OA\Get (
     *     path="/api/me",
     *     tags={"User"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *   @OA\Property(property="status", type="boolean", example=true),
     *   @OA\Property(property="message", type="boolean", example="Profile data"),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="number", example=1),
     *                  @OA\Property(property="name", type="string", example="John"),
     *                  @OA\Property(property="email", type="string", example="john@test.com"),
     *                  @OA\Property(property="email_verified_at", type="string", example=null),
     *                  @OA\Property(property="updated_at", type="string", example="2022-06-28 06:06:17"),
     *                  @OA\Property(property="created_at", type="string", example="2022-06-28 06:06:17"),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Unauthorized"),
     *          )
     *      )
     * )
     */
    public function me()
    {
        $userdata = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "Profile data",
            "data" => $userdata
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/users",
     *      operationId="getAllUsers",
     *      tags={"User"},
     *      summary="Get all users",
     *      description="Returns list of all users",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *
     *             @OA\Property(property="users", type="object",
     *                  @OA\Property(property="id", type="number", example=1),
     *                  @OA\Property(property="name", type="string", example="John"),
     *                  @OA\Property(property="email", type="string", example="john@test.com"),
     *                  @OA\Property(property="email_verified_at", type="string", example=null),
     *                  @OA\Property(property="updated_at", type="string", example="2022-06-28 06:06:17"),
     *                  @OA\Property(property="created_at", type="string", example="2022-06-28 06:06:17"),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function getAllUsers()
    {
        $users = User::all();
    return response()->json(['users' => $users]);
    }


    /**
     * @OA\Delete(
     *      path="/api/users/{id}",
     *      operationId="deleteUser",
     *      tags={"User"},
     *      summary="Delete user by ID",
     *      description="Delete user by user ID",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="User ID",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="User berhasil dihapus")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User tidak ditemukan"
     *      )
     * )
     */
    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User berhasil dihapus']);
    }
    /**
     * @OA\Put(
     *     path="/api/change-password",
     *     tags={"User"},
     *     security={{ "bearerAuth": {} }},
     *     summary="Change user's password",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"current_password", "new_password"},
     *                 @OA\Property(
     *                     property="current_password",
     *                     type="string",
     *                     format="password",
     *                     description="Current password"
     *                 ),
     *                 @OA\Property(
     *                     property="new_password",
     *                     type="string",
     *                     format="password",
     *                     minLength=6,
     *                     description="New password (min: 6 characters)"
     *                 ),
     *                 example={"current_password": "oldpassword", "new_password": "newpassword"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Password berhasil diubah")
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Password salah")
     *          )
     *     )
     * )
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Password salah'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password berhasil diubah']);
    }

    /**
     * @OA\Put(
     *     path="/api/update-profile",
     *     tags={"User"},
     *     security={{ "bearerAuth": {} }},
     *     summary="Update user's profile",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"name", "phone_number"},
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="User's name"
     *                 ),
     *                 @OA\Property(
     *                     property="phone_number",
     *                     type="string",
     *                     description="User's phone number"
     *                 ),
     *                 @OA\Property(
     *                     property="url_profile",
     *                     type="string",
     *                     format="url",
     *                     nullable=true,
     *                     description="URL to user's profile picture"
     *                 ),
     *                 example={"name": "John Doe", "phone_number": "123456789", "url_profile": "http://example.com/profile.jpg"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Profile berhasil diubah")
     *          )
     *     ),
     *     @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The given data was invalid.")
     *          )
     *     )
     * )
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone_number' => 'required|string',
            'url_profile' => 'nullable|url',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->url_profile = $request->url_profile;
        $user->save();

        return response()->json(['message' => 'Profile berhasil diubah']);
    }


    /**
     * @OA\Put(
     *      path="/api/users/{id}/change-role",
     *      operationId="changeUserRole",
     *      tags={"User"},
     *      summary="Change user's role",
     *      description="Change user's role by user ID",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="User ID",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  required={"role"},
     *                  @OA\Property(
     *                      property="role",
     *                      type="string",
     *                      enum={"admin", "user"},
     *                      description="New role for the user"
     *                  ),
     *                  example={"role": "admin"}
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="User role berhasil terupdate")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User tidak ditemukan",
     *  @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="User tidak ditemukan")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error"
     *      )
     * )
     */

    public function changeUserRole(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|in:admin,user',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 404);
        }

        $user->role = $request->role;
        $user->save();

        return response()->json(['message' => 'User role berhasil terupdate']);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
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
