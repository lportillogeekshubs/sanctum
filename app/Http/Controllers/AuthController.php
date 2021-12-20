<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponse;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) return $this->errorResponse('Validation Error->' . $validator->errors()->__toString());

            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
            ]);

            UserRole::create([
                'id_user' => $user['id'],
                'id_role' => 2,
            ]);

            $token = $user->createToken('auth_token', ['Standard'])->plainTextToken;

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(['message' => $e->getMessage()]);
        }

        DB::commit();
        return $this->successResponse([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->errorResponse(['message' => 'Invalid login details'], Response::HTTP_UNAUTHORIZED);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $userRoles = UserRole::where('id_user', $user['id'])->get();

        $roles = [];
        foreach ($userRoles as $index => $userRole) {
            $role = Role::findOrFail($userRole['id_role']);
            $roles[] = $role['name'];
        }

        $token = $user->createToken('auth_token', $roles)->plainTextToken;

        return $this->successResponse([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], Response::HTTP_OK);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse(['message' => 'Tokens Revoked'], Response::HTTP_OK);
    }

    public function assignRoles(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId' => 'required|numeric',
            'roles' => 'required|array',
        ]);

        if ($validator->fails()) return $this->errorResponse('Validation Error->' . $validator->errors()->__toString());

        try {
            $userId =  $request['userId'];
            $rolesNew = $request['roles'];

            foreach ($rolesNew as $role) {
                $roleId = Role::where('name', $role)->firstOrFail()->id;

                if (!is_null(UserRole::where('id_user', $userId)->where('id_role', $roleId)->first())) continue;

                UserRole::create([
                    'id_user' => $userId,
                    'id_role' => $roleId
                ]);
            }
        } catch (\Exception $e) {
            return $this->errorResponse(['message' => $e->getMessage()]);
        }

        return $this->successResponse(['message' => 'Roles Assigned'], Response::HTTP_CREATED);
    }
}
