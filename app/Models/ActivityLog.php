<?php

namespace App\Models;

use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Activity
{
    public function getColumnsForDataTable()
    {
        $data = [
            ['data' => 'log_name', 'name' => 'log_name'],
            ['data' => 'description', 'name' => 'description', 'title' => 'Activity Log'],
        ];

        return json_encode($data);
    }

    public function ajaxListing()
    {
        $current_user = Auth()->user();

        $query = $this;

        if (!in_array($current_user->role_id, $current_user->getSuperAdminRoleIds())) {
            $query = $query->where('causer_id', $current_user->id);
        } else {
            $query = $query->query();
        }

        return $query;
    }
}
