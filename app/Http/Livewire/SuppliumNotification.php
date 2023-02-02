<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Carbon\Carbon;
class SuppliumNotification extends Component
{
    use WithPagination;
  
    public function render()
    {
        $this->user = Auth::user();

        if($this->user->user_type == 1){
            $notifications = Notifications::join('user', 'user.id', '=', 'notifications.user_id')
            ->whereNotIn('notifications.notification_type', [105, 100, 102, 0, 1, 2, 3, 4, 5, 6, 8])
            ->select('user.*', 'notifications.*','notifications.created_at as timecreated')
            // ->where('notifications.is_supply', 1)
            ->orderBy('notifications.created_at', 'DESC')
            ->paginate(7);
        }elseif($this->user->user_type == 5){
            $notifications = Notifications::join('user', 'user.id', '=', 'notifications.user_id')
            ->whereNotIn('notifications.notification_type', [103, 100, 102])
            // ->where('notifications.is_supply', 1)
            ->orderBy('notifications.created_at', 'DESC')
            ->select('user.*', 'notifications.*','notifications.created_at as timecreated')
            ->paginate(7);
        }elseif($this->user->user_type == 2){
            $notifications = Notifications::join('user', 'user.id', '=', 'notifications.user_id')
            ->where('user.department', Auth::user()->department)
            // ->where('notifications.user_id', $this->user->id)
            ->whereNotIn('notifications.notification_type', [100, 103, 105])
            ->select('user.*', 'notifications.*','notifications.created_at as timecreated')
            // ->where('notifications.is_supply', 0)
            ->orderBy('notifications.created_at', 'DESC')
            ->paginate(7);
        }elseif($this->user->user_type == 3){
            $notifications = Notifications::join('user', 'user.id', '=', 'notifications.user_id')
            ->where('user.department', Auth::user()->department)
            ->whereNotIn('notifications.notification_type', [102, 103, 105])
            // ->where('notifications.is_supply', 0)
            ->select('user.*', 'notifications.*','notifications.created_at as timecreated')
            ->orderBy('notifications.created_at', 'DESC')
            ->paginate(7);
        }else{
            $notifications = Notifications::join('user', 'user.id', '=', 'notifications.user_id')
            ->where('user.department', Auth::user()->department)
            ->where('user.id', Auth::user()->id)
            ->whereNotIn('notifications.notification_type', [100, 102, 103, 105])
            ->select('user.*', 'notifications.*','notifications.created_at as timecreated')
            ->orderBy('notifications.created_at', 'DESC')
            ->paginate(7);
        }

     

       


        return view('livewire.supplium-notification', ['notifications' =>  $notifications]);
    }
}
