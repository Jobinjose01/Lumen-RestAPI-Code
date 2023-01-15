<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Group;
class UserGroup extends Model
{
    
    protected $table = "user_groups";

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'group_id','created_at','updated_at'
    ];


    public function getCreatedAtAttribute($value){

        return date("d-M-Y",strtotime($value));
    }

    public function getUpdatedAtAttribute($value){

        return date("d-M-Y",strtotime($value));
    }
}
