<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use App\Models\Group;

class ExpenseDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       
        return [
            'id' => $this->id,
            'description' => $this->description,
            'amount' => $this->amount,
            'payer_id' => $this->payer_id,
            'group_id' => $this->group_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'payer_name' => User::find($this->payer_id)->name,
            'group_name' => Group::find($this->group_id)->name,
        ];

    }
}
