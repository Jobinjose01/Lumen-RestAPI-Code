<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseDetail extends Model
{
    protected $table = "expense_details";

    protected $fillable = [
        'expense_id', 'group_id', 'user_id', 'amount', 'paid' , 'created_at', 'updated_at'
    ];

   
    public function Expense(){

        return $this->belongsTo(Expense::class,'id','expense_id');
    }

}
