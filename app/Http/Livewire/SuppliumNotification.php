<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SuppliumNotification extends Component
{
    use WithPagination;
  
    public function render()
    {
        $this->user = Auth::user();

        if($this->user->user_type == 1){
            $notifications = Notifications::join('user', 'user.id', '=', 'notifications.user_id')
            ->whereNotIn('notifications.notification_type', [105, 100, 102, 0, 1, 2, 3, 4, 5, 6, 8, 10])
            ->select('user.*', 'notifications.*','notifications.created_at as timecreated')
            // ->where('notifications.is_supply', 1)
            ->orderBy('notifications.created_at', 'DESC')
            ->paginate(7);

            return view('livewire.supplium-notification', ['notifications' =>  $notifications]);

        }elseif($this->user->user_type == 5){
            $notifications = Notifications::join('user', 'user.id', '=', 'notifications.user_id')
            ->orderBy('notifications.created_at', 'DESC')
            // ->where('notifications.is_supply', 1)
            ->select('user.*', 'notifications.*','notifications.created_at as timecreated')
            ->get();

            foreach($notifications as $key => $notif){
                if($notif->notification_type == 103 ||
                $notif->notification_type == 102 ||
                $notif->notification_type  == 100 ||
                $notif->notification_type  == 110
                ){
                    unset($notifications[$key]);
                }

                if($notif['user_id'] == Auth::user()->id && 
                ($notif->notification_type  >= 0 &&
                $notif->notification_type  <= 10)
                ){
                    unset($notifications[$key]);
                }
            }

            function paginate($items, $perPage = 5, $page = null, $pageName = 'page')
            {
                $page = $page ?: (Paginator::resolveCurrentPage($pageName) ?: 1);
                $items = $items instanceof Collection ? $items : Collection::make($items);
                return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
                    'path' => Paginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]);
            }

            return view('livewire.supplium-notification', ['notifications' =>  paginate($notifications, 7)]);

        }elseif($this->user->user_type == 2){
    

            $notifications = Notifications::join('user', 'user.id', '=', 'notifications.user_id')
            ->where('user.department', Auth::user()->department)
            ->orderBy('notifications.created_at', 'DESC')
            // ->where('notifications.is_supply', 1)
            ->select('user.*', 'notifications.*','notifications.created_at as timecreated')
            ->get();

            foreach($notifications as $key => $notif){
                if($notif->notification_type == 103 ||
                $notif->notification_type == 100 ||
                $notif->notification_type  == 105 ||
                $notif->notification_type  == 110
                ){
                    unset($notifications[$key]);
                }

                if($notif['user_id'] != Auth::user()->id && 
                ($notif->notification_type  >= 0 &&
                $notif->notification_type  <= 10)
                ){
                    unset($notifications[$key]);
                }
            }

            function paginate($items, $perPage = 5, $page = null, $pageName = 'page')
            {
                $page = $page ?: (Paginator::resolveCurrentPage($pageName) ?: 1);
                $items = $items instanceof Collection ? $items : Collection::make($items);
                return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
                    'path' => Paginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]);
            }

            return view('livewire.supplium-notification', ['notifications' => paginate($notifications, 7)]);


        }elseif($this->user->user_type == 3){

            $notifications = Notifications::join('user', 'user.id', '=', 'notifications.user_id')
            ->where('user.department', Auth::user()->department)
            ->orderBy('notifications.created_at', 'DESC')
            // ->where('notifications.is_supply', 1)
            ->select('user.*', 'notifications.*','notifications.created_at as timecreated')
            ->get();

            foreach($notifications as $key => $notif){
                if($notif->notification_type == 103 ||
                $notif->notification_type == 102 ||
                $notif->notification_type  == 105 ||
                $notif->notification_type  == 110
                ){
                    unset($notifications[$key]);
                }

                if($notif['user_id'] != Auth::user()->id && 
                ($notif->notification_type  >= 0 &&
                $notif->notification_type  <= 10)
                ){
                    unset($notifications[$key]);
                }
            }

            function paginate($items, $perPage = 5, $page = null, $pageName = 'page')
            {
                $page = $page ?: (Paginator::resolveCurrentPage($pageName) ?: 1);
                $items = $items instanceof Collection ? $items : Collection::make($items);
                return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
                    'path' => Paginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]);
            }

            return view('livewire.supplium-notification', ['notifications' => paginate($notifications, 7)]);

        }else{
            $notifications = Notifications::join('user', 'user.id', '=', 'notifications.user_id')
            ->where('user.department', Auth::user()->department)
            ->where('user.id', Auth::user()->id)
            ->whereNotIn('notifications.notification_type', [100, 102, 103, 105, 110])
            ->select('user.*', 'notifications.*','notifications.created_at as timecreated')
            ->orderBy('notifications.created_at', 'DESC')
            ->paginate(7);
        }

     

       


        
    }
}
