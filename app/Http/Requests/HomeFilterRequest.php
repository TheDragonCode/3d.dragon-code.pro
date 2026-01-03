<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeFilterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'machine_id'       => ['nullable', 'integer', 'min:0'],
            'filament_type_id' => ['nullable', 'integer', 'min:0'],
            'color_id'         => ['nullable', 'integer', 'min:0'],
        ];
    }
}
