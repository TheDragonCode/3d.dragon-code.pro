<?php

declare(strict_types=1);

use App\Models\User;
use DragonCode\LaravelDeployOperations\Operation;

return new class extends Operation {
    public function __invoke(): void
    {
        $user = $this->create();

        $user->markEmailAsVerified();
    }

    protected function create(): User
    {
        return User::create([
            'name'     => config('user.admin.name'),
            'email'    => config('user.admin.email'),
            'password' => config('user.admin.password'),
        ]);
    }
};
