<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\HomeFilterRequest;
use App\Services\Pages\HomeService;
use Inertia\Inertia;

class HomeController
{
    public function __invoke(HomeFilterRequest $request, HomeService $home)
    {
        return Inertia::render('welcome', [
            'userFilaments' => $home->userFilaments(
                $request->integer('machine_id'),
                $request->integer('filament_type_id'),
                $request->integer('color_id'),
            ),
            'machines'      => $home->machines(),
            'filamentTypes' => $home->filamentTypes(),
            'colors'        => $home->colors(),
            'filters'       => $request->validated(),
        ]);
    }
}
