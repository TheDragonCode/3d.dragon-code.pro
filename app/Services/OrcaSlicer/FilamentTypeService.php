<?php

declare(strict_types=1);

namespace App\Services\OrcaSlicer;

use App\Concerns\WithFilaments;
use App\Enums\SourceType;
use App\Models\Filament;
use App\Models\Map;
use App\Models\Vendor;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class FilamentTypeService
{
    use WithFilaments;

    protected array $reservedWords = [
        'c1 generic',

        'arena',
        'bambu',
        'basic',
        'bignozzle',
        'brand',
        'breakaway',
        'coprint',
        'direct drive',
        'esun',
        'fiberon',
        'fiberthree',
        'fusrock',
        'generic',
        'hatchbox',
        'impact',
        'lancer',
        'material4print',
        'nylex',
        'orcaarena',
        'other',
        'overture',
        'panchroma',
        'polylite',
        'polymaker',
        'polyterra',
        'prime',
        'pro',
        'prusament',
        'rapido',
        'standard',
        'sunlu',
        'support for',
        'tinmorry',
        'universal',
        'value',
        'yumi',
        'ultra',

        'ams',
        'easy',
        'for',
        'fil',
        'ment',
        'orca',
        'rapid',
        'support',
    ];

    protected array $normalize = [
        '-aero'  => ' Aero',
        '-silk'  => ' Silk',
        '-wood'  => ' Wood',
        '-metal' => ' Metal',
        '-dual'  => ' Dual',

        'aero'    => 'Aero',
        'silk'    => 'Silk',
        'wood'    => 'Wood',
        'carbone' => 'CF',
        'metal'   => 'Metal',
        'dual'    => 'Dual',

        'HF Speed' => 'HF',
        'S Nozzle' => 'S',

        '-HS' => ' HS',
        '-HF' => ' HF',
        '-CF' => ' CF',
    ];

    protected array $remove = [
        'fdm_filament_',
        'fdm__filament_',
        '_common',

        'fdm filament ',
        'other',
        'punk',
    ];

    protected array $blacklist = [
        'common',
    ];

    public function import(): void
    {
        Map::query()
            ->with('vendor')
            ->where('type', SourceType::Filament)
            ->each(fn (Map $map) => $this->store($map->vendor, $map));
    }

    protected function store(Vendor $vendor, Map $map): void
    {
        if (! $value = $this->detect($vendor->title, $map->key, $map->path)) {
            return;
        }

        $type = $this->filamentType($value);

        Filament::updateOrCreate([
            'vendor_id'        => $vendor->id,
            'filament_type_id' => $type->id,
        ]);
    }

    protected function detect(string $vendor, string $filament, string $path): string
    {
        return Str::of($filament)
            ->when(
                Str::substrCount($path, '/') === 2,
                fn (Stringable $str) => $str->remove([$vendor, Str::beforeLast($path, '/')], false),
                function (Stringable $str) use ($vendor, $path) {
                    $items = explode('/', $path);

                    return $str->remove([$vendor, $items[2]], false);
                },
            )
            ->pipe(fn (Stringable $str): string => $str
                ->explode(' ')
                ->reject(fn (string $word) => in_array(Str::lower($word), $this->reservedWords, true))
                ->implode(' ')
            )
            ->remove($this->remove, false)
            ->replace(['High Speed', 'Hyper', '@HS', ' HS'], ' HS', false)
            ->replace(['High Flow', 'High-Flow', '@HF', ' HF'], ' HF', false)
            ->replace('plus', '+', false)
            ->replace([' -', ' +'], ['-', '+'])
            ->before('@')
            ->replaceMatches('/(\(.+\))/', '')
            ->replaceMatches('/\d+\.\d+\s?_?nozzle/', '')
            ->replaceMatches('/(SV\d+|Zero)/', '')
            ->replaceMatches('/(VXL\d+\s[a-zA-Z0-9]+)/', '')
            ->replaceMatches('/(Grauts\s[a-zA-Z0-9]+)/', '')
            ->replaceMatches('/(FLEX\d+)/', '')
            ->replaceMatches('/^\s*([STJ]\d+)/', '')
            ->replaceMatches('/(\d+\.\d+[m]*)/', '')
            ->replace(['/', '+', '_'], ['-', '+ ', ' '])
            ->squish()
            ->trim('-_ ')
            ->when(
                fn (Stringable $str) => $str->doesntContain(' '),
                fn (Stringable $str) => $str->upper(),
                function (Stringable $str) {
                    $values = $str->explode(' ');

                    if ($values->count() > 2) {
                        return $str;
                    }

                    $first = $values->first();
                    $last  = $values->last();

                    $firstLength = Str::length($first);
                    $lastLength  = Str::length($last);

                    $firstIsType = in_array($firstLength, [3, 4], true);
                    $lastIsType  = in_array($lastLength, [3, 4], true);

                    if ($firstIsType) {
                        $first = Str::upper($first);
                    }

                    if ($lastIsType) {
                        $last = Str::upper($last);
                    }

                    return new Stringable($first . ' ' . $last);
                }
            )
            ->replace(array_keys($this->normalize), array_values($this->normalize), false)
            ->when(
                fn (Stringable $str) => in_array($str->lower()->value(), $this->blacklist, true),
                fn () => new Stringable
            )
            ->replaceMatches('/^E([A-Z]{3,})/', 'e$1')
            ->replaceMatches('/((?:[A-Z][a-z]+\s+){1,2})([A-Z+]{2,})/', '$2 $1')
            ->squish()
            ->ltrim('+ ')
            ->when(
                fn (Stringable $str) => $str->isMatch('/[A-Z\d]{2,}\sCF/'),
                fn (Stringable $str) => $str->replace(' ', '-'),
            )
            ->toString();
    }
}
