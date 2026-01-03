<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Pages\HomeService;
use Inertia\Inertia;

class HomeController
{
    public function __invoke(HomeService $home)
    {
        return Inertia::render('welcome', [
            'userFilaments' => $home->userFilaments(),
            'machines'      => $home->machines(),
            'filamentTypes' => $home->filamentTypes(),
            'colors'        => $home->colors(),
        ]);
    }
}
