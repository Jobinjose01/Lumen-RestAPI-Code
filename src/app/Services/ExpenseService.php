<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\UserGroup;
use App\Models\Group;

class ExpenseService {


    public function store(array $data): Expense
    {   
        
        $expense = Expense::create($data);

        $details_data = $this->calculateMemberWiseCost($data);

        $expense_details = $expense->ExpenseDetails()->createMany($details_data);

        return $expense;

    }


    public function getGroupExpenses(int $group_id)
    {
       
        $group = Group::find($group_id);
        
        $group_expense = $group->Expenses()->get();

        return  $group_expense;

    }

    public function getUserExpenses(int $user_id)
    {
        $mygroups = UserGroup::Where('user_id',$user_id)->pluck('group_id');

        $data = \DB::table('expenses AS E')
                    ->join('groups AS G','G.id','=','E.group_id')
                    ->whereIn('E.group_id',$mygroups)
                    ->groupBy('G.id')
                    ->get(['G.name as group_name','G.id as group_id'
                        ,\DB::raw('"'.$user_id.'" as my_user_id')
                        ,\DB::raw('SUM(E.amount) AS total_group_expense')
                        
                    ]);


        return $data;


    }

    public function getGroupExpenseUserWise(int $group_id)
    {
        $data = \DB::table('user_groups AS UG')
                    ->join('groups AS G','G.id','=','UG.group_id')
                    ->join('users AS U','U.id','=','UG.user_id')
                    ->join('expenses AS E','E.group_id','=','UG.group_id')
                    ->where('UG.group_id',$group_id)
                    ->GroupBy('UG.user_id','G.name')
                    ->get(['G.name as group_name',
                        \DB::raw('SUM(E.amount) AS total_group_expense'),
                        'G.id as group_id','U.name','U.id as user_id'
                    ]);


        return $data;
    }



    public static function calculateUserReceivable(int $user_id, int $group_id)
    {
        
        $amount =  \DB::table('expenses AS E')
                        ->join('expense_details AS D','D.expense_id','=','E.id')
                        ->Where('E.payer_id',$user_id)
                        ->Where('E.group_id',$group_id)
                        ->where('D.paid',0)
                        ->sum('D.amount');
        return $amount;
    }


    public static function calculateUserPayable(int $user_id, int $group_id)
    {
        $amount = \DB::table('expenses AS E')
                    ->join('expense_details AS D','D.expense_id','=','E.id')
                    ->Where('D.user_id',$user_id)
                    ->Where('E.group_id',$group_id)
                    ->where('D.paid',0)
                    ->sum('D.amount');
        return $amount;
    }

    public static function calculateUserPaid(int $user_id, int $group_id)
    {
        $amount = Expense::Where('payer_id',$user_id)
                    ->Where('group_id',$group_id)
                    ->sum('amount');
        return $amount;

    }


    public function calculateMemberWiseCost(array $data)
    {

        $members = UserGroup::where('group_id',$data['group_id'])->pluck('user_id');

        $split_amount = number_format($data['amount'] / sizeof($members),2,".","");

        $details_data = [];

        for( $i = 0; $i < sizeof($members) ; $i++){

            $paid = ($data['payer_id'] == $members[$i]) ? 1 : 0;

            $details_data[] = [
                'group_id' => $data['group_id'],
                'user_id' => $members[$i],
                'amount' => $split_amount,
                'paid' => $paid,
            ];
           
        }

        return $details_data;


    }
   
}
