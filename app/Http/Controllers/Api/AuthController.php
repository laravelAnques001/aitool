<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\ForgetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string',
            'email' => 'nullable|string|email|unique:users,email',
            'mobile_number' => 'nullable|unique:users,mobile_number|digits_between:10,12',
            'image' => 'nullable|image',
            'password' => 'nullable|string|min:8',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        if ($image = $request->image) {
            $input['image'] = $image->store('public/user');
        }

        if ($request->password) {
            $input['password'] = bcrypt($input['password']);
        }

        $user = User::create($input);
        $success['token'] = $user->createToken('FriendsPointArticle')->accessToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    public function login(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
        ]);

        if ($validated->fails()) {
            return $this->sendError($validated->errors(), 'Validation Errors!');
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('FriendsPointArticle')->accessToken;
            $success['user_detail'] = new UserResource($user);
            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function otpGenerate(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'mobile_number' => 'required|exists:users,mobile_number',
        ]);
        if ($validated->fails()) {
            return $this->sendError($validated->errors(), 'Validation Errors!');
        }
        $user = User::where('mobile_number', $request->mobile_number)->first();
        $userOtp = rand(1000, 9999);
        $expire_at = now()->addMinute(10);
        $user->fill([
            'otp' => $userOtp,
            'expire_at' => $expire_at,
        ])->save();

        return $this->sendResponse([], 'User SMS Send Successfully.');
    }

    public function otpVerify(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'mobile_number' => 'required|exists:users,mobile_number',
            'otp' => 'required|numeric|digits:4',
            'device_token' => 'required|string',
        ]);

        if ($validated->fails()) {
            return $this->sendError($validated->errors(), 'Validation Errors!');
        }

        $user = User::where('mobile_number', $request->mobile_number)->where('otp', $request->otp)->where('expire_at', '>=', now())->first();
        if (!$user) {
            return $this->sendError(["otp" => ['OTP Not Valid!']], '');
        }

        $user->fill([
            'otp' => null,
            'expire_at' => null,
            'device_token' => $request->device_token,
        ])->save();

        Auth::login($user);
        $success['token'] = $user->createToken('AppExample')->accessToken;
        $success['user_detail'] = new UserResource($user);

        return $this->sendResponse($success, 'User Login Successfully.');
    }

    public function logout(Request $request)
    {
        $result = $request->user()->token()->revoke();
        if ($result) {
            return $this->sendResponse([], 'User Logout Successfully.', 200);
        } else {
            return $this->sendError([], 'Something Is Wrong.', 400);
        }
    }

    public function forgetPassword(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
        ]);

        if ($validated->fails()) {
            return $this->sendError($validated->errors(), 'Validation Error.');
        }
        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
        ]);
        $user = User::where('email', $request->email)->first();
        $user->notify(new ForgetPassword($token));
        return $this->sendResponse([], 'Send Token Your Email Successfully.', 200);
    }

    public function profileUpdate(Request $request)
    {
        $userId = auth()->id();
        $validated = Validator::make($request->all(), [
            'name' => 'nullable|string|min:3',
            'email' => 'nullable|email|unique:users,email,' . $userId,
            'mobile_number' => 'nullable|digits_between:10,12|unique:users,mobile_number,' . $userId,
            'image' => 'nullable|image',
        ]);

        if ($validated->fails()) {
            return $this->sendError($validated->errors(), 'Validation Error.');
        }
        $validated = $request->all();
        $user = User::find($userId);

        if ($image = $request->image ?? null) {
            if ($oldImage = $user->image ?? null) {
                $fileCheck = storage_path('app/' . $oldImage);
                if (file_exists($fileCheck)) {
                    unlink($fileCheck);
                }
            }
            $validated['image'] = $image->store('public/user');
        }

        $user->fill($validated)->save();
        return $this->sendResponse(new UserResource($user), 'Profile Updated SuccessFully.');
    }
}
