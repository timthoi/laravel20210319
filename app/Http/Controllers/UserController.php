<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class UserController extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * Get pagination users
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request) {
        $userModel = new User();
        $selectRaw = "first_name, last_name, phone, password";
        $whereRaw = 'is_deleted <> 1 AND id>5';
        
        
        $users = $userModel->getListUsers($selectRaw);
        
        return $users;
    }
    
    /**
     * Get detail user
     *
     * @param $id
     *
     * @return mixed
     */
    public function show($id) {
        // ket noi database: truy xuat users get user theo user id
        $userModel = new User();
        $users = $userModel->getDetailUser($id);
        
        // Neu khong tim thhay
        if (empty($users)) {
            return [
                'code' => 0,
                "data" => []
            ];
        }
        
        $result = [
            'code' => 1,
            "data" => [
                $users
            ]
        ];
        
        return $result;
    }
    
    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function store(UserCreateRequest $request) {
        
        $user = User::create([
                                 'first_name' => $request->input('first_name'),
                                 'last_name' => $request->input('last_name'),
                                 'email' => $request->input('email'),
                                 'phone' => $request->input('phone'),
                                 'password' => Hash::make($request->input('password'))
                             ]);
        
        return response($user, 201);
    }
    
    /**
     * @param  Request  $request
     * @param  int  $id
     *
     * @return array
     */
    public function update(UserUpdateRequest $request, $id) {
        // instance user
        $user = User::find($id);
        
        // Not find user
        if (empty($user)) {
            return [
                'code' => 0,
                "data" => []
            ];
        }
    
        $dataRequest = $request->only('first_name', 'last_name', 'email', 'phone', 'password');
     
        $user->update($dataRequest);
        
        return [
            'code' => 1,
            "data" => [$user]
        ];
        
    }
    
    /**
     * Hard delete
     * Soft delete
     *
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id) {
        //        User::destroy($id);
        //
        //        return User::find($id);
    }
    
    /**
     * Soft delete
     * Soft delete
     *
     * @param $id
     *
     * @return mixed
     */
    public function softDelete($id) {
        // instance user
        $user = User::find($id);
        
        $user->update([
                          'is_deleted' => 1
                      ]);
        
        return response($user, Response::HTTP_ACCEPTED);
        
        //        User::destroy($id);
        //
        //        return User::find($id);
    }
}