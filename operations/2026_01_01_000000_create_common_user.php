<?php

declare(strict_types=1);

use App\Models\User;
use DragonCode\LaravelDeployOperations\Operation;
use Illuminate\Support\Str;

return new class extends Operation {
    public function __invoke(): void
    {
        $user = $this->create();

        $user->markEmailAsVerified();
    }

    protected function create(): User
    {
        return User::create([
            'name'     => config('user.common.name'),
            'email'    => config('user.common.email'),
            'password' => Str::random(128),
        ]);
    }
};
