<?php

declare(strict_types=1);

use App\Models\Color;
use App\Models\Filament;
use App\Models\FilamentType;
use App\Models\Vendor;
use DragonCode\LaravelDeployOperations\Operation;

return new class extends Operation {
    protected array $items = [
        [
            'vendor' => 'Bambu Lab',
            'type'   => 'PETG',
            'color'  => 'Yellow',
            'title'  => 'Bambu Lab PETG HF Yellow',
        ],
        [
            'vendor' => 'BestFilament',
            'type'   => 'PETG',
            'color'  => 'Green',
            'title'  => 'BestFilament PETG Green',
        ],
        [
            'vendor' => 'BestFilament',
            'type'   => 'PETG',
            'color'  => 'Blue',
            'title'  => 'BestFilament PETG Blue',
        ],
        [
            'vendor' => 'Creality',
            'type'   => 'PETG-HS',
            'color'  => 'Grey',
            'title'  => 'Creality PETG-HS Grey',
        ],
        [
            'vendor' => 'Creality',
            'type'   => 'PETG-HS',
            'color'  => 'White',
            'title'  => 'Creality PETG-HS White',
        ],
        [
            'vendor' => 'Geetech',
            'type'   => 'PLA Silk',
            'color'  => 'Gold',
            'title'  => 'Geetech PLA Silk Gold',
        ],
        [
            'vendor' => 'Syntech',
            'type'   => 'PETG',
            'color'  => 'Blue',
            'title'  => 'Syntech PETG Blue',
        ],
    ];

    public function __invoke(): void
    {
        foreach ($this->items as $item) {
            $vendor = $this->vendor($item['vendor']);
            $type   = $this->type($item['type']);
            $color  = $this->color($item['color']);

            $this->store($vendor, $type, $color, $item['title']);
        }
    }

    protected function store(Vendor $vendor, FilamentType $type, Color $color, string $title): void
    {
        Filament::create([
            'vendor_id'        => $vendor->id,
            'filament_type_id' => $type->id,
            'color_id'         => $color->id,

            'title' => $title,
        ]);
    }

    protected function vendor(string $name): Vendor
    {
        return Vendor::firstOrCreate(['title' => $name]);
    }

    protected function type(string $name): FilamentType
    {
        return FilamentType::firstOrCreate(['title' => $name]);
    }

    protected function color(string $name): Color
    {
        return Color::firstOrCreate(['title' => $name]);
    }
};
