@extends('layouts.dashboard')

@section('title', 'Booking Appointment')
@section('page-title', 'Booking Appointment')

@section('sidebar')
<a href="{{ route('pasien.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-700">
    <span>Dashboard</span>
</a>
<a href="{{ route('pasien.booking') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600">
    <span>Booking Appointment</span>
</a>
<a href="{{ route('home') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-700">
    <span>Kembali ke Home</span>
</a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Form Booking Appointment</h2>
        
        <form method="POST" action="{{ route('pasien.booking.store') }}" class="space-y-6">
            @csrf
            
            <!-- Pilih Dokter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Dokter</label>
                <select name="doctor_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Dokter --</option>
                    @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">
                        {{ $doctor->user->name }} - {{ $doctor->specialization }}
                    </option>
                    @endforeach
                </select>
                @error('doctor_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                <input type="date" name="schedule_date" min="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('schedule_date')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Waktu -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Waktu</label>
                <select name="start_time" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Waktu --</option>
                    <option value="08:00">08:00</option>
                    <option value="09:00">09:00</option>
                    <option value="10:00">10:00</option>
                    <option value="11:00">11:00</option>
                    <option value="13:00">13:00</option>
                    <option value="14:00">14:00</option>
                    <option value="15:00">15:00</option>
                    <option value="16:00">16:00</option>
                </select>
                @error('start_time')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keluhan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Keluhan</label>
                <textarea name="complaint" rows="4" required minlength="10" maxlength="500" placeholder="Jelaskan keluhan Anda (minimal 10 karakter)" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('complaint') }}</textarea>
                @error('complaint')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Minimal 10 karakter, maksimal 500 karakter</p>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Booking Sekarang
                </button>
                <a href="{{ route('pasien.index') }}" class="flex-1 bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300 text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Info -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h3 class="font-semibold text-blue-900 mb-2">Informasi Penting:</h3>
        <ul class="list-disc list-inside text-blue-800 text-sm space-y-1">
            <li>Appointment akan dikonfirmasi oleh staff dalam 1x24 jam</li>
            <li>Harap datang 15 menit sebelum waktu appointment</li>
            <li>Bawa kartu identitas dan kartu BPJS (jika ada)</li>
            <li>Jika berhalangan hadir, mohon hubungi rumah sakit</li>
        </ul>
    </div>
</div>
@endsection
