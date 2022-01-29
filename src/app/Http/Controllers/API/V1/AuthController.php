<?php

namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\Controller;

use App\Models\User;

use App\Http\Resources\API\V1\UserResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Register a new user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:150'],
            'last_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:150', Rule::unique('user', 'email')],
            'password' => ['required', 'string', 'min:6', 'max:50'],
        ], [], [
            'first_name' => 'Name',
            'last_name' => 'Surname',
            'email' => 'E-Mail',
            'password' => 'Password',
        ]);

        // set
        $retarr = [
            'status' => 1,
            'message' => 'Registration was successfully.',
            'errors' => [],
       ];
        $token = null;

        // check
        if($validator->fails()){
            // set
            $errors = $validator->errors();
            $errors = collect($errors->toArray())->flatten(1)->all();

            // update
            $retarr['status'] = 0;
            $retarr['message'] = 'Registration failed.';
            $retarr['errors'] = $errors;
        }else{
            // create
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile_number' => $request->mobile_number,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 'enabled',
            ]);

            // create- disabled until needed
            //event(new Registered($user));

            // login
            $token = auth('api')->login($user);

            // set
            $retarr['data'] = new UserResource($user);
        }

        // return
        return ($token && $retarr['status']) ? $this->respondWithToken(auth('api')->refresh(), $retarr) : $this->respondWithoutToken($retarr);
    }

    /**
     * Authenticate user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        // set
        $credentials = request(['email', 'password']);

        // validator
        $validator = Validator::make($credentials, [
            'email' => ['required', 'string', 'email', 'max:50'],
            'password' => ['required', 'string', 'max:50'],
        ]);

        // set
        $retarr = [
            'status' => 1,
            'message' => 'Login was successful.',
            'errors' => [],
        ];
        $token = null;

        // check
        if($validator->fails()){
            // set
            $errors = $validator->errors();
            $errors = collect($errors->toArray())->flatten(1)->all();

            // update
            $retarr['status'] = 0;
            $retarr['message'] = 'Login failed.';
            $retarr['errors'] = $errors;
        }else{
            // attempt
            $token = auth('api')->attempt($credentials);

            // set
            $claims = [
                'user_name' => ($token) ? auth('api')->user()->fullname : null,
                'user_email' => ($token) ? auth('api')->user()->email : null,
            ];

            // check
            if(!$token){
                // update
                $retarr['status'] = 0;
                $retarr['message'] = 'Login failed.';
                $retarr['errors'] = ['Your e-mail address or password is incorrect, please try again.'];
            }else{
                if(auth('api')->user()->status != 'enabled'){
                    // update
                    $retarr['status'] = 0;
                    $retarr['message'] = 'Login failed.';
                    $retarr['errors'] = ['Your profile is inactive, please contact your administrator.'];
                }
                if(!auth('api')->user()->hasVerifiedEmail()){
                    // update
                    $retarr['status'] = 0;
                    $retarr['message'] = 'Login failed.';
                    $retarr['errors'] = ['Your e-mail address needs to be verified. Please check your e-mail.'];

                    // send e-mail
                    auth('api')->user()->sendEmailVerificationNotification();
                }
            }

            // check
            if($retarr['status']){
                // set
                $retarr['data'] = new UserResource( auth('api')->user() );
            }
        }

        // return
        return ($token && $retarr['status']) ? $this->respondWithToken(auth('api')->claims($claims)->refresh(), $retarr) : $this->respondWithoutToken($retarr);
    }

    /**
     * Reset the password.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword()
    {
        // set
        $request = request(['email']);

        // validator
        $validator = Validator::make($request, [
            'email' => ['required', 'string', 'email', 'max:50'],
        ]);

        // set
        $retarr = [
                'status' => 1,
                'message' => 'A recovery e-mail was sent to your e-mail address.',
                'errors' => [],
            ];

        // check
        if($validator->fails()){
            // set
            $errors = $validator->errors();
            $errors = collect($errors->toArray())->flatten(1)->all();

            // update
            $retarr['status'] = 0;
            $retarr['message'] = 'Password recovery failed.';
            $retarr['errors'] = $errors;
        }else{
            // get
            $user = User::where('email', strtolower(trim($request['email'])))->get();

            // check
            if($user->isEmpty()){
                // update
                $retarr['status'] = 0;
                $retarr['message'] = 'Password recovery failed.';
                $retarr['errors'] = ['The e-mail address is not registered, please try again.'];
            }else{
                // reset
                $response = $this->broker()->sendResetLink($request);

                // check
                if(!Password::RESET_LINK_SENT){
                    // update
                    $retarr['status'] = 0;
                    $retarr['message'] = 'Password recovery failed.';
                    $retarr['errors'] = ['There was a problem sending the recovery e-mail, please contact the administrator.'];
                }
            }
        }

        // return
        return $this->respondWithoutToken($retarr);
    }

    /**
     * Refresh the token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken()
    {
    	// try/catch
		try {
			// refresh
			$token = auth('api')->refresh();

			// send
			$retarr = [
				'status' => 1,
				'message' =>'The token was successfully refreshed.',
			];

			// return
			return $this->respondWithToken($token, $retarr);
		} catch (TokenExpiredException $e) {
			return response()->json(['status' => 0, 'message' => 'Token has expired and can no longer be refreshed.'], 401);
		}
    }

    /**
     * Responds without as token.
     *
     * @param $retarr
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithoutToken($retarr)
    {
        return response()->json($retarr);
    }

    /**
     * Respond with a token.
     *
     * @param $token
     * @param $retarr
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $retarr)
    {
       return response()->json(array_merge($retarr, [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60
        ]));
    }

    /**
     * Pings the server.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function ping()
    {
        return response()->json(['status' => 1]);
    }
}
