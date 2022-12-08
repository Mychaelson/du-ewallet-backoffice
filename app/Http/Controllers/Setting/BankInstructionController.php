<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Repositories\Setting\BankInstructionRepository;
use Illuminate\Http\Request;

class BankInstructionController extends Controller
{
    protected $mod_alias = 'setting';
    protected $mod_active = 'setting,setting-bank-instruction';

    public function index(){
        $BankInstructionRepository = new BankInstructionRepository();
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Bank Instruction';
        $this->viewdata['bank_list'] = $BankInstructionRepository->getBank();

        return view('setting.bank-instruction.content',$this->viewdata);
    }

    public function data_tables(Request $request){
        $BankInstructionRepository = new BankInstructionRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];
		$total_row = 0;

        $get_data = $BankInstructionRepository->index($query);

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
            'content' => view('setting.bank-instruction.table', $viewdata)->render()
        ]);
    }

    public function bankInstructionDetail($id){
        $BankInstructionRepository = new BankInstructionRepository();
        
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $bankInfo = $BankInstructionRepository->getBankInfo($id);
        $this->viewdata['page_title'] = $bankInfo->name." Detail";
        $listMethod = $BankInstructionRepository->detail(['bank_instruction_id' => $id])->get();
        $this->viewdata['idBank'] = $id;
        $this->viewdata['listMethod'] = $listMethod;

        return view('setting.bank-instruction.detail',$this->viewdata);
    }

    public function data_tables_method_detail(Request $request){
        $BankInstructionRepository = new BankInstructionRepository();

        $query = $request->input('query');
    

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        

        $viewdata = [];
		$total_row = 0;

        $get_data = $BankInstructionRepository->getDetailMethod($query);

        $paginator = $get_data->paginate($limit, ['*'], 'pagination.page');

        $total_row = $get_data->count();

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
            'content' => view('setting.bank-instruction.method_detail_table', $viewdata)->render(),
            'data' => $get_data
        ]);
    }

    public function create (Request $request){
        $BankInstructionRepository = new BankInstructionRepository();

        $bank_code = $BankInstructionRepository->getBank($request->bank_id)->code;
        $getLastId = $BankInstructionRepository->getLastId();

        $data = [
            'id'            => $getLastId->id + 1,
            'transaction'   => 'Topup',
            'method'        => $request->method,
            'title'         => $request->title,
            'lang'          => $request->lang ? $request->lang : 'ID',
            'bank_code'     => $bank_code,
            'bank_id'       => $request->bank_id
        ];

        $create = $BankInstructionRepository->createBankInstruction($data);

        return redirect()->back()->with('message','Add Data Succeessfully');
    }

    public function createDetail (Request $request){
        $BankInstructionRepository = new BankInstructionRepository();

        $getLastId = $BankInstructionRepository->getLastId('bank_instruction_lines');

        $data = [
            'id'                => $getLastId->id + 1,
            'instruction_id'    => $request->bankInstructionId,
            'title'             => $request->new_method ? $request->new_method : $request->method,
            'steps'             => $request->step,
            'step_type'         => 'text',
            'step_value'        => $request->step_value,
            'lang'              => $request->lang,
        ];

        $create = $BankInstructionRepository->createBankInstructionLines($data);

        return redirect()->back()->with('message','Add Data Succeessfully');
    }

    public function deleteDetail ($id){
        $BankInstructionRepository = new BankInstructionRepository();

        $delete = $BankInstructionRepository->deleteDetailMethod($id);

        return redirect()->back()->with('message','Delete Data Succeessfully');
    }

    public function deleteBankInstruction($id){
        $BankInstructionRepository = new BankInstructionRepository();

        $delete = $BankInstructionRepository->deleteBankInstruction($id);
        
        return redirect()->back()->with('message','Delete Data Succeessfully');
    }

    public function edit($id){
        $BankInstructionRepository = new BankInstructionRepository();
        $data = $BankInstructionRepository->index($id)->first();
        return $data;
    }
}
