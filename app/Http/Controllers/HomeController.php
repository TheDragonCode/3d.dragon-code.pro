<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\UserFilament;
use Inertia\Inertia;

class HomeController
{
    public function __invoke()
    {
        $settings = UserFilament::query()
            ->with([
                'machine.vendor',
                'filament' => ['vendor', 'type'],
                'color',
            ])
            ->orderBy('machine_id')
            ->orderBy('filament_id')
            ->orderBy('color_id')
            ->orderBy('id')
            ->get();

        return Inertia::render('welcome', [
            'settings' => $settings,
        ]);
    }
}
