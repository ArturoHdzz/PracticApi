<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\Correo;
use App\Models\User;
use App\Mail\VerificationCodeMail;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'activate', 'verify']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        $user = User::where('email', $credentials['email'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            
            $code = rand(100000, 999999);
            
            $encrypted_code = encrypt($code);

            $user->verification_code = $encrypted_code;
            $user->save();

            Mail::to($user->email)->send(new VerificationCodeMail($code));

            return response()->json(['message' => 'Login successful, please verify.', 'result' => true]);
        } else {
            return response()->json(['error' => 'Unauthorized', 'result' => false], 401);
        }
    }

    public function verify()
    {
        $credentials = request(['verification_code']);

        $user = User::whereNotNull('verification_code')->get()->filter(function ($user) use ($credentials) {
            return decrypt($user->verification_code) == $credentials['verification_code'];
        })->first();

        if ($user) {
            $user->verification_code = null;
            $user->save();

            $token = auth()->login($user);

            return response()->json([
                'token' => $token,
                'result' => true
            ]);
        } else {
            return response()->json(['error' => 'Invalid verification code'], 401);
        }
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
            'expires_in' => auth()->factory()->getTTL(480)
        ]);
    }

    public function register(Request $request)
    {
        $validate = Validator::make(
            $request->all(),[
                "name"=>"required|max:30",
                "email"=>"required|unique:users|email",
                "password"=>"required|min:8|string"
            ]
            );

            if($validate->fails())
            {
                return response()->json(["msg"=>"Datos incorrectos","data"=>$validate->errors()],422);
            }

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $signedroute = URL::temporarySignedRoute(
                'activate',
                now()->addMinutes(10),
                ['user' => $user->id]
            );

            Mail::to($request->email)->send(new Correo($signedroute));

            return response()->json(["msg"=>"Se mando un mensaje a tu correo","data"=>$user, "result" => true],201);
    }

    public function activate(User $user)
    {
        $user->is_active=true;
        $user->save();
    }

    public function verifytoken(){
        try{
            return response()->json(['msg'=>"Auth"],200);
        }
        catch(Exception $e){
            return response()->json(['msg'=>"Unahutorized"],401);
        }
    }

    public function roluser()
    {
        $rol = User::with('role')->find(auth()->user()->id);
        return response()->json(["role_id" => $rol->role_id]);
    }
}
