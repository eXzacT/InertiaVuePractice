<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationSeenController extends Controller
{
    public function __invoke(DatabaseNotification $notification){
        
        //usually laravel does this automatically but that's only if the model and the policy have same name
        //need to register policy because we don't have Notification model->AUTHSERVICEPROVIDER
        $this->authorize('update',$notification);
        $notification->markAsRead();

        return redirect()->back()->with('success',"Notification marked as read!");
    }
}
