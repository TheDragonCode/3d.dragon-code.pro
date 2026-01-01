<?php

declare(strict_types=1);

use App\Models\SettingsSection;
use DragonCode\LaravelDeployOperations\Operation;

/*
 * TODO: Загрузить Орку, найти по ключам переводы и записать их в базу
 */
return new class extends Operation {
    protected array $items = [
        'Общая информация' => [
            'Область печати' => [
                'Размер стола',
                'Высота печати',
            ],

            'Аксессуары' => [
                'Тип сопла',
            ],
        ],

        'Экструдер' => [
            'Размер' => [
                'Диаметр сопла',
            ],

            'Ограничения высоты' => [
                'Минимальная высота слоя',
                'Максимальная высота слоя',
            ],

            'Дополнительно' => [
                'Время загрузки прутка',
                'Время выгрузки прутка',
                'Время смены инструмента',
            ],
        ],

        'Ограничения' => [
            'Максимальные скорости перемещения' => [
                'По оси X',
                'По оси Y',
                'По оси Z',
                'Подача экструдера',
            ],

            'Максимальные ускорения' => [
                'По оси X',
                'По оси Y',
                'По оси Z',
                'Подача экструдера',
                'При печати',
                'Откат',
                'Холостые перемещения',
            ],

            'Максимальные рывки' => [
                'По оси X',
                'По оси Y',
                'По оси Z',
                'Рывок экструдера',
            ],
        ],
    ];

    protected array $cached = [];

    public function __invoke(): void
    {
        foreach ($this->items as $parent => $childs) {
            $parentModel = $this->create($parent);

            foreach ($childs as $section => $parameter) {
                $sectionModel = $this->create($section, $parentModel->getKey());

                $this->create($parameter, $sectionModel->getKey());
            }
        }
    }

    protected function create(string $title, ?int $parentId = null): SettingsSection
    {
        return $this->cached[$parentId ?? 0][$title] ??= SettingsSection::create([
            'parent_id' => $parentId,

            'title' => ['ru' => $title],
        ]);
    }
};
