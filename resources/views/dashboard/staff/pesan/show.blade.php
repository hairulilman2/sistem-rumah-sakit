@extends('layouts.dashboard')
@section('title', 'Detail Pesan')
@section('page-title', 'Detail Pesan')

@section('sidebar')
<a href="{{ route('staff.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🏠 Dashboard</span></a>
<a href="{{ route('staff.antrian') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📋 Antrian Harian</span></a>
<a href="{{ route('staff.pesan.index') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600"><span>✉️ Pesan Masuk</span></a>
@endsection

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('staff.pesan.index') }}" class="text-blue-600 text-sm mb-4 inline-block">← Kembali ke Daftar Pesan</a>

    <div class="bg-white rounded-lg shadow-sm p-6 mb-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pesan dari: {{ $pesan->name }}</h3>
        <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
            <div><span class="text-gray-500">Email:</span> <strong>{{ $pesan->email }}</strong></div>
            <div><span class="text-gray-500">Telepon:</span> <strong>{{ $pesan->phone ?? '-' }}</strong></div>
            <div><span class="text-gray-500">Subject:</span> <strong>{{ $pesan->subject }}</strong></div>
            <div><span class="text-gray-500">Tanggal:</span> <strong>{{ $pesan->created_at->format('d M Y H:i') }}</strong></div>
        </div>
        <div class="bg-gray-50 rounded-lg p-4 mt-4">
            <p class="text-sm text-gray-500 mb-2 font-medium">Isi Pesan:</p>
            <p class="text-gray-900">{{ $pesan->message }}</p>
        </div>
    </div>

    @if($pesan->reply)
    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-4">
        <h4 class="font-semibold text-green-800 mb-2">✅ Balasan Anda:</h4>
        <p class="text-green-900">{{ $pesan->reply }}</p>
    </div>
    @endif

    @if($pesan->status !== 'replied')
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Tulis Balasan</h3>
        <form method="POST" action="{{ route('staff.pesan.reply', $pesan->id) }}">
            @csrf
            @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded text-sm">
                <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Balasan *</label>
                <textarea name="reply" rows="6" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tulis balasan Anda..." required>{{ old('reply') }}</textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Kirim Balasan</button>
                <a href="{{ route('staff.pesan.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</a>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection
