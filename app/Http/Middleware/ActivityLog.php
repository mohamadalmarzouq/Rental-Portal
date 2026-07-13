<?php

namespace App\Http\Middleware;

use App\Models\ActivityLogTag;
use Closure;

class ActivityLog
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $app = $next($request);

        if ($request->session()->has('activity_log_data')) {

            $log_data = $request->session()->get('activity_log_data');

            $current_user = Auth()->user();

            $identifier = $log_data['identifier'];

            $activity_log_tag = ActivityLogTag::where('identifier', $identifier)->first();

            $replacers = $current_user->name . ',' . $log_data['subject_type']->{$log_data['name']};

            $description = str_replace(explode(',', $activity_log_tag->wildcards), explode(',', $replacers), $activity_log_tag->body);

            $activity = activity($activity_log_tag->title)
                ->causedBy($current_user)
                ->performedOn($log_data['subject_type'])
                ->log($description);

            $activity->module = $log_data['module'];

            $activity->method = $log_data['method'];

            $activity->save();

            $request->session()->forget('activity_log_data');
        }

        return $app;
    }
}
