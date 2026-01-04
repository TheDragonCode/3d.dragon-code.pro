import { Head, router } from '@inertiajs/react';
import { type ChangeEvent, useEffect, useState } from 'react';

type Machine = {
    id: number;
    title: string;
    cover: string;
    vendor: {
        title: string;
    };
};

type FilamentType = {
    id: number;
    title: string;
};

type Color = {
    id: number;
    title: string;
};

type UserFilament = {
    machine_id: number;
    filament_id: number;
    color_id: number;
    machine: Machine;
    filament: {
        vendor: {
            title: string;
        };
        type: FilamentType;
    };
    color: Color;
    pressure_advance: number;
    filament_flow_ratio: number;
    filament_max_volumetric_speed: number;
    nozzle_temperature: number;
    users_count: number;
};

type Filters = {
    machine_id: number;
    filament_type_id: number;
    color_id: number;
};

type WelcomeProps = {
    userFilaments: UserFilament[];
    machines: Machine[];
    filamentTypes: FilamentType[];
    colors: Color[];
    filters: Filters;
};

export default function Welcome({ userFilaments, machines, filamentTypes, colors, filters }: WelcomeProps) {
    const [selectedFilters, setSelectedFilters] = useState<Filters>(filters);

    useEffect(() => {
        setSelectedFilters(filters);
    }, [filters]);

    const handleSelectChange = (key: keyof Filters) => (event: ChangeEvent<HTMLSelectElement>) => {
        const value = Number(event.target.value);
        const nextFilters: Filters = { ...selectedFilters, [key]: value };

        setSelectedFilters(nextFilters);

        router.visit('/', {
            method: 'get',
            data: nextFilters,
            preserveState: true,
            preserveScroll: true,
            replace: true
        });
    };

    return (
            <>
                <Head title="3D Filament Settings" />
                <div className="flex min-h-screen flex-col items-center bg-[#EDEDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
                    <div className="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
                        <main className="flex w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
                            <div className="w-full">
                                <h1 className="mb-4 text-3xl">
                                    3D Filament Settings
                                </h1>

                                <table className="w-full border-collapse border border-gray-400 bg-white text-sm dark:border-gray-500 dark:bg-gray-800 mb-4">
                                    <thead>
                                    <tr>
                                        <th className="border border-gray-300 p-3 text-left font-semibold text-gray-900 dark:border-gray-600 dark:text-gray-200">Printer</th>
                                        <th className="border border-gray-300 p-3 text-left font-semibold text-gray-900 dark:border-gray-600 dark:text-gray-200">Filament</th>
                                        <th className="border border-gray-300 p-3 text-left font-semibold text-gray-900 dark:border-gray-600 dark:text-gray-200">Color</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                            <select
                                                    name="machines"
                                                    className="w-full"
                                                    onChange={ handleSelectChange('machine_id') }
                                                    value={ selectedFilters.machine_id }>
                                                <option value="0">- All -</option>

                                                { machines.map((item) => (
                                                        <option
                                                                key={ item.id }
                                                                value={ item.id }>{ item.vendor.title }&nbsp;{ item.title }</option>
                                                )) }
                                            </select>
                                        </td>

                                        <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                            <select
                                                    name="filamentTypes"
                                                    className="w-full"
                                                    onChange={ handleSelectChange('filament_type_id') }
                                                    value={ selectedFilters.filament_type_id }>
                                                <option value="0">- All -</option>

                                                { filamentTypes.map((item) => (
                                                        <option
                                                                key={ item.id }
                                                                value={ item.id }>{ item.title }</option>
                                                )) }
                                            </select>
                                        </td>

                                        <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                            <select
                                                    name="colors"
                                                    className="w-full"
                                                    onChange={ handleSelectChange('color_id') }
                                                    value={ selectedFilters.color_id }>
                                                <option value="0">- All -</option>

                                                { colors.map((item) => (
                                                        <option
                                                                key={ item.id }
                                                                value={ item.id }>{ item.title }</option>
                                                )) }
                                            </select>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table className="border-collapse border border-gray-400 bg-white text-sm dark:border-gray-500 dark:bg-gray-800">
                                    <thead>
                                    <tr>
                                        <th className="border border-gray-300 p-3 text-left font-semibold text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                            Printer
                                        </th>
                                        <th className="border border-gray-300 p-3 text-left font-semibold text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                            Filament
                                        </th>
                                        <th className="border border-gray-300 p-3 text-left font-semibold text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                            Color
                                        </th>
                                        <th className="border border-gray-300 p-3 text-left font-semibold text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                            Average Pressure Advance
                                        </th>
                                        <th className="border border-gray-300 p-3 text-left font-semibold text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                            Average Flow Ratio
                                        </th>
                                        <th className="border border-gray-300 p-3 text-left font-semibold text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                            Average Max Volumetric Speed
                                        </th>
                                        <th className="border border-gray-300 p-3 text-left font-semibold text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                            Average Nozzle Temperature
                                        </th>
                                        <th className="border border-gray-300 p-3 text-left font-semibold text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                            By User Profiles
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    { userFilaments.map((item) => (
                                            <tr key={ `${ item.machine_id }-${ item.filament_id }-${ item.color_id }` }>
                                                <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                                    { item.machine.vendor.title }&nbsp;
                                                    { item.machine.title }
                                                </td>
                                                <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                                    { item.filament.vendor.title }&nbsp;
                                                    { item.filament.type.title }<br />
                                                </td>
                                                <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                                    { item.color.title }
                                                </td>
                                                <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                                    { item.pressure_advance }
                                                </td>
                                                <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                                    { item.filament_flow_ratio }
                                                </td>
                                                <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                                    { item.filament_max_volumetric_speed }
                                                </td>
                                                <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                                    { item.nozzle_temperature }
                                                </td>
                                                <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                                    { item.users_count }
                                                </td>
                                            </tr>
                                    )) }
                                    </tbody>
                                </table>
                            </div>
                        </main>
                    </div>
                </div>
            </>
    );
}
