@extends('layouts.dashboard')
@section('title', 'Pesan Masuk')
@section('page-title', 'Pesan & Pertanyaan Publik')

@section('sidebar')
<a href="{{ route('staff.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🏠 Dashboard</span></a>
<a href="{{ route('staff.antrian') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📋 Antrian Harian</span></a>
<a href="{{ route('staff.pesan.index') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600"><span>✉️ Pesan Masuk</span></a>
@endsection

@section('content')
<div class="mb-4 flex justify-between items-center">
    <p class="text-gray-600">Total pesan: <strong>{{ $pesan->count() }}</strong> — Belum dibaca: <strong class="text-red-600">{{ $unread }}</strong></p>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-x-auto">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengirim</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($pesan as $p)
            <tr class="{{ $p->status === 'unread' ? 'bg-blue-50 font-medium' : '' }}">
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900">{{ $p->name }}</div>
                    <div class="text-xs text-gray-500">{{ $p->email }}</div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($p->subject, 50) }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full
                        {{ $p->status === 'unread' ? 'bg-red-100 text-red-800' :
                           ($p->status === 'replied' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ $p->status === 'unread' ? 'Belum Dibaca' : ($p->status === 'replied' ? 'Sudah Dibalas' : 'Sudah Dibaca') }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $p->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('staff.pesan.show', $p->id) }}" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">
                        {{ $p->status === 'unread' ? 'Baca & Balas' : 'Lihat' }}
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                    <div class="text-4xl mb-2">✉️</div>
                    <p>Belum ada pesan masuk</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
