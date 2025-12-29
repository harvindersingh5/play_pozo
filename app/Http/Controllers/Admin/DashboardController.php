<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SupportMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     *  This function is return to the admin dashboard
    */
    public function dashboard(Request $request){
        try{
            // if role is Administrator 
            if($request->user()->hasRole('Administrator')){
                return view('admin.dashboard');
            }elseif($request->user()->hasRole('User')){
                return view('user-dashboard');
            }elseif($request->user()->hasRole('Subadmin')){
                return view('admin.dashboard');
            }else{
                return redirect()->back()->with('error', 'You are not authorized to access this page');
            }
        }catch(\Exception $e){
            \Log::info("Dashboard Error");
            return redirect()->back();
        }
    }

    public function requestForm(Request $request){
        try{
            return view('auth.request_form');
        }catch(\Exception $e){
            Log::info("Request Form Error");
            return redirect()->back();
        }
    }

    public function sendMessage(Request $request){
       try {
        
            $validatedData = $request->validate([
                'name' => 'required|string|min:2|max:50',
                'email' => 'required|email|max:100',
                'subject' => 'required|string|min:2|max:100',
                'message' => 'required|string|min:10|max:500',
            ]);
            $admin = User::whereHas('roles', function ($query) {
                $query->where('name', 'Administrator');
            })->first();

            if (!$admin) {
                return back()->with('error', 'Something went wrong. Please try again later.');
            }
            $admin->notify(new SupportMessageNotification($validatedData));
            return back()->with('success', 'Your message has been sent successfully!');
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['message' => 'Failed to send your message. Please try again later.']);
        }

    }
}
