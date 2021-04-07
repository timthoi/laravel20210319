<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Illuminate\Pagination\Paginator;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'dob',
        'title_id',
        'gender_id',
        'country_id',
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
            'alias' => $this->table . ' as u',
            'primaryKey' => $this->primaryKey,
        ];
        
        return (object) $result;
    }
    
    /**
     * Get detail user
     *
     * @param  array  $selectRawQuery
     * @param  array  $whereRawQuery
     * @param  array  $orderByRawQuery
     *
     * @return array
     */
    public function getDetailUser($selectRawQuery = [], $whereRawQuery = [], $orderByRawQuery = []) {
        $query = DB::table($this->getTableInfo()->alias)
            ->leftJoin('user_titles as ut', 'ut.user_id', '=', 'u.user_id')
            ->leftJoin('titles as t', 't.title_id', '=', 'u.title_id')
            ->groupBy('u.user_id');
        
        foreach ($selectRawQuery as $itm) {
            $query->selectRaw($itm['strRaw'], $itm['params']);
        }
        foreach ($whereRawQuery as $itm) {
            $query->whereRaw($itm['strRaw'], $itm['params']);
        }
        foreach ($orderByRawQuery as $itm) {
            $query->orderByRaw($itm['strRaw'], $itm['params']);
        }
        
        $dataDetail = $query->first();
        
        return collect($dataDetail)->toArray();
    }
    
    /**
     * Get list user
     *
     * @param array $selectRawQuery
     * @param array $whereRawQuery
     * @param array $orderByRawQuery
     * @return mixed
     */
    public function getListUsers($selectRawQuery = [], $whereRawQuery = [], $orderByRawQuery = []) {
        $query = DB::table($this->getTableInfo()->alias);
        
        foreach ($selectRawQuery as $itm) {
            $query->selectRaw($itm['strRaw'], $itm['params']);
        }
        foreach ($whereRawQuery as $itm) {
            $query->whereRaw($itm['strRaw'], $itm['params']);
        }
        foreach ($orderByRawQuery as $itm) {
            $query->orderByRaw($itm['strRaw'], $itm['params']);
        }
        
        $dataList = $query->get();
        
        //$sql_with_bindings = str_replace_array('?', $query->getBindings(), $query->toSql());
        //print_r($sql_with_bindings);die;
        return json_decode($dataList, true);
    }
    
    /**
     * [getUsersListPagination description]
     *
     * @param  array  $selectRawQuery  [description]
     * @param  array  $whereRawQuery  [description]
     * @param  array  $orderByRawQuery  [description]
     * @param  array  $dataPagination  [description]
     *
     * @return array                [description]
     */
    public function getListUsersPagination($selectRawQuery = [], $whereRawQuery = [], $orderByRawQuery = [], $dataPagination = []) {
        
        $query = DB::table($this->getTableInfo()->alias);
        foreach ($selectRawQuery as $itm) {
            $query->selectRaw($itm['strRaw'], $itm['params']);
        }
        foreach ($whereRawQuery as $itm) {
            $query->whereRaw($itm['strRaw'], $itm['params']);
        }
        foreach ($orderByRawQuery as $itm) {
            $query->orderByRaw($itm['strRaw'], $itm['params']);
        }
        Paginator::currentPageResolver(function() use ($dataPagination) {
            return $dataPagination['current_page'];
        });
        $dataList = $query->paginate($dataPagination['per_page']);
        
        return [
            'total' => $dataList->total(),
            'per_page' => $dataList->perPage(),
            'current_page' => $dataList->currentPage(),
            'last_page' => $dataList->lastPage(),
            'from' => $dataList->firstItem() ?? 0,
            'to' => $dataList->lastItem() ?? 0,
            'data' => json_decode($dataList->getCollection(), true),
        ];
    }
    
}
