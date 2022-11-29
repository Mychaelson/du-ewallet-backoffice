<?php

namespace App\Http\Controllers\Documents\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Report\Report;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Report\ReportRepository;
use Illuminate\Support\Str;
use Auth;

class ReportController extends Controller
{
    protected $mod_alias = 'documents';
    protected $mod_active = 'documents,report';
    public function index()
    {
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'List Report';

        return view('documents.report.content', $this->viewdata);
    }

    public function data_tables(Request $request)
    {
        $ReportRepository = new ReportRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];
        $total_row = 0;

        $get_data = $ReportRepository->index($query);
        $paginator = $get_data->paginate($limit, ['*'], 'pagination.page');
        $total_row = $paginator->total();

        if ($total_row == 0) {
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
            'content' => view('documents.report.table', $viewdata)->render()
        ]);
    }

    public function reqDocTable(Request $request)
    {
        $ReportRepository = new ReportRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];
        $total_row = 0;

        $get_data = $ReportRepository->reportNotUser($query);
        $paginator = $get_data->paginate($limit, ['*'], 'pagination.page');
        $total_row = $paginator->total();

        if ($total_row == 0) {
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
            'content' => view('documents.report.requestTable', $viewdata)->render()
        ]);
    }    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Create Report';
        return view('documents.report.create', $this->viewdata);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ReportRepository = new ReportRepository();
        $data = $ReportRepository->store($request);

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ReportRepository = new ReportRepository();
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Edit Report';
        $this->viewdata['data'] = $ReportRepository->edit($id);
        return view('documents.report.edit', $this->viewdata);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ReportRepository = new ReportRepository();
        $data = $ReportRepository->update($request,$id);

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ReportRepository = new ReportRepository();
        $data = $ReportRepository->delete($id);

        return $data;
    }
}
