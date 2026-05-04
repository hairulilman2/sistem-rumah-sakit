@extends('layouts.public')

@section('title', $doctor->user->name . ' - Rumah Sakit')

@section('content')
<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 flex items-center">
                <div class="h-24 w-24 bg-gray-300 rounded-full flex items-center justify-center mr-6">
                    <svg class="h-16 w-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $doctor->user->name }}</h1>
                    <p class="mt-1 text-lg text-blue-600">{{ $doctor->specialization }}</p>
                    <p class="mt-1 text-sm text-gray-500">{{ $doctor->education }}</p>
                </div>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Pengalaman</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $doctor->experience }} tahun</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">No. STR</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $doctor->str_number }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Tentang</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $doctor->bio ?? 'Dokter spesialis ' . $doctor->specialization . ' dengan pengalaman ' . $doctor->experience . ' tahun.' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Jadwal Praktek -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Jadwal Praktek</h2>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hari</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quota</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($doctor->schedules as $schedule)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $schedule->day_of_week }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $schedule->max_quota }} pasien</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada jadwal praktek</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @auth
        <div class="mt-8">
            <a href="{{ route('pasien.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                Booking Appointment
            </a>
        </div>
        @else
        <div class="mt-8">
            <p class="text-gray-500">Silakan <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700">login</a> untuk booking appointment.</p>
        </div>
        @endauth
    </div>
</div>
@endsection
