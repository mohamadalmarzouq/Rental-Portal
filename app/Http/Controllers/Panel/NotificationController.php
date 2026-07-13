<?php

namespace App\Http\Controllers\Panel;

use App\Models\Notification;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->primary_model = new Notification();
        $this->dataAssign['module'] = 'notifications';
    }

    public function notificationCount()
    {
        return $this->primary_model->getUnReadNotificationCount();
    }

    public function notifications($count = 0)
    {
        $this->dataAssign['data'] = $this->primary_model->getNotifications($count > 0 ? $count : 10);

        $view = $count > 0 ? 'popup_notification' : 'list_notification';

        return view($this->layout_base.'.'.$this->dataAssign['module'].'.'.$view , $this->dataAssign);
    }
}
