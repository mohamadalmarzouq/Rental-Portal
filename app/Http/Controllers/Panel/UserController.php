<?php

namespace App\Http\Controllers\Panel;

use App\Events\ForgotPasswordMail;
use App\Events\LandLordAccountApproved;
use App\Events\LandLordSignUp;
use App\Events\VerificationMail;
use App\Exports\UserExport;
use App\Http\Requests\User\ChangePassword;
use App\Http\Requests\User\ForgotPassword;
use App\Http\Requests\User\StoreUser;
use App\Http\Requests\User\UpdateUser;
use App\Http\Requests\User\UpdateUserProfile;
use App\Models\Lease;
use App\Models\Property;
use App\Models\PropertyAssignedMapping;
use App\Models\Role;
use App\Models\Status;
use App\Models\UserProperty;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function __construct()
    {
        $this->primary_model = new User();
        $this->status_model = new Status();
        $this->user_property_model = new UserProperty();
        $this->role_model = new Role();
        $this->dataAssign['module'] = 'users';
        $this->rawColumns = ['user_status', 'properties_assigned', 'action'];
        $this->dataAssign['actions'] = ['add', 'edit', 'view', 'delete'];
        $this->dataAssign['route_name_for_listing'] = $this->dataAssign['module'] . '.ajaxListing';
        $this->dataAssign['ordering_column'] = $this->primary_model->orderingColumn();
        $this->dataAssign['ordering'] = true;
        $this->dataAssign['data_table_columns'] = $this->primary_model->getColumnsForDataTable();
    }

    public function show()
    {
        $this->dataAssign['statuses'] = $this->status_model->getUserStatus();

        $this->dataAssign['roles'] = $this->role_model->allRoles()->get();

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function store(StoreUser $storeUser)
    {
        $plain_password = $storeUser->password;
        $storeUser->merge(['password' => Hash::make($plain_password)]);
        $user = $this->primary_model->create($storeUser->only($this->primary_model->getFillable()));
        $user->unique_password = $plain_password;
        event(new Registered($user));
        event(new VerificationMail($user));
        event(new LandLordSignUp($user));
        $storeUser->session()->flash('activity_log_data', [
            'identifier' => 'user_added',
            'subject_type' => $user,
            'name' => 'name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);
    }

    public function update(UpdateUser $updateUser)
    {
        $user = $this->primary_model->find($updateUser->id);

        if ($updateUser->filled('password') && !is_null($updateUser->password)) {

            $updateUser->merge(['password' => Hash::make($updateUser->password)]);
        } else {
            $updateUser->request->remove('password');
        }

        $check_user_status = $this->primary_model->checkIfUserStatusChanged($user, $updateUser->user_status_id);

        !$check_user_status ?: event(new LandLordAccountApproved($user));

        $user->update($updateUser->only($this->primary_model->getFillable()));

        $updateUser->session()->flash('activity_log_data', [
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

        $this->dataAssign['roles'] = $this->role_model->allRoles()->get();

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function view($id)
    {
        $this->dataAssign['data'] = $this->primary_model->findOrFail($id);

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function profile()
    {
        $current_user_id = Auth()->user()->id;

        $this->dataAssign['data'] = $this->primary_model->find($current_user_id);

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function notification()
    {
        $current_user_id = Auth()->user()->id;

        $this->dataAssign['data'] = $this->primary_model->find($current_user_id);

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function updateNotification(Request $request)
    {
        $user = $this->primary_model->find($request->id);

        $current_user = Auth::user();

        $data   =   $request->except(['_token', 'logo', 'id']);

        // $date = (int)$request->due_date + (int)$request->grace_period;

        // if ($date > 31) {

        //     flash('Month is changing by adding grace period.', 'danger');

        //     return back();
        // }

        // it is not working thats why i changed it
        // $overdue_date = date("Y-m-d", strtotime(date('Y-m') . "-" . $request->due_date . ' days'));
        // $overdue_date = date("Y-m-d", strtotime(date('Y-m') . "-" . $request->due_date));

        $overdue_date = date("Y-m-d", strtotime(date('Y-m') . "-" . ($request->due_date + $request->grace_period)));

        Lease::whereHas('property', function ($q) use ($current_user) {

            $q->whereHas('assigned_to', function ($q1) use ($current_user) {
                $q1->where('user_id', $current_user->id);
            });
        })->update(['due_date' => $overdue_date]);

        $data['over_due_date'] = ($request->due_date + $request->grace_period);

        if ($request->has('logo')) {
            $file           =   $request->file('logo');
            $logo           =   uploadCustomFile($file);
            $data['logo']   =   $logo;
        }

        $user->update($data);

        flash('Settings Updated', 'success');

        return back();
    }

    public function updateProfile(UpdateUserProfile $updateUserProfile)
    {
        if ($updateUserProfile->hasFile('image')) {

            $image_path = uploadCustomFile($updateUserProfile->image);

            $updateUserProfile->merge(['photo' => $image_path]);
        }

        if ($updateUserProfile->filled('password') && !is_null($updateUserProfile->password)) {

            $updateUserProfile->merge(['password' => Hash::make($updateUserProfile->password)]);
        } else {
            $updateUserProfile->request->remove('password');
        }

        $user = $this->primary_model->find($updateUserProfile->id);

        $user->update($updateUserProfile->only($this->primary_model->getFillable()));

        $updateUserProfile->session()->flash('activity_log_data', [
            'identifier' => 'user_profile',
            'subject_type' => $user,
            'name' => 'name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);

        flash('User profile updated', 'success');

        return back();
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

    public function makeTotalLandLordsDataTable()
    {
        $this->dataAssign['route_name_for_listing'] = $this->dataAssign['module'] . '.allLandLords';

        $this->dataAssign['module'] = $this->dataAssign['module'];

        $this->dataAssign['ordering'] = true;

        return json_encode($this->dataAssign);
    }

    public function getAllLandLordsListing()
    {
        $data = $this->primary_model->getAllLandLordsForDashboard();

        $actions = $this->dataAssign['actions'];

        $module = $this->dataAssign['module'];

        $ordering = $this->dataAssign['ordering'];

        return $this->makeDataTable($data, $actions, $module, $ordering);
    }

    public function export()
    {
        return Excel::download(new UserExport(), time() . $this->dataAssign['module'] . '.xlsx');
    }

    protected function ajaxListing()
    {
        $data = $this->primary_model->ajaxListing();

        $actions = $this->dataAssign['actions'];

        $module = $this->dataAssign['module'];

        $ordering = $this->dataAssign['ordering'];

        return $this->makeDataTable($data, $actions, $module, $ordering);
    }

    public function forgotPassword(ForgotPassword $request)
    {
        $user = $this->primary_model->whereEmail($request->email)->first();

        $reset_token = md5(uniqid(rand(), true));

        $user->update(['remember_token' => $reset_token]);

        event(new ForgotPasswordMail($user));

        flash('Forgot Password mail has been sent to your email', 'success');

        return back();
    }

    public function changePassword(ChangePassword $request)
    {
        $user = $this->primary_model->whereEmail($request->email)->first();

        $user->update(['password' => bcrypt($request->password), 'remember_token' => '']);

        flash('Password Changed Successfully', 'success');

        return redirect()->route('login');
    }

    public function resetPassword(Request $request)
    {
        $user = $this->primary_model->whereEmail($request->email)->where('remember_token', $request->token)->first();

        if (!$user) {
            abort(419);
        }

        return view('auth.reset_password', compact('user'));
    }
}
