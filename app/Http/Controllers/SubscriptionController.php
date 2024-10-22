<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(User $user): JsonResponse
    {
        auth()->user()->subscriptions()->attach($user);

        return response()->json(['message' => 'Subscribed satisfully']);
    }

    public function unsubscribe(User $user)
    {
        auth()->user()->subscriptions()->detach($user);

        return response()->json(['message' => 'Unsusbcribe satisfully']);
    }
}
