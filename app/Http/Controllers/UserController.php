<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
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
        $search = $request->input('search');
        $all = $request->all();
        
        // $users = DB::table('users')->paginate(2);
        //$users = DB::table('users')->simplePaginate(2);
        //  $users = User::where('first_name', '>', 20)->paginate(2);
        $users = User::where('is_deleted', '!=', '1')->paginate(100);
        
        return $users;
        //
        //        // ket noi database: truy xuat users get all toan bo thong tin cua users
        //        return User::all();
    }
    
    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id) {
        // ket noi database: truy xuat users get user theo user id
        $users = User::find($id);
        
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
    public function store(Request $request) {

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
     * @param $id
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        // instance user
        $user = User::find($id);
        
        $user->update([
                          'first_name' => $request->input('first_name'),
                          'last_name' => $request->input('last_name'),
                          'email' => $request->input('email'),
                          'phone' => $request->input('phone'),
                          'password' => Hash::make($request->input('password'))
                      ]);
        
        return response($user, Response::HTTP_ACCEPTED);
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