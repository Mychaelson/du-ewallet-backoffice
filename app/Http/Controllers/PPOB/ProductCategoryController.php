<?php

namespace App\Http\Controllers\PPOB;

use App\Http\Controllers\Controller;
use App\Repositories\PPOB\ProductCategoryRepository;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    protected $mod_alias = 'product_category';
    protected $mod_active = 'ppob,product_category';

    public function index(){
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Product';


       return view('ppob.productsCategory.content',$this->viewdata);
    }

    public function create(){
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Create Category';
        $ProductCategoryRepository = new ProductCategoryRepository();
        $this->viewdata['data'] = $ProductCategoryRepository->get_parent();

       return view('ppob.productsCategory.create',$this->viewdata);
    }

    public function store(Request $request){
        $ProductCategoryRepository = new ProductCategoryRepository();
         $data = $ProductCategoryRepository->store($request);
         return $data;

    }

    public function edit(Request $request,$id){
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Edit Category';
        $ProductCategoryRepository = new ProductCategoryRepository();
        $this->viewdata['data'] = $ProductCategoryRepository->edit($id);
        $this->viewdata['parent'] = $ProductCategoryRepository->get_parent();

        return view('ppob.productsCategory.edit  ',$this->viewdata);
    }

    public function update(Request $request,$id){
        $ProductCategoryRepository = new ProductCategoryRepository();
         $data = $ProductCategoryRepository->update($request,$id);
         return $data;
    }

    public function delete($id){
        $ProductCategoryRepository = new ProductCategoryRepository();
         $data = $ProductCategoryRepository->delete($id);
         return $data;
    }
    public function data_tables(Request $request){
        $ProductCategoryRepository = new ProductCategoryRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 5);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];
		$total_row = 0;

        $get_data = $ProductCategoryRepository->get_category($query);
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
            'content' => view('ppob.productsCategory.table', $viewdata)->render()
        ]);
    }
}
