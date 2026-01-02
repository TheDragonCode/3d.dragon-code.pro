import { Head } from '@inertiajs/react';

export default function Welcome({ settings }) {
    return (
            <>
                <Head title="Welcome" />
                <div className="flex min-h-screen flex-col items-center bg-[#EDEDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
                    <div className="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
                        <main className="flex w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
                            <table className="w-full border-collapse border border-gray-400 bg-white text-sm dark:border-gray-500 dark:bg-gray-800">
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
                                        Pressure Advance
                                    </th>
                                    <th className="border border-gray-300 p-3 text-left font-semibold text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                        Flow Ratio
                                    </th>
                                    <th className="border border-gray-300 p-3 text-left font-semibold text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                        Max Volumetric Speed
                                    </th>
                                    <th className="border border-gray-300 p-3 text-left font-semibold text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                        Nozzle Temperature
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                { settings.map((setting) => (
                                        <tr key={ setting.id }>
                                            <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                                { setting.machine.vendor.title }&nbsp;
                                                { setting.machine.title }
                                            </td>
                                            <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                                { setting.filament.vendor.title }&nbsp;
                                                { setting.filament.type.title }<br />
                                            </td>
                                            <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                                { setting.color.title }
                                            </td>
                                            <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                                { setting.pressure_advance }
                                            </td>
                                            <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                                { setting.filament_flow_ratio }
                                            </td>
                                            <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                                { setting.filament_max_volumetric_speed }
                                            </td>
                                            <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                                { setting.nozzle_temperature }
                                            </td>
                                        </tr>
                                )) }
                                </tbody>
                            </table>
                        </main>
                    </div>
                </div>
            </>
    );
}
