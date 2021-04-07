<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Illuminate\Pagination\Paginator;

class UserTitle extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'usertitles';
    protected $primaryKey = 'user_title_id';
    protected $fillable = [
        'user_title_id',
        'user_id',
        'title_id',
        'user_id',
        'created_by',
        'created_date',
        'modified_by',
        'modified_date',
        'is_deleted',
        'data'
    ];
    
    // Return properties to class parent
    protected function getTableInfo() {
        $result = [
            'name' => $this->table,
            'alias' => $this->table . ' as ut',
            'primaryKey' => $this->primaryKey,
        ];
        
        return (object) $result;
    }
}
