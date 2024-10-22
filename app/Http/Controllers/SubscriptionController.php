<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(User $user): JsonResponse
    {
        if(auth()->user()->id === $user->id){
            return response()->json(['message' => "You can't subscribe yourself"], 422);
        }

        if(auth()->user()->subscriptions->contains($user)){
            return response()->json(['message' => "You cannot subscribe to a user you are already subscribed"], 422);
        }

        auth()->user()->subscriptions()->attach($user);

        return response()->json(['message' => 'Subscribed satisfully']);
    }

    public function unsubscribe(User $user): JsonResponse
    {
        if(!(auth()->user()->subscriptions->contains($user))){
            return response()->json(['message' => "You are not subscribed to this user"], 422);
        }

        auth()->user()->subscriptions()->detach($user);

        return response()->json(['message' => 'Unsubscribe satisfully']);
    }
}
