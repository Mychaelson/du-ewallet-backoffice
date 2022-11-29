<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Wallet\LabelRepository;

class LabelController extends Controller
{
    protected $mod_alias = 'wallet-label';
    protected $mod_active = 'wallet,wallet-label';

    public function index(Request $request)
    {
        $labelRepository = new LabelRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;


        $this->viewdata['page_title'] = 'Wallet Setting';
        return view('wallet.label.content', $this->viewdata);
    }

    public function dataTable(Request $request)
    {
        $labelRepository = new LabelRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];

        

		$total_row = 0;

        $get_data = $labelRepository->getList($query);

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
            'content' => view('wallet.label.table', $viewdata)->render()
        ]);
    }

    public function update (Request $request, $id){
        $labelRepository = new LabelRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $this->viewdata['id'] = $id;
        $this->viewdata['info'] = $labelRepository->getLabel(['id' => $id]);

        $this->viewdata['page_title'] = 'Update Label';
        return view('wallet.label.form', $this->viewdata);
    }

    public function store (Request $request) {
        $labelRepository = new LabelRepository();

        $data = [
            'name'          => $request->name,
            'icon'          => $request->icon_url,
            'background'    => $request->background_url,
            'color'         => $request->color,
            'spending'      => isset($request->spending) ? 1 : 0,
            'organization'  => isset($request->organization) ? 1 : 0
        ];

        if (isset($request->label_id)) {
            $labelRepository->updateById($request->label_id, $data);
        } else {
            $data['default'] = 0;
            $data['created_at'] = now();
            $data['updated_at'] = now();
            $labelRepository->add($data);
        }

        return redirect()->to(route('wallet-label'));
    }

    public function add (Request $request) {
        $labelRepository = new LabelRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $this->viewdata['page_title'] = 'Add Label';
        return view('wallet.label.form', $this->viewdata);
    }
}
