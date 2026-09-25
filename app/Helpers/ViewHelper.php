<?php

use App\Models\Role;
use App\Models\Status;

function checkInMultiDeminsionalArray($array, $keyToFind, $valueToFind, $getValue = false)
{
    if (!$array) {
        return false;
    }

    foreach ($array as $value) {
        if ($value[$keyToFind] == $valueToFind) {

            if ($getValue) {
                return $value;
            }
            return true;
        }

    }
    return false;
}

function hasRole($slug, $key)
{
    return Auth()->user()->hasPermission($slug, Auth()->user()->role_id, $key);
}

function t($key, $default = null)
{
    $line = __('ui.' . $key);
    if ($line !== 'ui.' . $key) {
        return $line;
    }

    return $default !== null ? $default : $key;
}

function tn($text)
{
    if ($text === null || $text === '') {
        return $text;
    }

    $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '_', $text), '_'));
    foreach (['label.' . $slug, 'nav.' . $slug, 'common.' . $slug, 'status.' . $slug, 'page.' . $slug] as $key) {
        $line = __('ui.' . $key);
        if ($line !== 'ui.' . $key) {
            return $line;
        }
    }

    return $text;
}

function setText($string, $singular = false)
{
    $slug = strtolower(str_replace(' ', '_', $string));
    $key = $singular ? 'module.' . $slug . '_one' : 'module.' . $slug;
    $translated = t($key);
    if ($translated !== $key) {
        return $translated;
    }

    $string = ucwords(str_replace("_", " ", $string));

    if ($singular) {
        $string = Str::singular($string);
    }

    return $string;
}

function checkIfRoleChecked($permissions, $slug, $type)
{
    $value = '';

    if (isset($permissions)) {
        foreach ($permissions as $permission) {
            if ($permission->slug == $slug && $permission->{$type} == 1) {
                $value = 'checked';
            }
        }
    }

    return $value;
}

function uploadCustomFile($file)
{
    $basename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
    $ext = $file->getClientOriginalExtension();
    $name = time() . $basename . "." . $ext;
    $file->move(public_path() . '/files/', $name);
    return '/files/' . $name;
}

function getStoragePath(){
    $public_path = public_path();
    $storage_path = str_replace("public","storage",$public_path);
    return ltrim($storage_path, '/');
}

function getLeasePendingStatus()
{
    $status = Status::where('slug', 'pending')->where('module', 'tenants')->first();
    return $status ? $status->id : null;
}

function getUserAvatar($id = false)
{
    if (!$id) {
        $id = Auth()->user()->id;
    }

    $img = 'assets/img/profile_avatar.jpg';

    $user = \App\User::find($id);
    if ($user && $user->logo && file_exists(public_path($user->logo))) {
        $img = $user->logo;
    }

    return asset($img);
}

function getEmployeeId()
{
    $role = Role::where('slug', 'employee')->first();
    return $role ? $role->id : null;
}

function getTypeId($module, $slug)
{
    $type_model = new \App\Models\Type();

    return $type_model->getTypeId($module, $slug);
}

function checkSelectValue($value, $id)
{
    return isset($value) ? $value == $id ? 'selected' : '' : '';
}

function removeCommaForNumeric(&$request, $keys)
{
    foreach ($keys as $value) {
        if ($request->{$value}) {
            $request->merge([$value => preg_replace('~[,$]~', '', trim($request->{$value}))]);
        }
    }
}

function removeCommaForNumericInArray(&$request, $key, $keys)
{
    $array = [];

    foreach ($request->{$key} as $index => $request_key) {

        foreach ($request_key as $index1 => $value) {

            if (in_array($index1, $keys)) {
                $array[$index][$index1] = preg_replace('~[,$]~', '', $value);
            } else {
                $array[$index][$index1] = $value;
            }

        }
    }

    $request->merge([$key => $array]);
}

function addCommaForNumeric($value)
{
    if (!is_null($value)) {
        return 'KWD ' . number_format($value);
    }
}

function getSingleRelationDataForPDF($row, $row_key)
{
    $single_relationship = explode('.', $row_key);

    if (count($single_relationship) > 1) {
        return $row->{$single_relationship[0]}->{$single_relationship[1]};
    }

    return $row->{$single_relationship[0]};
}

function showInDashboard($widget_id)
{
    $widget_model = new \App\Models\WidgetUser();

    return $widget_model->showInDashboard($widget_id);
}

function getQuarters($start_date, $end_date)
{

    function zero_pad($number)
    {
        if ($number < 10)
            return "0$number";

        return "$number";
    }

    function month_end_date($year, $month_number)
    {
        return date("t", strtotime("$year-$month_number-01"));
    }

    $quarters = array();
    $start_month = date('m', strtotime($start_date));
    $start_year = date('Y', strtotime($start_date));
    $end_month = date('m', strtotime($end_date));
    $end_year = date('Y', strtotime($end_date));
    $start_quarter = ceil($start_month / 3);
    $end_quarter = ceil($end_month / 3);
    $quarter = $start_quarter; // variable to track current quarter
    // Loop over years and quarters to create array
    for ($y = $start_year; $y <= $end_year; $y++) {
        if ($y == $end_year)
            $max_qtr = $end_quarter;
        else
            $max_qtr = 4;

        for ($q = $quarter; $q <= $max_qtr; $q++) {
            $end = substr($y,2);
            $current_quarter = new \stdClass();
            $end_month_num = zero_pad($q * 3);
            $start_month_num = ($end_month_num - 2);
            $current_quarter->period = "Q$q ($end)";
            $current_quarter->period_start = "$y-$start_month_num-01";      // yyyy-mm-dd
            $current_quarter->period_end = "$y-$end_month_num-" . month_end_date($y, $end_month_num);
            $quarters[] = $current_quarter;
            unset($current_quarter);
        }
        $quarter = 1; // reset to 1 for next year
    }
    current($quarters)->period_start = $start_date;
    end($quarters)->period_end = $end_date;

    return $quarters;


}

function getSemiAnnually($start_date, $end_date)
{

    function zero_pad($number)
    {
        if ($number < 10)
            return "0$number";

        return "$number";
    }

    function month_end_date($year, $month_number)
    {
        return date("t", strtotime("$year-$month_number-01"));
    }

    $quarters = array();
    $start_month = date('m', strtotime($start_date));
    $start_year = date('Y', strtotime($start_date));
    $end_month = date('m', strtotime($end_date));
    $end_year = date('Y', strtotime($end_date));
    $start_quarter = ceil($start_month / 6);
    $end_quarter = ceil($end_month / 6);
    $quarter = $start_quarter; // variable to track current quarter
    // Loop over years and quarters to create array
    for ($y = $start_year; $y <= $end_year; $y++) {
        if ($y == $end_year)
            $max_qtr = $end_quarter;
        else
            $max_qtr = 2;

        for ($q = $quarter; $q <= $max_qtr; $q++) {
            $current_quarter = new \stdClass();
            $end_month_num = zero_pad($q * 6);
            $start_month_num = ($end_month_num - 5);
            $current_quarter->period = "SA$q ($y)";
            $current_quarter->period_start = "$y-$start_month_num-01";      // yyyy-mm-dd
            $current_quarter->period_end = "$y-$end_month_num-" . month_end_date($y, $end_month_num);
            $quarters[] = $current_quarter;
            unset($current_quarter);
        }
        $quarter = 1; // reset to 1 for next year
    }
    current($quarters)->period_start = $start_date;
    end($quarters)->period_end = $end_date;

    return $quarters;


}
