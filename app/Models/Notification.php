<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Notification extends Model
{
    protected $fillable = ['identifier', 'ref_id', 'receiver', 'sender', 'replacers', 'read', 'module'];

    public static function deleteRelatedNotification($model)
    {
        return self::whereModule($model->getTable())->whereRefId($model->id)->delete();
    }

    public function tags()
    {
        return $this->belongsTo(NotificationTag::class, 'identifier', 'identifier');
    }

    public function senderData()
    {
        return $this->belongsTo(User::class, 'receiver');
    }

    public function getUnReadNotificationCount()
    {
        $current_user = Auth()->user();

        return $this->where('receiver', $current_user->id)
            ->where('read', 0)
            ->where('sender', '<>', $current_user->id)
            ->count();
    }

    public function getTotalNotificationCount($receiver)
    {
        return $this->where('receiver', $receiver)->where('sender', '<>', $receiver)->count();
    }

    public function getNotifications($limit = 10)
    {
        $current_user = Auth()->user();

        $total_notifications = $this->with('tags')
            ->where('receiver', $current_user->id)
            ->where('sender', '<>', $current_user->id)
            ->orderByRaw('id + 0 desc')
            ->paginate($limit);

        $this->whereReceiver($current_user->id)->update(['read' => 1]);

        return $total_notifications;
    }

    public function sendMail($user_id, $notification,$title = '')
    {

        if ($notification->sender == $notification->receiver)
            return;

        $this->user_model = new User();

        $user_email = $this->user_model->where('id', $user_id)->first()->email;

        $notification_body = $this->makeNotificationBody($notification);

        Mail::raw($notification_body, function ($message) use ($notification, $user_email,$title) {

            $message->to($user_email)->subject($title);

        });
    }

    public function makeNotificationBody($notification)
    {
        $notification->title = $notification->tags->title;

        $body = str_replace(explode(',', $notification->tags->wildcards), explode(',', $notification->replacers), $notification->tags->body);

        $notification->body = $body;

        return $notification->body;
    }
}
