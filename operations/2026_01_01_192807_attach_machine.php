<?php

declare(strict_types=1);

use App\Models\Machine;
use App\Models\Nozzle;
use App\Models\User;
use DragonCode\LaravelDeployOperations\Operation;

return new class extends Operation {
    public function __invoke(): void
    {
        $this->attach(
            $this->user(),
            $this->machine(),
            $this->nozzle(),
        );
    }

    protected function attach(User $user, Machine $machine, Nozzle $nozzle): void
    {
        $user->machines()->attach($machine, [
            'nozzle_id' => $nozzle->getKey(),

            'filament_load_time'   => 30,
            'filament_unload_time' => 30,

            'can_change_filament' => true,
        ]);
    }

    protected function user(): User
    {
        return User::firstWhere('email', config('user.admin.email'));
    }

    protected function machine(): Machine
    {
        return Machine::firstOrFail();
    }

    protected function nozzle(): Nozzle
    {
        return Nozzle::firstOrCreate(['title' => 0.4]);
    }
};
