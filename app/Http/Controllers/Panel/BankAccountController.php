<?php

namespace App\Http\Controllers\Panel;

use App\Exports\BankAccountExport;
use App\Exports\TenantExport;
use App\Http\Requests\BankAccount\StoreBankAccount;
use App\Http\Requests\BankAccount\UpdateBankAccount;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class BankAccountController extends Controller
{
    public function __construct()
    {
        $this->primary_model = new BankAccount();
        $this->dataAssign['module'] = 'bank_accounts';
        $this->dataAssign['actions'] = ['add', 'edit', 'view', 'delete'];
        $this->dataAssign['route_name_for_listing'] = $this->dataAssign['module'] . '.ajaxListing';
        $this->dataAssign['ordering_column'] = $this->primary_model->orderingColumn();
        $this->dataAssign['ordering'] = true;
        $this->dataAssign['data_table_columns'] = $this->primary_model->getColumnsForDataTable();
    }

    public function show()
    {
        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function store(StoreBankAccount $storeBankAccount)
    {
        $bank_account = $this->primary_model->create($storeBankAccount->only($this->primary_model->getFillable()));

        $storeBankAccount->session()->flash('activity_log_data', [
            'identifier' => 'bank_account_added',
            'subject_type' => $bank_account,
            'name' => 'bank_name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);
    }

    public function edit($id)
    {
        $this->dataAssign['data'] = $this->primary_model->findOrFail($id);

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function update(UpdateBankAccount $updateBankAccount)
    {
        $bank_account = $this->primary_model->find($updateBankAccount->id);

        $bank_account->update($updateBankAccount->only($this->primary_model->getFillable()));

        $updateBankAccount->session()->flash('activity_log_data', [
            'identifier' => 'bank_account_updated',
            'subject_type' => $bank_account,
            'name' => 'bank_name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);

        return redirect($this->dataAssign['module']);
    }

    public function view($id)
    {
        $this->dataAssign['data'] = $this->primary_model->findOrFail($id);

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function delete($id)
    {
        $data = $this->primary_model->find($id);

        $data->delete();

        \request()->session()->flash('activity_log_data', [
            'identifier' => 'bank_account_deleted',
            'subject_type' => $data,
            'name' => 'bank_name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);
    }

    protected function ajaxListing()
    {
        $data = $this->primary_model->ajaxListing();

        $actions = $this->dataAssign['actions'];

        $module = $this->dataAssign['module'];

        $ordering = $this->dataAssign['ordering'];

        return $this->makeDataTable($data, $actions, $module,$ordering);
    }

    public function export()
    {
        return Excel::download(new BankAccountExport(), time() . $this->dataAssign['module'] . '.xlsx');
    }

}
