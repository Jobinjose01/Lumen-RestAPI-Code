<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Expense;

class Group extends Model
{


    protected $table = "groups";

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'status','created_at','updated_at','deleted_at'
    ];


    public function Expenses(){

        return $this->hasMany(Expense::class,'group_id','id');
    }

    public function getCreatedAtAttribute($value){

        return date("d-M-Y",strtotime($value));
    }

    public function getUpdatedAtAttribute($value){

        return date("d-M-Y",strtotime($value));
    }
    
    
}
