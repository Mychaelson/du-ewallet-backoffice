<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Repositories\Ticket\TicketCategoryRepository;
use App\Repositories\Ticket\TicketRepository;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $mod_alias = 'all-ticket-list';

    protected $mod_active = 'ticket,all-ticket-list';

    public function __construct(
        private TicketRepository $ticketRepository,
        private TicketCategoryRepository $ticketCategoryRepository
    ) {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Ticket List';

        /**
         * Get Category
         */
        $categories = $this->ticketCategoryRepository->getActiveParentCategoryList();
        $this->viewdata['categories'] = $categories;

        return view('ticket.ticket.content', $this->viewdata);
    }

    public function data_table(Request $request)
    {
        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];

        $total_row = 0;

        $get_data = $this->ticketRepository->getTicketQuery((object) $query);

        $paginator = $get_data->paginate($limit, ['*'], 'pagination.page');

        $total_row = $paginator->total();

        if ($total_row == 0) {
            return response()->json([
                'status' => true,
                'total_row' => $total_row,
            ]);
        }

        $viewdata['limit'] = $limit;
        $viewdata['query'] = $query;
        $viewdata['paginator'] = $paginator;

        return response()->json([
            'status' => true,
            'total_row' => $total_row,
            'paginator' => $paginator,
            'content' => view('ticket.ticket.table', $viewdata)->render(),
        ]);
    }

    public function show($id)
    {
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $ticket = $this->ticketRepository->getTicketById($id);
        $this->viewdata['ticket'] = $ticket;

        $this->viewdata['page_title'] = 'Detail Ticket';

        return view('ticket.ticket.detail', $this->viewdata);
    }

    public function comment(Request $request)
    {
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $this->ticketRepository->addComment((object) $request->all());

        return redirect()->back();
    }
}
