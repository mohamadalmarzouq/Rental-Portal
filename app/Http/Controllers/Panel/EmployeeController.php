<?php

namespace App\Http\Controllers\Panel;

use App\Events\LandLordAccountApproved;
use App\Exports\EmployeeExport;
use App\Exports\UserExport;
use App\Http\Requests\Employee\StoreEmployee;
use App\Http\Requests\Employee\UpdateEmployee;
use App\Http\Requests\User\UpdateUserProfile;
use App\Models\Property;
use App\Models\Role;
use App\Models\Status;
use App\Models\UserProperty;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->primary_model = new User();
        $this->status_model = new Status();
        $this->user_property_model = new UserProperty();
        $this->dataAssign['module'] = 'employees';
        $this->rawColumns = ['user_status', 'action'];
        $this->dataAssign['actions'] = ['add', 'edit', 'view', 'delete'];
        $this->dataAssign['route_name_for_listing'] = $this->dataAssign['module'] . '.ajaxListing';
        $this->dataAssign['ordering_column'] = $this->primary_model->orderingColumn();
        $this->dataAssign['ordering'] = true;
        $this->dataAssign['data_table_columns'] = $this->primary_model->getColumnsForDataTable();
    }

    public function show()
    {
        $this->dataAssign['statuses'] = $this->status_model->getUserStatus();

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function store(StoreEmployee $storeEmployee)
    {
        $storeEmployee->merge(['password' => Hash::make($storeEmployee->password)]);

        $user = $this->primary_model->create($storeEmployee->only($this->primary_model->getFillable()));

        if ($user->creator_id) {
            $this->primary_model->addNewEmployeeToProperties($user->creator_id, $user->id);

        }

        $storeEmployee->session()->flash('activity_log_data', [
            'identifier' => 'user_added',
            'subject_type' => $user,
            'name' => 'name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);
    }

    public function update(UpdateEmployee $updateEmployee)
    {
        $user = $this->primary_model->find($updateEmployee->id);
        $user->login_token = null;
        $user->save();
        if ($updateEmployee->filled('password') && !is_null($updateEmployee->password)) {

            $updateEmployee->merge(['password' => Hash::make($updateEmployee->password)]);
        } else {
            $updateEmployee->request->remove('password');
        }

        $check_user_status = $this->primary_model->checkIfUserStatusChanged($user, $updateEmployee->user_status_id);

        !$check_user_status ?: event(new LandLordAccountApproved($user));

        $user->update($updateEmployee->only($this->primary_model->getFillable()));

        $updateEmployee->session()->flash('activity_log_data', [
            'identifier' => 'user_updated',
            'subject_type' => $user,
            'name' => 'name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);

        return redirect($this->dataAssign['module']);
    }

    public function edit($id)
    {
        $this->dataAssign['data'] = $this->primary_model->findOrFail($id);

        $this->dataAssign['statuses'] = $this->status_model->getUserStatus();

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
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
            'identifier' => 'user_deleted',
            'subject_type' => $data,
            'name' => 'name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);
    }

    public function export()
    {
        return Excel::download(new EmployeeExport(), time() . $this->dataAssign['module'] . '.xlsx');
    }

    protected function ajaxListing()
    {
        $data = $this->primary_model->employeesAjaxListing();

        $actions = $this->dataAssign['actions'];

        $module = $this->dataAssign['module'];

        $ordering = $this->dataAssign['ordering'];

        return $this->makeDataTable($data, $actions, $module, $ordering);
    }
}
