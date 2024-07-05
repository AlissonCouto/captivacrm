<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Lead;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('channel-chat.{companyId}', function (User $user, int $companyId) {
    $company = $user->company()->first();
    // && $user->company()->first()->id == $companyId
    return $company->id === $companyId;
});

Broadcast::channel('channel-total-chat-notifications.{companyId}', function(User $user, int $companyId){
    $company = $user->company()->first();
    return $company->id === $companyId;
});

Broadcast::channel('channel-lead-message-read.{companyId}', function (User $user, int $companyId){
    $company = $user->company()->first();
    return $company->id === $companyId;
});
