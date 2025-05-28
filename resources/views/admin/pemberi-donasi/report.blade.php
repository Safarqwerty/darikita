<x-admin-layout>
    <x-slot name="header">
        Laporan Donasi
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Total Donasi per Program -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Total Donasi per Program</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="p-2 border-b">Program</th>
                                <th class="p-2 border-b">Total Donasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($donationsByProgram as $donation)
                                <tr>
                                    <td class="p-2 border-b">
                                        {{ $donation->donasi->nama_bencana ?? 'Program tidak ditemukan' }}
                                    </td>
                                    <td class="p-2 border-b">
                                        Rp {{ number_format($donation->total_donation, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center p-2">Belum ada data donasi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Total Donasi per Bulan -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Total Donasi per Bulan</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="p-2 border-b">Bulan</th>
                                <th class="p-2 border-b">Total Donasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $months = [
                                    1 => 'Januari',
                                    2 => 'Februari',
                                    3 => 'Maret',
                                    4 => 'April',
                                    5 => 'Mei',
                                    6 => 'Juni',
                                    7 => 'Juli',
                                    8 => 'Agustus',
                                    9 => 'September',
                                    10 => 'Oktober',
                                    11 => 'November',
                                    12 => 'Desember',
                                ];
                            @endphp
                            @forelse($donationsByMonth as $donation)
                                <tr>
                                    <td class="p-2 border-b">
                                        {{ $months[$donation->month] ?? '' }} {{ $donation->year }}
                                    </td>
                                    <td class="p-2 border-b">
                                        Rp {{ number_format($donation->total_donation, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center p-2">Belum ada data donasi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <a href="{{ route('pemberi-donasi.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</x-admin-layout>
