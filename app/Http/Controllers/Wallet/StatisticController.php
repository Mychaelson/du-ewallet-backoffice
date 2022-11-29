<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Repositories\Wallet\HistoryRepository;
use App\Repositories\Wallet\StatisticRepository;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    protected $mod_alias = 'wallet-statistics';
    protected $mod_active = 'wallet,wallet-statistics';

    public function index(Request $request)
    {
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        //dd($get_data->get());

        $this->viewdata['page_title'] = 'Transaction Statistic';
        return view('wallet.statistic.content', $this->viewdata);
    }

    public function dataTable(Request $request)
    {
        $statisticRepository = new StatisticRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];

		$total_row = 0;

        $get_data = $statisticRepository->getList($query);

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
            'request' => $query,
            'content' => view('wallet.statistic.table', $viewdata)->render()
        ]);
    }
}
