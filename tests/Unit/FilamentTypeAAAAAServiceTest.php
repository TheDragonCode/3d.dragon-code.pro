<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\OrcaSlicer\FilamentService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class FilamentTypeServiceTest extends TestCase
{
    #[DataProvider('detectCases')]
    public function testDetect(?string $vendor, string $filament, ?string $expected): void
    {
        $service = new class extends FilamentService {
            public function exposedDetect(?string $vendor, string $filament): ?string
            {
                $path = $vendor . '/filament/' . $filament . '.json';

                return $this->detect($vendor, $filament, $path);
            }
        };

        $this->assertSame($expected, $service->exposedDetect($vendor, $filament));
    }

    public static function detectCases(): array
    {
        return [
            ['Afinia', 'Afinia ABS', 'ABS'],
            ['Afinia', 'Afinia ABS+', 'ABS+'],
            ['Afinia', 'Afinia ABS@HS', 'ABS HS'],
            ['Afinia', 'Afinia PLA@HS', 'PLA HS'],
            ['Afinia', 'Afinia TPU', 'TPU'],
            ['Afinia', 'Afinia Value ABS', 'ABS'],
            ['Afinia', 'Afinia Value ABS@HS', 'ABS HS'],
            ['Afinia', 'Afinia Value PLA HS', 'PLA HS'],
            ['Afinia', 'Afinia Value PLA-HS', 'PLA HS'],
            ['Afinia', 'Afinia Value PLA@HS', 'PLA HS'],

            ['Anker', 'Anker Generic ASA 0.2 nozzle', 'ASA'],
            ['Anker', 'Anker Generic ASA 0.25 nozzle', 'ASA'],
            ['Anker', 'Anker Generic ASA', 'ASA'],
            ['Anker', 'Anker Generic PA-CF @base', 'PA-CF'],
            ['Anker', 'Anker Generic PC @base', 'PC'],
            ['Anker', 'Anker Generic PETG @base', 'PETG'],
            ['Anker', 'Anker Generic PETG-CF @base', 'PETG-CF'],
            ['Anker', 'Anker Generic PLA 0.25 nozzle', 'PLA'],
            ['Anker', 'Anker Generic PLA Silk 0.2 nozzle', 'PLA Silk'],
            ['Anker', 'Anker Generic PLA Silk 0.25 nozzle', 'PLA Silk'],
            ['Anker', 'Anker Generic PLA Silk', 'PLA Silk'],

            ['Anycubic', 'Anycubic ABS @Anycubic Kobra S1 0.4 nozzle', 'ABS'],
            ['Anycubic', 'Anycubic PLA @Anycubic Kobra S1 0.4 nozzle', 'PLA'],
            ['Anycubic', 'Anycubic PLA High Speed @Anycubic Kobra S1 0.4 nozzle', 'PLA HS'],
            ['Anycubic', 'Anycubic PLA Silk @Anycubic Kobra S1 0.4 nozzle', 'PLA Silk'],
            ['Anycubic', 'Anycubic PLA+ @Anycubic Kobra S1 0.4 nozzle', 'PLA+'],

            ['Artillery', 'Artillery ASA @Artillery M1 Pro 0.8 nozzle', 'ASA'],
            ['Artillery', 'Artillery Generic PETG', 'PETG'],
            ['Artillery', 'Artillery Generic PLA', 'PLA'],
            ['Artillery', 'Artillery Generic PLA-CF', 'PLA-CF'],
            ['Artillery', 'Artillery PET @Artillery M1 Pro 0.2 nozzle', 'PET'],
            ['Artillery', 'Artillery PLA Basic @Artillery M1 Pro 0.2 nozzle', 'PLA'],
            ['Artillery', 'Artillery PLA Basic @Artillery M1 Pro 0.4 nozzle', 'PLA'],

            ['Bambulab', 'Bambu ABS-GF @base', 'ABS-GF'],
            ['Bambulab', 'Bambu ASA-Aero @BBL H2D', 'ASA Aero'],
            ['Bambulab', 'Bambu PET-CF @System', 'PET-CF'],
            ['Bambulab', 'Bambu Support for ABS @base', 'ABS'],

            ['COEX', 'COEX PCTG PRIME @BBL A1M 0.8 nozzle', 'PCTG'],
            ['COEX', 'COEX PETG @BBL A1M 0.4 nozzle', 'PETG'],
            ['COEX', 'COEX PLA @BBL X1C 0.2 nozzle', 'PLA'],

            ['Creality', 'Creality Generic PLA High Speed @Ender-3V3-all', 'PLA HS'],

            ['eSUN', 'eSUN ePLA-LW @System', 'ePLA-LW'],

            ['Afinia', 'fdm_filament_abs', 'ABS'],
            ['Anker', 'fdm_filament_bvoh', 'BVOH'],
            ['Anycubic', 'fdm_filament_common', ''],
            ['Artillery', 'fdm_filament_eva', 'EVA'],
            ['Bambu', 'fdm_filament_hips', 'HIPS'],
            ['Creality', 'fdm_filament_tpu', 'TPU'],
            ['COEX', 'fdm_filament_pla', 'PLA'],

            ['Fiberon', 'Fiberon PA12-CF @base', 'PA12-CF'],

            ['Afinia', 'Generic BVOH @base', 'BVOH'],
            ['Anker', 'Generic EVA @base', 'EVA'],
            ['Anycubic', 'Generic HIPS @base', 'HIPS'],
            ['Artillery', 'Generic PPA-CF @BBL H2D', 'PPA-CF'],

            ['Panchroma', 'Panchroma PLA Silk @base', 'PLA Silk'],
            ['Panchroma', 'Panchroma PLA Stain @base', 'PLA Stain'],
            ['Panchroma', 'Panchroma PLA Starlight @base', 'PLA Starlight'],
            ['Panchroma', 'Panchroma PLA Temp Shift @base', 'PLA Temp Shift'],
            ['Panchroma', 'Panchroma Temp Shift PLA @base', 'PLA Temp Shift'],
            ['Panchroma', 'Panchroma PLA Translucent @base', 'PLA Translucent'],

            ['eSUN', 'eSUN PLA+ @base', 'PLA+'],
            ['SUNLU', 'SUNLU PLA Marble @base', 'PLA Marble'],
            ['SUNLU', 'SUNLU PLA Matte @base', 'PLA Matte'],
            ['SUNLU', 'SUNLU PLA+ 2.0 @base', 'PLA+'],
            ['SUNLU', 'SUNLU Silk PLA+ @base', 'PLA+ Silk'],
            ['SUNLU', 'SUNLU Wood PLA @base', 'PLA Wood'],

            ['SUNLU', 'SUNLU Wood PLA Other @base', 'PLA Wood'],
            ['SUNLU', 'SUNLU EASY PLA @base', 'PLA'],

            ['Foo', 'Unknown profile string', 'Unknown profile string'],
        ];
    }
}
