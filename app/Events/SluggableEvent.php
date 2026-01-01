<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Database\Eloquent\Model;

class SluggableEvent
{
    public function __construct(Model $model)
    {
        $model->slug = $model->title;
    }
}
