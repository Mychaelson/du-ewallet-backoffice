<?php

namespace App\Http\Controllers\PPOB;

use App\Http\Controllers\Controller;
use App\Repositories\PPOB\ProductV2Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ProductV2Controller extends Controller
{
    protected $mod_alias = 'product';
    protected $mod_active = 'ppob,product';

    public function index(){
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Product';

        $ProductV2Repository = new ProductV2Repository();
        $this->viewdata['get_all'] = $ProductV2Repository->get_all_product();

       return view('PPOB.ProductV2.content',$this->viewdata);
    }

    public function edit($code){
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Edit Product'.$code;
        $ProductV2Repository = new ProductV2Repository();
        $this->viewdata['data'] = $ProductV2Repository->detail_product($code);
        $this->viewdata['service'] = $ProductV2Repository->service($code);

        return view('PPOB.ProductV2.edit',$this->viewdata);
    }

    public function detail($code){
        $ProductV2Repository = new ProductV2Repository();
        $data = $ProductV2Repository->detail($code);

        return $data;
    }
    public function update(Request $request,$code){
        $ProductV2Repository = new ProductV2Repository();
        return $ProductV2Repository->update($request,$code);

    }

    public function data_tables(Request $request){
        $ProductV2Repository = new ProductV2Repository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];
		$total_row = 0;

        $get_data = $ProductV2Repository->get_product((object) $query);
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
            'content' => view('PPOB.ProductV2.table', $viewdata)->render()
        ]);
    }



}
