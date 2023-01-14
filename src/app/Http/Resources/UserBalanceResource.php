<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\ExpenseService;

class UserBalanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        $my_receivable_amount = ExpenseService::calculateUserReceivable($this->user_id, $this->group_id);

        $my_payable_amount    = ExpenseService::calculateUserPayable($this->user_id, $this->group_id);

        return [
            'group_name' => $this->group_name,
            'total_group_expense' => $this->total_group_expense,
            'group_id' => $this->group_id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'my_paid_amount' => ExpenseService::calculateUserPaid($this->user_id, $this->group_id),
            'my_receivable_amount' => $my_receivable_amount,   
            'my_payable_amount' => $my_payable_amount,
            'my_balance_amount' => number_format(($my_receivable_amount - $my_payable_amount),2,".","")            
        ];
    }
}
