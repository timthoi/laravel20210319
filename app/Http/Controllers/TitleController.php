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


class TitleController extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * Get pagination users
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTitles(Request $request) {
    
        $result = [
            'code' => 1,
            "data" => [
                [
                    "title_id" => 1,
                    "title_name" => "Giam doc",
                ],
                [
                    "title_id" => 2,
                    "title_name" => "Chu tich hoi dong quna tri",
                ],
            ]
        ];
        
        return $result;
    }
}