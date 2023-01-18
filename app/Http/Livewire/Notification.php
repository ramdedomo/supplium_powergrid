<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;

class Notification extends Component
{

    protected $listeners = ['itemRequested' => '$refresh'];

    public function render()
    {
        $this->user = Auth::user();

        if($this->user->user_type == 1){
            $this->notifications = Notifications::join('user', 'user.id', '=', 'notifications.user_id')
            ->whereNotIn('notifications.notification_type', [100, 102, 0, 1, 2, 3, 4, 5, 6])
            ->where('notifications.is_supply', 1)
            ->orderBy('notifications.created_at', 'DESC')
            ->get();
        }elseif($this->user->user_type == 2){
            $this->notifications = Notifications::join('user', 'user.id', '=', 'notifications.user_id')
            ->where('user.department', Auth::user()->department)
            // ->where('notifications.user_id', $this->user->id)
            ->whereNotIn('notifications.notification_type', [100, 103])
            ->where('notifications.is_supply', 0)
            ->orderBy('notifications.created_at', 'DESC')
            ->get();
        }elseif($this->user->user_type == 3){
            $this->notifications = Notifications::join('user', 'user.id', '=', 'notifications.user_id')
            ->where('user.department', Auth::user()->department)
            ->whereNotIn('notifications.notification_type', [102, 103])
            ->where('notifications.is_supply', 0)
            ->orderBy('notifications.created_at', 'DESC')
            ->get();
        }else{
            $this->notifications = Notifications::join('user', 'user.id', '=', 'notifications.user_id')
            ->where('user.department', Auth::user()->department)
            ->where('user.id', Auth::user()->id)
            ->whereNotIn('notifications.notification_type', [100, 102, 103])
            ->orderBy('notifications.created_at', 'DESC')
            ->get();
        }

        return view('livewire.notification');
    }
}
