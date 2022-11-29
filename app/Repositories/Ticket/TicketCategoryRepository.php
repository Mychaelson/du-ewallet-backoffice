<?php

namespace App\Repositories\Ticket;

use Illuminate\Support\Facades\DB;

class TicketCategoryRepository
{
    public function getCategoryList()
    {
        $category = DB::table('ticket.ticket_category')->get();

        return $category;
    }

    public function findCategoryById($id)
    {
        $category = DB::table('ticket.ticket_category')
            ->where('id', $id)
            ->first();

        return $category;
    }

    public function deleteCategoryById($id)
    {
        $category = DB::table('ticket.ticket_category')
            ->where('id', $id)
            ->delete();

        return $category;
    }

    public function getAllParentCategoryList()
    {
        $category = DB::table('ticket.ticket_category')
            ->where('parent', 0)
            ->where('priority', '>', 1)
            ->get();

        return $category;
    }

    public function getActiveParentCategoryList()
    {
        $category = DB::table('ticket.ticket_category')
            ->where('parent', 0)
            ->where('priority', '>', 1)
            ->where('status', 1)
            ->get();

        return $category;
    }

    public function add($data)
    {
        $category = DB::table('ticket.ticket_category')->insertGetId([
            'name' => $data->category_name,
            'parent' => $data->category_parent,
            'scope' => $data->category_scope,
            'tts' => 3600,
            'priority' => $data->category_priority,
            'activity' => $data->category_activity,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $category;
    }

    public function update($id, $data)
    {
        $category = DB::table('ticket.ticket_category')
            ->where('id', $id)
            ->update([
                'name' => $data->category_name,
                'parent' => $data->category_parent,
                'scope' => $data->category_scope,
                'tts' => 3600,
                'priority' => $data->category_priority,
                'activity' => $data->category_activity,
                'status' => $data->category_status,
                'updated_at' => now(),
            ]);

        return $category;
    }
}
