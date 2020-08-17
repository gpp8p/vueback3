<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;
use App\User;
use App\Org;
use Response;

class JWTAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'loggedInUser']]);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|between:2,100',
            'email' => 'required|email|unique:users|max:50',
            'password' => 'required|confirmed|string|min:6',
        ]);

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'Successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $inData = $request->all();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

//        $newToken = $this->createNewToken($token);
        $thisUserName = auth()->user()->name;
        $thisUserId =auth()->user()->id;
        $thisUserIsAdmin = auth()->user()->is_admin;

        $defaultOrg = $inData['default_org'];
        $thisOrgInstance = new Org;
        $orgInfo = $thisOrgInstance->getOrgHome($defaultOrg);

        return Response::json(array('userName'=>$thisUserName, 'orgId'=>$orgInfo[0]->id, 'orgHome'=>$orgInfo[0]->top_layout_id, 'userId'=>$thisUserId, 'is_admin'=>$thisUserIsAdmin, 'access_token' => $token, 'token_type' => 'bearer', 'expires_in' => auth()->factory()->getTTL() * 60));

//        return response($newToken);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
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
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        $thisUserName = auth()->user()->name;
        $thisUserId =auth()->user()->id;
        $thisUserIsAdmin = auth()->user()->is_admin;

        return response()->json([
            'userName'=>$thisUserName,
            'userId'=>$thisUserId,
            'is_admin'=>$thisUserIsAdmin,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


    public function guestLogin(){
        $guestCredentials = ['email'=>'guest@nomail.com', 'password'=>'guest'];
        $guestToken = auth()->attempt($guestCredentials);
        return $this->createNewToken($guestToken);
    }

    public function getLoggedInUser(Request $request)
    {
        if(auth()->user()!=null){
            return $this->createNewToken(auth()->refresh());
        }else{
            $this->guestLogin();
            return $this->createNewToken(auth()->refresh());
        }
    }

    public function setCookie(Request $request){
        $inData = $request->all();
        $token = $inData['token'];
        $cookie = cookie(
            'access_token',
            $token,
            auth()->factory()->getTTL() * 60,
            null,
            null,
            false,
            false
        );
        return Response::make('Ok')->withCookie($cookie);




    }
}
