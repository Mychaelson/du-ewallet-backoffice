<?php

namespace App\Repositories\Wallet;


use Illuminate\Support\Facades\DB;


class UniqueCodeRepository
{

    public $status  = 'status';
    public $error   = 'error';
    public $user_data;
    public $sess;

    public function getPgaTopupList (){
        $data = DB::table('payment.pga_bills')
                    ->select(
                        'payment.pga_bills.reference_no',
                        'payment.pga_bills.invoice_no',
                        'payment.pga_bills.paid_description',
                        'payment.pga_bills.created_at'
                    )
                    ->where('payment.pga_bills.action', 'Topup')
                    ->where('payment.pga_bills.status', '000')
        ;

        return $data;
    }
}
