<?php

namespace App\Http\ViewComposer;

use App\Models\Module;
use Illuminate\View\View;
use Route;

class SiderbarComposer
{

    /**
     * @return mixed
     */
    final function getModuleList()
    {
        return Module::where('parent', 0)->where('slug', '!=', 'settings')->orderBy('sort')->with('children')->get()->toArray();
    }

    final function getRoleModuleList()
    {
        return Module::where('parent', 0)->orderBy('sort')->with('children')->get()->toArray();
    }

    final function getSettingList()
    {
        return Module::where('parent', 0)->where('slug', 'settings')->orderBy('sort')->with('children')->first()->toArray();
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('role_modules', $this->getRoleModuleList());
        $view->with('modules', $this->getModuleList());
        $view->with('settings', $this->getSettingList());
        $view->with('current_route_name', Route::currentRouteName());
    }
}
