<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Title;
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

require_once '..\constants.php';

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
     * Lấy danh sách user cho user login chỉ bao gồm thông tin: first last_name
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getLisLoginUsers(Request $request) {
        
        $userModel = new User();
        $selectRaw = "first_name, last_name";
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
    
        $selectRawQuery = [
            [
                'strRaw' => 'u.first_name, u.last_name, u.phone, u.email',
                'params' => [],
            ]
        ];
    
        $whereRawQuery = [
            [
                'strRaw' => 'u.is_deleted <> ? AND u.user_id = ?',
                'params' => [1, $id],
            ]
        ];
        
        $users = $userModel->getDetailUser($selectRawQuery, $whereRawQuery);
        
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
     * Get info user
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function getInfoUser(Request $request) {
//        $result = [
//            'code' => 1,
//            "data" => [
//                "first_name" => "hoangnd1",
//                "last_name" => "nguyen1",
//                "phone" => "098712323",
//                "password" => '$2y$10$EEBSc5/PAZv0UcFdphwppekRXH3vQY/6RTEAb3HJ4nS7en4umXaFS',
//                'titles' =>[
//                    [
//                        "title_id" => 1,
//                        "title_name" => "Giam doc",
//                    ],
//                    [
//                        "title_id" => 2,
//                        "title_name" => "Chu tich hoi dong quna tri",
//                    ],
//                ]
//            ]
//        ];
//
//        return $result;
    
      
        $userId = $request->user()->user_id;
      
        $userModel = new User();
        $selectRawQuery = [
            [
                'strRaw' => 'u.first_name, u.last_name, u.phone, u.email, u.code, u.dob, u.title_id, u.gender_id, u.country_id, u.email,
                    GROUP_CONCAT(CONCAT(\'{title_id:"\', t.title_id, \'", title_name:"\',t.title_name,\'"}\')) as titles',
                'params' => [],
            ]
        ];
 
        $whereRawQuery = [
            [
                'strRaw' => 'u.is_deleted <> ? AND u.user_id = ?',
                'params' => [INT_DEFAULT_TRUE, $userId],
            ]
        ];
    
        $users =  $userModel->getDetailUser($selectRawQuery, $whereRawQuery);
        
        // Neu khong tim thhay
        if (empty($users)) {
            return [
                'code' => 0,
                "data" => []
            ];
        }
    
        $arrGenders = config('datasource.genders');
        //dd($arrGenders);
        foreach ($arrGenders as $gender) {
            if ($gender['gender_id'] == $users['gender_id']) {
                $users['gender_name'] = $gender['gender_name'];
                break;
            }
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