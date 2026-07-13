<?php

namespace App\Repositories\GlobalSearch;


class GlobalSearch
{
    public function modules()
    {
        return
            [
                'users' => 'User',
                'properties' => 'Property',
                'tenants' => 'Tenant',
                'bank_accounts' => 'BankAccount',
                'employees' => 'User',
            ];
    }

    public function search($query)
    {
        $search = [];

        foreach ($this->modules() as $key => $module) {

            if (hasRole($key, 'is_visible')) {

                $model = ($key == 'users' || $key == 'employees' ? config('filesystems.FULL_PANEL_USER_MODEL_PATH') : config('filesystems.FULL_PANEL_MODEL_PATH')) . $module;

                $class = new $model();

                switch ($key) {

                    case 'employees':

                        $data = $class->globalSearchEmployees($query)->toArray();
                        if (!empty($data))
                            $search[$key] = $data;
                        break;
                    default:

                        $data = $class->globalSearch($query)->toArray();
                        if (!empty($data))
                            $search[$key] = $data;

                }

            }
        }

        return $search;
    }
}
