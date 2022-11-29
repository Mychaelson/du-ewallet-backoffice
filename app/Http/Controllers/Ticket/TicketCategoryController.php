<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Repositories\Ticket\TicketCategoryRepository;
use Illuminate\Http\Request;

class TicketCategoryController extends Controller
{
    protected $mod_alias = 'all-ticket-category-list';

    protected $mod_active = 'ticket.category,all-ticket-category-list';

    public function __construct(
        private TicketCategoryRepository $ticketCategoryRepository
    ) {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Ticket Category';

        $parents = $this->ticketCategoryRepository->getActiveParentCategoryList();
        $this->viewdata['parents'] = $parents;

        $categories = $this->ticketCategoryRepository->getCategoryList();
        $this->viewdata['categories'] = $categories;

        return view('ticket.category.index', $this->viewdata);
    }

    public function add(Request $request)
    {
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Ticket Category';
        $this->viewdata['parent_id'] = $request->query('parent_id');

        $parents = $this->ticketCategoryRepository->getActiveParentCategoryList();
        $this->viewdata['parents'] = $parents;

        return view('ticket.category.add', $this->viewdata);
    }

    public function store(Request $request)
    {
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $category = $this->ticketCategoryRepository->add((object) $request->all());
        $this->viewdata['category'] = $category;

        return redirect()->to(route('ticket-category-list'));
    }

    public function update(Request $request, $id)
    {
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $category = $this->ticketCategoryRepository->update($id, (object) $request->all());
        $this->viewdata['category'] = $category;

        return redirect()->to(route('ticket-category-list'));
    }

    public function detail($id)
    {
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Ticket Category';

        $parents = $this->ticketCategoryRepository->getActiveParentCategoryList();
        $this->viewdata['parents'] = $parents;

        $category = $this->ticketCategoryRepository->findCategoryById($id);
        $this->viewdata['category'] = $category;

        return view('ticket.category.detail', $this->viewdata);
    }

    public function delete(Request $request, $id)
    {
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Ticket Category';

        $delete = $this->ticketCategoryRepository->deleteCategoryById($id);

        return redirect()->to(route('ticket-category-list'));
    }
}
