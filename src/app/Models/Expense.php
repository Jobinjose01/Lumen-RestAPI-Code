<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ExpenseDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Expense extends Model
{
    protected $table = "expenses";

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'description', 'amount','payer_id','created_at','updated_at','group_id'
    ];


    public function ExpenseDetails(){

        return $this->hasMany(ExpenseDetail::class,'expense_id','id');
    }

    public function Groups(){

        return $this->belongsTo(Group::class,'id','group_id');
    }

    public function getCreatedAtAttribute($value){

        return date("d-M-Y",strtotime($value));
    }

    public function getUpdatedAtAttribute($value){

        return date("d-M-Y",strtotime($value));
    }


}
