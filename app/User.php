<?php

namespace App;

use App\Models\Notification;
use App\Models\Property;
use App\Models\PropertyAssignedMapping;
use App\Models\Role;
use App\Models\Status;
use App\Models\Widget;
use App\Models\WidgetUser;
use App\Permissions\HasPermissionsTrait;
use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use PhpJunior\LaravelGlobalSearch\Traits\GlobalSearchable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class User extends Authenticatable implements HasMedia
{
    use Notifiable, HasPermissionsTrait, GlobalSearchable, EloquentJoin, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'remember_token', 'overdue_days', 'password', 'grace_period', 'due_date', 'over_due_date', 'role_id', 'user_status_id', 'photo', 'address', 'contact', 'creator_id', 'notification_enable', 'logo', 'company_name', 'company_address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The columns that should be ordered.
     *
     * @var array
     */
    protected $order = [
        'name' => 'desc',
        'email' => 'desc'
    ];

    protected $appends = ['user_status'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            foreach ($user->properties as $property) {
                $property->delete();
            }

            foreach ($user->notification as $notification) {
                $notification->delete();
            }

            foreach ($user->notification_sender as $notification) {
                $notification->delete();
            }
        });
    }

    public function getColumnsForDataTable()
    {
        $data = [
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'role.name', 'name' => 'name', 'title' => 'Role'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'user_status', 'name' => 'user_status', 'searchable' => 'false'],
            ['data' => 'action', 'name' => 'Action', 'searchable' => 'false'],
            // ['data' => 'created_at', 'name' => 'created_at', 'visible' => false]
        ];

        return json_encode($data);
    }

    public function notification()
    {
        return $this->hasMany(Notification::class, 'ref_id')->where('module', $this->getTable());
    }

    public function notification_sender()
    {
        return $this->hasMany(Notification::class, 'sender');
    }

    public function orderArray()
    {
        return [
            ['data' => 'name', 'name' => 'name', 'order' => true],
            ['data' => 'role.name', 'name' => 'role.name', 'order' => true, 'relationship' => ['model' => 'payment_method', 'column_name' => 'name']],
            ['data' => 'email', 'name' => 'email', 'order' => true],
            ['data' => 'properties_assigned', 'name' => 'properties_assigned', 'order' => false],
            ['data' => 'user_status_id', 'name' => 'user_status_id', 'order' => true],
            ['data' => 'action', 'name' => 'Action', 'order' => false],
            ['name' => 'created_at', 'order' => false]
        ];
    }

    public function orderingColumn()
    {
        return json_encode([['6', 'desc']]);
    }

    public function getUserStatusAttribute()
    {
        $status = $this->status->slug;

        $status_name = $this->status->status;

        return View::make('panel.includes.status_mutator', compact('status', 'status_name'))->render();
    }

    public function getAllLandLords()
    {
        return $this->whereIn('role_id', $this->getLandLordRoleIds())->whereHas('status', function ($q) {
            $q->where('slug', 'active');
        })->get();
    }

    public function getLandLordRoleIds()
    {
        return [2];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'user_status_id')->where('module', $this->getTable());
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'land_lord_id');
    }

    public function getAllLandLordsForDashboard()
    {
        return $this->with(['role'])->whereIn('role_id', $this->getLandLordRoleIds());
    }

    public function sendMail($user, $body)
    {
        Mail::send([], [], function ($message) use ($user, $body) {
            $message->to($user->email)
                    ->subject('Welcome to Rent Portal')
                    ->setBody($body, 'text/html');  // Ensure it's sent as HTML
        });
    }

    public function ajaxListing()
    {
        $current_user = Auth()->user();

        //  $query = $this->with(['role']);
        $query = $this->where('id', '<>', $current_user->id)->with(['role']);

        if (!in_array($current_user->role_id, $this->getSuperAdminRoleIds())) {

            $query = $query->where('creator_id', $current_user->id);
        }

        return $query;
    }

    public function getSuperAdminRoleIds()
    {
        return [1];
    }

    public function employeesAjaxListing()
    {
        $current_user = Auth()->user();

        $query = $this->with(['role']);

        if (!in_array($current_user->role_id, $this->getSuperAdminRoleIds())) {

            $query = $query->where('creator_id', $current_user->id);
        }

        $query = $query->whereIn('role_id', $this->getEmployeeRoleIds());

        return $query;
    }

    public function getEmployeeRoleIds()
    {
        return [3];
    }

    public function checkIfUserStatusChanged($user, $status)
    {
        $status_model = new Status();

        $status_id = $status_model->getStatusID($this->getTable(), 'active');

        return $user->user_status_id != $status && $status_id == $status && in_array($user->role_id, $this->getLandLordRoleIds());
    }

    public function excludeDashboardRoleIds()
    {
        return [
            [
                'role_id' => 3,
                'redirection_route_name' => 'tenants.show'
            ]
        ];
    }

    public function globalSearch($query)
    {
        return $this->ajaxListing()->selectRaw('id as id, name as value,user_status_id')->where(function ($q) use ($query) {
            $q->orWhere('name', 'like', '%' . $query . '%');
            $q->orWhere('email', 'like', '%' . $query . '%');
            $q->orWhere('contact', 'like', '%' . $query . '%');
        })->get();
    }

    public function globalSearchEmployees($query)
    {
        return $this->employeesAjaxListing()->selectRaw('id as id, name as value,user_status_id')->where(function ($q) use ($query) {
            $q->orWhere('name', 'like', '%' . $query . '%');
            $q->orWhere('email', 'like', '%' . $query . '%');
            $q->orWhere('contact', 'like', '%' . $query . '%');
        })->get();
    }

    public function addWidgetsToUsers($user)
    {
        $widgets = Widget::where('default', 1)->get();

        if (count($widgets) > 0) {
            foreach ($widgets as $widget) {
                $widget_user = new WidgetUser();
                $data = ['widget_id' => $widget->id, 'user_id' => $user->id];
                $widget_user->create($data);

            }
        }
    }

    public function addNewEmployeeToProperties($land_lord_id, $employee_id)
    {
        $property_model = new Property();

        $properties = $property_model->getLandLordActiveProperties($land_lord_id);

        foreach ($properties as $property) {

            PropertyAssignedMapping::create(
                [
                    'user_id' => $employee_id,
                    'property_id' => $property->id
                ]
            );
        }
    }

}
