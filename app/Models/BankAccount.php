<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpJunior\LaravelGlobalSearch\Traits\GlobalSearchable;

class BankAccount extends Model
{
    use GlobalSearchable;

    /**
     * The columns that should be ordered.
     *
     * @var array
     */
    protected $order = [
        'bank_name' => 'desc',
    ];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    protected $search = [
        'bank_name', 'account_title', 'account_number'
    ];

    /**
     * The columns that should be displayed.
     *
     * @var array
     */
    protected $only = [
        'bank_name', 'id'
    ];

    protected $fillable = [
        'bank_name', 'account_title', 'account_number', 'creator_id'];

    public function getColumnsForDataTable()
    {
        $data = [
            ['data' => 'bank_name', 'name' => 'bank_name'],
            ['data' => 'account_title', 'name' => 'account_title'],
            ['data' => 'account_number', 'name' => 'account_number'],
            ['data' => 'action', 'name' => 'Action', 'searchable' => 'false'],
            ['data' => 'created_at', 'name' => 'created_at', 'visible' => false]
        ];

        return json_encode($data);
    }

    public function orderArray()
    {
        return [
            ['data' => 'bank_name', 'name' => 'bank_name', 'order' => true],
            ['data' => 'account_title', 'name' => 'account_title', 'order' => true],
            ['data' => 'account_number', 'name' => 'account_number', 'order' => true],
            ['data' => 'action', 'name' => 'Action', 'searchable' => 'false', 'order' => false],
            ['name' => 'created_at', 'order' => false]
        ];
    }

    public function orderingColumn()
    {
        return json_encode([['4', 'desc']]);
    }

    public function ajaxListing()
    {
        $current_user = Auth()->user();

        $query = $this;

        if (!in_array($current_user->role_id, $current_user->getSuperAdminRoleIds())) {

            $query = $query->where('creator_id', $current_user->id);
        } else {
            $query = $query->query();
        }

        return $query;
    }

    public function globalSearch($query)
    {
        return $this->ajaxListing()->selectRaw('id as id, bank_name as value')->where(function ($q) use ($query) {
            $q->orWhere('bank_name', 'like', '%' . $query . '%');
            $q->orWhere('account_title', 'like', '%' . $query . '%');
            $q->orWhere('account_number', 'like', '%' . $query . '%');
        })->get();
    }
}
