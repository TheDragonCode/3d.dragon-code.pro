<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\OrcaSlicer\FilamentTypeService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class FilamentTypeServiceTest extends TestCase
{
    #[DataProvider('detectCases')]
    public function testDetect(string $input, ?string $expected): void
    {
        $service = new class extends FilamentTypeService {
            public function exposedDetect(string $value): ?string
            {
                return $this->detect($value);
            }
        };

        $this->assertSame($expected, $service->exposedDetect($input));
    }

    public static function detectCases(): array
    {
        return [
            ['Afinia ABS', 'ABS'],
            ['Afinia ABS+', 'ABS+'],
            ['Afinia ABS@HS', 'ABS-HS'],
            ['Afinia PLA@HS', 'PLA-HS'],
            ['Afinia TPU', 'TPU'],
            ['Afinia Value ABS', 'ABS'],
            ['Afinia Value ABS@HS', 'ABS-HS'],
            ['Afinia Value PLA HS', 'PLA-HS'],
            ['Afinia Value PLA-HS', 'PLA-HS'],
            ['Afinia Value PLA@HS', 'PLA-HS'],

            ['Anker Generic ASA 0.2 nozzle', 'ASA'],
            ['Anker Generic ASA 0.25 nozzle', 'ASA'],
            ['Anker Generic ASA', 'ASA'],
            ['Anker Generic PA-CF @base', 'PA-CF'],
            ['Anker Generic PC @base', 'PC'],
            ['Anker Generic PETG @base', 'PETG'],
            ['Anker Generic PETG-CF @base', 'PETG-CF'],
            ['Anker Generic PLA 0.25 nozzle', 'PLA'],
            ['Anker Generic PLA Silk 0.2 nozzle', 'PLA Silk'],
            ['Anker Generic PLA Silk 0.25 nozzle', 'PLA Silk'],
            ['Anker Generic PLA Silk', 'PLA Silk'],

            ['Anycubic ABS @Anycubic Kobra S1 0.4 nozzle', 'ABS'],
            ['Anycubic PLA @Anycubic Kobra S1 0.4 nozzle', 'PLA'],
            ['Anycubic PLA High Speed @Anycubic Kobra S1 0.4 nozzle', 'PLA-HS'],
            ['Anycubic PLA Silk @Anycubic Kobra S1 0.4 nozzle', 'PLA Silk'],
            ['Anycubic PLA+ @Anycubic Kobra S1 0.4 nozzle', 'PLA+'],

            ['Artillery ASA @Artillery M1 Pro 0.8 nozzle', 'ASA'],
            ['Artillery Generic PETG', 'PETG'],
            ['Artillery Generic PLA', 'PLA'],
            ['Artillery Generic PLA-CF', 'PLA-CF'],
            ['Artillery PET @Artillery M1 Pro 0.2 nozzle', 'PET'],
            ['Artillery PLA Basic @Artillery M1 Pro 0.2 nozzle', 'PLA'],
            ['Artillery PLA Basic @Artillery M1 Pro 0.4 nozzle', 'PLA'],

            ['Bambu ABS-GF @base', 'ABS-GF'],
            ['Bambu ASA-Aero @BBL H2D', 'ASA Aero'],
            ['Bambu PET-CF @System', 'PET-CF'],
            ['Bambu Support for ABS @base', 'ABS'],

            ['COEX PCTG PRIME @BBL A1M 0.8 nozzle', 'PCTG Prime'],
            ['COEX PETG @BBL A1M 0.4 nozzle', 'PETG'],
            ['COEX PLA @BBL X1C 0.2 nozzle', 'PLA'],

            ['Creality Generic PLA High Speed @Ender-3V3-all', 'PLA-HS'],

            ['eSUN ePLA-LW @System', 'ePLA-LW'],

            ['fdm_filament_abs', 'ABS'],
            ['fdm_filament_bvoh', 'BVOH'],
            ['fdm_filament_common', null],
            ['fdm_filament_eva', 'EVA'],
            ['fdm_filament_hips', 'HIPS'],
            ['fdm_filament_pla', 'PLA'],
            ['fdm_filament_tpu', 'TPU'],

            ['Fiberon PA12-CF @base', 'PA12-CF'],

            ['Generic BVOH @base', 'BVOH'],
            ['Generic EVA @base', 'EVA'],
            ['Generic HIPS @base', 'HIPS'],
            ['Generic PPA-CF @BBL H2D', 'PPA-CF'],

            ['Panchroma PLA Silk @base', 'PLA Silk'],
            ['Panchroma PLA Stain @base', 'PLA Stain'],
            ['Panchroma PLA Starlight @base', 'PLA Starlight'],
            ['Panchroma PLA Temp Shift @base', 'PLA Temp Shift'],
            ['Panchroma PLA Translucent @base', 'PLA Translucent'],

            ['eSUN PLA+ @base', 'PLA+'],
            ['SUNLU PLA Marble @base', 'PLA Marble'],
            ['SUNLU PLA Matte @base', 'PLA Matte'],
            ['SUNLU PLA+ 2.0 @base', 'PLA+'],
            ['SUNLU Silk PLA+ @base', 'PLA+ Silk'],
            ['SUNLU Wood PLA @base', 'PLA Wood'],

            ['Unknown profile string', null],
        ];
    }
}
