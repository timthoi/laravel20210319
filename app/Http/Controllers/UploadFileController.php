<?php

namespace App\Http\Controllers;

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

class UploadFileController extends Controller {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function store(Request $request) {
        //dd($_FILES);
    
        $errors = array();
        $file_name = $_FILES['fileUpload']['name'];
        $file_size = $_FILES['fileUpload']['size'];
        $file_tmp = $_FILES['fileUpload']['tmp_name'];
        $file_type = $_FILES['fileUpload']['type'];
        
    
        if ($file_size > 2097152) {
            $errors[] = 'Kích cỡ file nên là 2 MB';
        }
    
        if (empty($errors) == true) {
            move_uploaded_file($file_tmp, "app/images/" . $file_name);
            echo "Thành công!!!";
        } else {
            print_r($errors);
        }
        dd($request->all());
        //return response($user, 201);
    }
    
}