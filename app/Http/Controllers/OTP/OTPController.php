<?php

namespace App\Http\Controllers\OTP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\OTP\OTPRepository;
class OTPController extends Controller
{

    protected $mod_alias = 'otp-active';
    protected $mod_active = 'otp-active';

    public function active(){
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = 'otp';
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'ALL OTP';
        return view('otp.otp-active.content', $this->viewdata);

    }

    public function data_tables_otp_active(Request $request){
        $OTPRepository = new OTPRepository();
        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];
		$total_row = 0;

        $get_data = $OTPRepository->otp_active((object) $query);
        $paginator = $get_data->paginate($limit, ['*'], 'pagination.page');
        $total_row = $paginator->total();

        if($total_row == 0)
        {
            return response()->json([
                'status' => TRUE,
                'total_row' => $total_row
            ]);
        }

        $viewdata['limit'] = $limit;
        $viewdata['query'] = $query;
        $viewdata['paginator'] = $paginator;

        return response()->json([
            'status' => TRUE,
            'total_row' => $total_row,
            'paginator' => $paginator,
            'content' => view('otp.otp-active.table', $viewdata)->render()
        ]);
    }

}
