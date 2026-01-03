import { Head } from '@inertiajs/react';

export default function Welcome({ userFilaments, machines, filamentTypes, colors }) {
    return (
            <>
                <Head title="Welcome" />
                <div className="flex min-h-screen flex-col items-center bg-[#EDEDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
                    <div className="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
                        <main className="flex w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
                            <div className="w-full">
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
                                            <select name="machines" id="machine" className="w-full">
                                                <option value="0">- All -</option>

                                                { machines.map((item) => (
                                                        <option value={ item.id }>{ item.vendor.title }&nbsp;{ item.title }</option>
                                                )) }
                                            </select>
                                        </td>

                                        <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                            <select name="machines" id="machine" className="w-full">
                                                <option value="0">- All -</option>

                                                { filamentTypes.map((item) => (
                                                        <option value={ item.id }>{ item.title }</option>
                                                )) }
                                            </select>
                                        </td>

                                        <td className="border border-gray-300 p-3 text-left text-gray-900 dark:border-gray-600 dark:text-gray-200">
                                            <select name="machines" id="machine" className="w-full">
                                                <option value="0">- All -</option>

                                                { colors.map((item) => (
                                                        <option value={ item.id }>{ item.title }</option>
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
                                            User Profiles
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    { userFilaments.map((item) => (
                                            <tr>
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
