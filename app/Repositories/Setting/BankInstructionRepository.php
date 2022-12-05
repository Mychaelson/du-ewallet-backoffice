<?php

namespace App\Repositories\Setting;

use App\Models\Setting\Params;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

class BankInstructionRepository
{
    public function index(){
        $data = DB::table('accounts.bank_instruction')
                    ->leftJoin('accounts.banks', 'accounts.banks.id', '=', 'accounts.bank_instruction.bank_id')
                    ->select(
                                'accounts.bank_instruction.transaction', 'accounts.bank_instruction.id', 'accounts.bank_instruction.method', 'accounts.bank_instruction.title', 
                                'accounts.bank_instruction.lang','accounts.bank_instruction.bank_code', 'accounts.banks.name as bank_name'
                            );

        return $data;
    }

    public function detail($query){
        $data = DB::table('accounts.bank_instruction_lines')
                    ->select('title')
                    ->groupBy('title')
                    ;

        if (isset($query['bank_instruction_id'])) {
            $data->where('accounts.bank_instruction_lines.instruction_id','=', $query['bank_instruction_id']);
        }

        return $data;
    }

    public function getBankInfo ($id){
        $data = DB::table('accounts.bank_instruction')
                    ->leftJoin('accounts.banks', 'accounts.banks.id', '=', 'accounts.bank_instruction.bank_id')
                    ->select('accounts.banks.name');

        if(isset($id)){
            $data->where('accounts.bank_instruction.id', $id);
        }

        return $data->first();
    }
}
