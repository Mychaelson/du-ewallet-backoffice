<?php

namespace App\Http\Controllers\WalletUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Akaunting\Apexcharts\Chart;

use App\Repositories\WalletUser\WalletUserRepository;


class StatisticController extends Controller
{
    
    protected $mod_alias = 'user-statistic';
    protected $mod_active = 'wallet-user,user-statistic';

    public function index(Request $request)
    {        
        $walletUserRepository = new WalletUserRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $this->viewdata['page_title'] = 'Statistic List';
        return view('walletuser.statistic.details', $this->viewdata);
    }

    public function trans_chart(Request $request)
    {
        $walletUserRepository = new WalletUserRepository();

        $type = $request->input('type');

        $viewdata = [];

        $tanggalData = [];
        $totalData = [];


        $get_data = $walletUserRepository->getChartData($type);
        foreach ($get_data as $key => $value) {
            # code...
            array_push($tanggalData, $value->tanggal);
        }

        foreach ($get_data as $key => $value) {
            # code...
            array_push($totalData, $value->total_user);
        }

        $chart = (new Chart)->setType('line')
        ->setWidth('100%')
        ->setHeight(300)
        ->setLabels($tanggalData)
        ->setDataset('Total User', 'line', $totalData);

        $viewdata['chart'] = $chart;

    

        $viewdata['data'] = $get_data;
        // dd($viewdata['data']);

        return response()->json([
            'status' => TRUE,
            'content' => view('walletuser.statistic.chart.transaction', $viewdata)->render()
        ]);
    }

}
 