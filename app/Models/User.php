<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable {
    use HasFactory, Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'is_deleted'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    //    protected $hidden = [
    //        'password',
    //        'remember_token',
    //    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    //    protected $casts = [
    //        'email_verified_at' => 'datetime',
    //    ];
    
    
    /**
     * Get list users
     *
     * @return \Illuminate\Support\Collection
     */
    public function getListUsers() {
        $selectRaw = "first_name, last_name, phone, password";
        $whereRaw = 'is_deleted <> 1 AND id>5';
        
        
        
        
        
        
        
        $query = DB::table($this->getTable())
                   ->selectRaw($selectRaw)
                   ->whereRaw($whereRaw);
        
        $users = $query->get();
        //$queryRawSQL = $query->toSql();
        
        return $users;
    }
    
    /**
     * Get detail user
     *
     * @param int $id
     * @return \Illuminate\Support\Collection
     */
    public function getDetailUser(int $id) {
        $query = DB::table($this->getTable())
                   ->selectRaw("first_name, last_name, phone")
                   ->whereRaw("id = ?", [$id])
                   ->where('is_deleted', '<>', 1);
        
      
//        $queryRawSQL = $query->toSql();
        
//        echo "<pre>";
//        print_r($queryRawSQL);die;
        
        $users = $query->first();
        
        return $users;
    }
    
}
