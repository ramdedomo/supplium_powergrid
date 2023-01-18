<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if(Auth::user()->user_type == 1){

            if(
                $request->route()->uri() == "list" ||  
                $request->route()->uri() == "myrequests"
                ){
    
                return redirect()->back();
            }

        }elseif(Auth::user()->user_type == 2){

            if(
                // $request->route()->uri() == "users" ||  
                $request->route()->uri() == "items"
                ){
    
                return redirect()->back();
            }

        }elseif(Auth::user()->user_type == 3){

            if(
                // $request->route()->uri() == "users" ||  
                $request->route()->uri() == "items"
                ){
    
                    return redirect()->back();
            }

        }elseif(Auth::user()->user_type == 4){
            
          if(
            $request->route()->uri() == "users" ||  
            $request->route()->uri() == "items" ||
            $request->route()->uri() == "requests"
            ){

                return redirect()->back();
          }

        }else{
            return redirect('/');
        }




        return $next($request);

    }
}
