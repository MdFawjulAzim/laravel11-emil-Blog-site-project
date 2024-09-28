<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriptions;

class SubscriptionsController extends Controller
{
    // সাবস্ক্রিপশন সাবমিট করার জন্য মেথড
    public function subscribe(Request $request)
    {
        // ইমেইল ভ্যালিডেশন এবং সাবস্ক্রিপশন ডাটাবেজে সেভ করা
        $request->validate([
            'email' => 'required|email|unique:subscriptions,email',
        ]);

        Subscriptions::create([
            'email' => $request->email,
        ]);

        // সাবস্ক্রিপশন সম্পন্ন হলে success মেসেজ রিটার্ন
        return back()->with('success', 'Thank you for subscribing!');
    }
}
