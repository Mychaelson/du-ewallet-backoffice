<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Models\Media\Media;
use App\Repositories\Media\MediaRepository;
use Illuminate\Http\Request;
use function Ramsey\Uuid\v1;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class MediaController extends Controller
{
    protected $mod_alias = 'file-list';
    protected $mod_active = 'file-list';

    public function index(){
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'List Media';

        return view('media.content',$this->viewdata);
    }

    public function data_tables(Request $request){
        $MediaRepository = new MediaRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];
		$total_row = 0;

        $get_data = $MediaRepository->get_image($query);
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
            'content' => view('media.table', $viewdata)->render()
        ]);
    }

    public function upload(Request $request){
        $MediaRepository = new MediaRepository();
        $data = $MediaRepository->upload($request);

        return $data;
    }
}
