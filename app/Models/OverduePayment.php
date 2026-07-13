<?php

namespace App\Models;

use App\User;
use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Model;

class OverduePayment extends Model
{
    use EloquentJoin;

    protected $fillable = ['lease_id', 'amount', 'date', 'tenant_id', 'comment', 'property_id', 'commented_by', 'unit_id'];

    protected $appends = ['days_over', 'user_name', 'overdue_comment'];

    public function getDaysOverAttribute()
    {
        $dueDate = $this->created_at;

        $now = now();

        $diffInDays = $dueDate->diffInDays($now);

        return $diffInDays . ' days';
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function getUserNameAttribute()
    {
        return $this->commented_by_user ? $this->commented_by_user->name : "-";
    }

    public function commented_by_user()
    {
        return $this->belongsTo(User::class, 'commented_by');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function lease()
    {
        return $this->belongsTo(Lease::class, 'lease_id')->with(['unit', 'type', 'frequency']);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function getAmountAttribute($value)
    {
        return addCommaForNumeric($value);
    }

    public function getOverdueCommentAttribute()
    {
        $comment = $this->comment;

        return view('panel.includes.overdue_comment', compact('comment'))->render();
    }

    public function getColumnsForOverDueAmountDataTable()
    {
        $data = [
            ['data' => 'property.name', 'name' => 'property.name', 'title' => 'Property Name'],
            ['data' => 'unit.number', 'name' => 'unit.number', 'title' => 'Unit'],
            ['data' => 'lease.id', 'name' => 'lease.id', 'title' => 'Lease ID'],
            ['data' => 'amount', 'name' => 'amount', 'title' => 'Amount'],
            ['data' => 'days_over', 'name' => 'days_over', 'title' => 'Days Overdue', 'searchable' => 'false'],
            ['data' => 'overdue_comment', 'name' => 'overdue_comment', 'title' => 'Comment', 'searchable' => 'false'],
            ['data' => 'user_name', 'name' => 'user_name', 'title' => 'Comment By', 'searchable' => 'false'],
            ['data' => 'action', 'name' => 'Action', 'searchable' => 'false'],
            ['data' => 'created_at', 'name' => 'created_at', 'visible' => false],
            ['data' => 'comment', 'name' => 'comment', 'visible' => false],

        ];

        return json_encode($data);
    }

    public function getColumnsForOverDueLeaseAmountDataTable()
    {
        $data = [
            ['data' => 'lease.id', 'name' => 'lease.id', 'title' => 'ID'],
            ['data' => 'tenant.name', 'name' => 'tenant.name', 'title' => 'Tenant Name'],
            ['data' => 'property.name', 'name' => 'property.name', 'title' => 'Property Name'],
            ['data' => 'unit.number', 'name' => 'unit.number', 'title' => 'Unit'],
            ['data' => 'amount', 'name' => 'amount', 'title' => 'Overdue Amount'],
            ['data' => 'lease.frequency.name', 'name' => 'lease.frequency.name', 'title' => 'Frequency', 'searchable' => 'false'],
            ['data' => 'lease.lease_rent', 'name' => 'lease.lease_rent', 'title' => 'Monthly Rent', 'searchable' => 'false'],
            ['data' => 'overdue_comment', 'name' => 'overdue_comment', 'title' => 'Comment', 'searchable' => 'false'],
            ['data' => 'user_name', 'name' => 'user_name', 'title' => 'Comment By', 'searchable' => 'false'],
            ['data' => 'action', 'name' => 'Action', 'searchable' => 'false'],
            ['data' => 'created_at', 'name' => 'created_at', 'visible' => false],
            ['data' => 'lease.monthly_rent', 'name' => 'lease.monthly_rent', 'title' => 'Monthly Rent', 'visible' => false],
            ['data' => 'comment', 'name' => 'comment', 'visible' => false],

        ];

        return json_encode($data);
    }

    public function orderArrayForOverdueLease()
    {
        return [
            ['name' => 'lease_id', 'order' => true],
            ['name' => 'tenant.name', 'order' => true, 'relationship' => ['model' => 'tenant', 'column_name' => 'name']],
            ['name' => 'property.name', 'order' => true, 'relationship' => ['model' => 'property', 'column_name' => 'name']],
            ['name' => 'unit.number', 'order' => true, 'relationship' => ['model' => 'unit', 'column_name' => 'number']],
            ['name' => 'amount', 'order' => true],
            ['name' => 'lease.frequency.name', 'order' => false],
            ['name' => 'amount', 'order' => true],
            ['name' => 'comment', 'order' => true],
            ['name' => 'lease_id', 'order' => false],
            ['name' => 'Action', 'order' => false],
            ['name' => 'Action', 'order' => false],
            ['name' => 'created_at', 'visible' => false]
        ];
    }

    public function orderArrayForOverdue()
    {
        return [
            ['name' => 'property.name', 'order' => true, 'relationship' => ['model' => 'property', 'column_name' => 'name']],
            ['name' => 'unit.number', 'order' => true, 'relationship' => ['model' => 'unit', 'column_name' => 'number']],
            ['name' => 'amount', 'order' => true],
            ['name' => 'days_over', 'order' => false],
            ['name' => 'comment', 'order' => true],
            ['name' => 'lease_id', 'order' => true],
            ['name' => 'Action', 'order' => false],
            ['name' => 'created_at', 'visible' => false]
        ];
    }

    public function orderingColumnForOverdue()
    {
        return json_encode([['7', 'desc']]);
    }

    public function orderingColumnForOverdueLease()
    {
        return json_encode([['10', 'desc']]);
    }

    public function overdueAjaxListing($request = [])
    {

        $current_user = Auth()->user();

        $query = $this;

        if (isset($request['tenant_id'])) {

            $query = $query->whereHas('lease', function ($q) use ($request) {
                $q->where('tenant_id', $request['tenant_id']);
            });
        }

        return $query->with(['tenant', 'lease', 'property', 'unit', 'commented_by_user'])->whereHas('lease.property.assigned_to', function ($q) use ($current_user) {
            $q->where('user_id', $current_user->id);
        });
    }

    public function getTotalAmount()
    {
        $current_user = Auth()->user();

        return addCommaForNumeric($this->with(['tenant', 'lease'])->whereHas('lease.property.assigned_to', function ($q) use ($current_user) {
            $q->where('user_id', $current_user->id);
        })->sum('amount'));;
    }
}
