<?php

namespace App\Repositories\Ticket;

use Illuminate\Support\Facades\DB;

class TicketRepository
{
    public function getTicketQuery($query)
    {
        $data = DB::table('ticket.ticket')
            ->leftJoin('accounts.users', 'ticket.user', '=', 'users.id')
            ->leftJoin('ticket.ticket_category', 'ticket_category.id', '=', 'ticket.category')
            ->when($query->scope, fn ($query, $scope) => $query->where('ticket.scope', $scope))
            ->when($query->status, fn ($query, $status) => $query->where('ticket.status', $status))
            ->when($query->priority, fn ($query, $priority) => $query->where('ticket.priority', $priority))
            ->when($query->category, fn ($query, $category) => $query->where('ticket.category', $category))
            ->select([
                'ticket.*',
                'users.id as user_id',
                'users.username as user_username',
                'users.name as user_name',
                'users.nickname as user_nickname',
                'users.email as user_email',
                'users.phone as user_phone',
                'users.status as user_status',
                'users.user_type as user_type',
                'users.avatar as user_avatar',
                'ticket_category.id as category_id',
                'ticket_category.name as category_name',
                'ticket_category.parent as category_parent',
            ]);

        return $data;
    }

    public function getTicketById($id)
    {
        $data = DB::table('ticket.ticket')
            ->where('ticket.id', $id)
            ->join('accounts.users', 'ticket.user', '=', 'users.id')
            ->join('ticket.ticket_category', 'ticket_category.id', '=', 'ticket.category')
            ->join('ticket.ticket_category as sub_category', 'sub_category.id', '=', 'ticket.category_sub')
            ->select([
                'ticket.*',
                'users.id as user_id',
                'users.username as user_username',
                'users.name as user_name',
                'users.nickname as user_nickname',
                'users.email as user_email',
                'users.phone as user_phone',
                'users.status as user_status',
                'users.user_type as user_type',
                'users.avatar as user_avatar',
                'ticket_category.id as category_id',
                'ticket_category.name as category_name',
                'ticket_category.parent as category_parent',
                'sub_category.id as subcategory_id',
                'sub_category.name as subcategory_name',
                'sub_category.parent as subcategory_parent',
            ])
            ->first();

        $data->comments = $this->getComment($id);

        return $data;
    }

    public function getComment($ticketId)
    {
        $data = DB::table('ticket.ticket_comment')
            ->where('ticket_comment.ticket', $ticketId)
            ->leftJoin('accounts.users', 'ticket_comment.user', '=', 'users.id')
            ->leftJoin('backoffice.user as admin', 'ticket_comment.admin', '=', 'admin.id')
            ->select([
                'users.id as user_id',
                'users.username as user_username',
                'users.name as user_name',
                'users.nickname as user_nickname',
                'users.email as user_email',
                'users.phone as user_phone',
                'admin.id as admin_id',
                'admin.name as admin_name',
                'admin.fullname as admin_fullname',
                'admin.role as admin_role',
                'ticket_comment.id as comment_id',
                'ticket_comment.user as comment_user',
                'ticket_comment.admin as comment_admin',
                'ticket_comment.body as comment_body',
                'ticket_comment.attachment as comment_attachment',
                'ticket_comment.created_at as comment_created_at',
                'ticket_comment.updated_at as comment_updated_at',
            ])
            ->oldest('comment_created_at')
            ->get();

        return $data;
    }

    public function addComment($data)
    {
        $data = DB::table('ticket.ticket_comment')
            ->insert([
                'admin' => $data->user_id,
                'ticket' => $data->ticket_id,
                'body' => $data->comment_body,
                'created_at' => now(),
            ]);

        return $data;
    }
}
