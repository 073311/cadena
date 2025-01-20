<?php

namespace App\Jobs\Auth;

use App\Abstracts\Job;
use App\Events\Auth\RoleCreated;
use App\Events\Auth\RoleCreating;
use App\Interfaces\Job\HasOwner;
use App\Interfaces\Job\HasSource;
use App\Interfaces\Job\ShouldCreate;
use App\Models\Auth\Role;

public function handle()
{
    $user = User::where('id', $this->user->id)->lockForUpdate()->first();

    DB::transaction(function () {
        Reward::create([
            'user_id' => $user->id,
            'amount' => 1,
        ]);
    });
}

