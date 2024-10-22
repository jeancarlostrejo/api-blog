<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubscriptionController extends Controller
{
    public function subscribe(User $user): JsonResponse
    {
        if(auth()->user()->id === $user->id){
            return response()->json(['message' => "You can't subscribe yourself"], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if(auth()->user()->subscriptions->contains($user)){
            return response()->json(['message' => "You cannot subscribe to a user you are already subscribed"], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        auth()->user()->subscriptions()->attach($user);

        return response()->json(['message' => 'Subscribed satisfully']);
    }

    public function unsubscribe(User $user): JsonResponse
    {
        if(!(auth()->user()->subscriptions->contains($user))){
            return response()->json(['message' => "You are not subscribed to this user"], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        auth()->user()->subscriptions()->detach($user);

        return response()->json(['message' => 'Unsubscribe satisfully']);
    }

    public function subscribers(User $user)
    {
        $subscribers = $user->subscribers;

        if ($subscribers->isEmpty()) {
            return response()->json(['message' => 'This user does not have any subscribers', 'data' => $subscribers], Response::HTTP_OK);
        }

        return response()->json(['data' => $subscribers]);
    }

    public function subscriptions(User $user)
    {
        $subscriptions = $user->subscriptions;

        if ($subscriptions->isEmpty()) {
            return response()->json(['message' => 'This user does not have any subscriptions', 'data' => $subscriptions], Response::HTTP_OK);
        }

        return response()->json(['data' => $subscriptions]);
    }
}
