<?php

namespace App\Repositories\OTP;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Auth;

class OTPRepository
{

    public function otp_active($query)
    {
        $data = DB::table('accounts.one_time_passwords')
        ->when($query->action, fn ($query, $action) => $query->where('action', $action))
            ->orderBy('created_at', 'asc');
        return $data;
    }
}
