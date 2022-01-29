<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use App\Http\Resources\API\V1\UserResource;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = [
            'data' => UserResource::collection( User::all() )
        ];

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:150'],
            'last_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:150', Rule::unique('user', 'email')],
            'password' => ['required', 'string', 'min:6', 'max:50'],
        ], [], [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'E-Mail',
            'password' => 'Password',
        ]);

        // check
        if($validator->fails()){
            // set
            $errors = $validator->errors();
            $errors = collect($errors->toArray())->flatten(1)->all();

            // set
            $response = [
                'status' => 0,
                'message' => 'The user could not be created.',
                'errors' => $errors,
            ];
        }else{
            // try/catch
            try {
                // create
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'user_name' => $request->email,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'status' => 'enabled',
                ]);

                // create - disabled until needed
                //event(new Registered($user));

                // set
                $data = new UserResource($user);

                // set
                $response = [
                    'status' => 1,
                    'message' => 'The user was successfully created.',
                    'data' => $data,
                ];
            } catch (ModelNotFoundException $e) {
                // set
                $response = [
                    'status' => 0,
                    'message' => 'The user could not be created.',
                    'errors' => [],
                ];
            }
        }

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // try/catch
        try {
            // find
            $user = User::findOrFail($id);

            // set
            $data = new UserResource($user);

            // set
            $response = [
                'status' => 1,
                'message' => 'The user was successfully found.',
                'data' => $data,
            ];
        } catch (ModelNotFoundException $e) {
            // set
            $response = [
                'status' => 0,
                'message' => 'No such user exists.',
            ];
        }

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:150'],
            'last_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:150', Rule::unique('user', 'email')->ignore($id, 'id')],
            'password' => ['sometimes', 'required', 'string', 'min:6', 'max:50'],
        ], [], [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'E-Mail',
            'password' => 'Password',
        ]);

        // check
        if($validator->fails()){
            // set
            $errors = $validator->errors();
            $errors = collect($errors->toArray())->flatten(1)->all();

            // set
            $response = [
                'status' => 0,
                'message' => 'The user could not be updated.',
                'errors' => $errors,
            ];
        }else{
            // try/catch
            try {
                // find
                $user = User::findOrFail($id);

                // update
                $user->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'user_name' => $request->email,
                    'email' => $request->email,
                ]);
                if($request->password){
                    $user->update([
                        'password' => Hash::make($request->password),
                    ]);
                }

                // set
                $data = new UserResource($user);

                // set
                $response = [
                    'status' => 1,
                    'message' => 'The user was successfully updated.',
                    'data' => $data,
                ];
            } catch (ModelNotFoundException $e) {
                // set
                $response = [
                    'status' => 0,
                    'message' => 'The user could not be updated.',
                    'errors' => [],
                ];
            }
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // try/catch
        try {
            // find
            $user = User::findOrFail($id);

            // delete
            $user->delete();

            // set
            $response = [
                'status' => 1,
                'message' => 'The user was successfully deleted.',
            ];
        } catch (ModelNotFoundException $e) {
            // set
            $response = [
                'status' => 0,
                'message' => 'The user could not be deleted',
            ];
        }

        return response()->json($response);
    }
}
