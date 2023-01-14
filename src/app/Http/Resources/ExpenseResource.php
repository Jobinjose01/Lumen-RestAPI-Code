<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Expense;
use App\Models\ExpenseDetail;
use App\Services\ExpenseService;
use App\Http\Resources\ExpenseDetailsResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource Resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $my_receivable_amount = ExpenseService::calculateUserReceivable($this->my_user_id, $this->group_id);

        $my_payable_amount    = ExpenseService::calculateUserPayable($this->my_user_id, $this->group_id);

        return [
            'group_name' => $this->group_name,
            'group_id' => $this->group_id   ,
            'my_user_id' => $this->my_user_id,
            'total_group_expense' => $this->total_group_expense,
            'my_paid_amount' => ExpenseService::calculateUserPaid($this->my_user_id, $this->group_id),
            'my_receivable_amount' => $my_receivable_amount,   
            'my_payable_amount' => $my_payable_amount,
            'my_balance_amount' => number_format(($my_receivable_amount - $my_payable_amount),2,".",""),
            'expense_details' => ExpenseDetailsResource::collection(Expense::Where('group_id',$this->group_id)->get()),
        ];
      
       
    }
}
