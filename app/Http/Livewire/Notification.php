<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;

class Notification extends Component
{

    // Request

    // 0 Placed
    // 1 Chair Approve
    // 2 Dean Approve
    // 3 Supply Approve
    // 4 Pick Up
    // 6 Done
    // 5 Canceled
    // 7 Message
    // 8 CED Approve

    // Approval

    // 100 Chair Approval
    // 102 Dean Approval
    // 103 Supply Approval
    // 105 CED Approval
    // 104 Receive

    protected $listeners = ['itemRequested' => '$refresh'];

    public function render()
    {
        $this->user = Auth::user();

        if($this->user->user_type == 1){
            $this->notifications = Notifications::join('user', 'user.id', '=', 'notifications.user_id')
            ->whereNotIn('notifications.notification_type', [105, 100, 102, 0, 1, 2, 3, 4, 5, 6, 8, 10])
            // ->where('notifications.is_supply', 1)
            ->orderBy('notifications.created_at', 'DESC')
            ->select('user.*', 'notifications.*','notifications.created_at as timecreated')
            ->limit(10)
            ->get();
        }elseif($this->user->user_type == 5){
            $this->notifications = Notifications::join('user', 'user.id', '=', 'notifications.user_id')
            ->whereNotIn('notifications.notification_type', [103, 100, 102, 110])
            // ->where('notifications.is_supply', 1)
            ->orderBy('notifications.created_at', 'DESC')
            ->select('user.*', 'notifications.*','notifications.created_at as timecreated')
            ->limit(10)
            ->get();
        }elseif($this->user->user_type == 2){
            $this->notifications = Notifications::join('user', 'user.id', '=', 'notifications.user_id')
            ->where('user.department', Auth::user()->department)
            // ->where('notifications.user_id', $this->user->id)
            ->whereNotIn('notifications.notification_type', [100, 103, 105, 110])
            // ->where('notifications.is_supply', 0)
            ->orderBy('notifications.created_at', 'DESC')
            ->select('user.*', 'notifications.*','notifications.created_at as timecreated')
            ->limit(10)
            ->get();
        }elseif($this->user->user_type == 3){
            $this->notifications = Notifications::join('user', 'user.id', '=', 'notifications.user_id')
            ->where('user.department', Auth::user()->department)
            ->whereNotIn('notifications.notification_type', [102, 103, 105, 110])
            // ->where('notifications.is_supply', 0)
            ->orderBy('notifications.created_at', 'DESC')
            ->select('user.*', 'notifications.*','notifications.created_at as timecreated')
            ->limit(10)
            ->get();
         
        }else{
            $this->notifications = Notifications::join('user', 'user.id', '=', 'notifications.user_id')
            ->where('user.department', Auth::user()->department)
            ->where('user.id', Auth::user()->id)
            ->whereNotIn('notifications.notification_type', [100, 102, 103, 105, 110])
            ->orderBy('notifications.created_at', 'DESC')
            ->select('user.*', 'notifications.*','notifications.created_at as timecreated')
            ->limit(10)
            ->get();
        }

        return view('livewire.notification');
    }
}
