<?php

namespace App\Http\Controllers\Panel;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->primary_model = new Language();
        $this->dataAssign['module'] = 'languages';
    }

    public function language()
    {
        $this->dataAssign['data'] = $this->primary_model->first();

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function update(Request $request)
    {
        $locale = $request->input('locale') === 'ar' ? 'ar' : 'en';
        $request->session()->put('locale', $locale);
        app()->setLocale($locale);
        cookie()->queue('locale', $locale, 60 * 24 * 365);

        flash(t('common.language_changed', 'Language Changed'), 'success');

        return back();
    }

}
