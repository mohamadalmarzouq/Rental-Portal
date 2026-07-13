<?php

namespace App\Http\Controllers\Panel;

use App\Http\ViewComposer\SiderbarComposer;
use App\Repositories\GlobalSearch\GlobalSearch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpJunior\LaravelGlobalSearch\Facades\LaravelGlobalSearch;

class GlobalSearchController extends Controller
{
    public function __construct()
    {
        $this->global_search_repo = new GlobalSearch();
        $this->dataAssign['module'] = 'global_search';
    }

    public function index(Request $request)
    {

        if ($request->has('query') && !is_null($request->get('query'))) {

            $search_results = $this->global_search_repo->search($request->get('query'));

            return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, compact('search_results'));
        }

    }
}
