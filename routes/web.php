<?php

use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\DoctorPublicController;
use App\Http\Controllers\Public\ServicePublicController;
use App\Http\Controllers\Public\SchedulePublicController;
use App\Http\Controllers\Public\NewsPublicController;
use App\Http\Controllers\Public\FacilityPublicController;
use App\Http\Controllers\Public\GalleryPublicController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\ProfileController as PublicProfileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [PublicProfileController::class, 'index'])->name('profil');
Route::get('/dokter', [DoctorPublicController::class, 'index'])->name('dokter.index');
Route::get('/dokter/{id}', [DoctorPublicController::class, 'show'])->name('dokter.show');
Route::get('/layanan', [ServicePublicController::class, 'index'])->name('layanan.index');
Route::get('/jadwal', [SchedulePublicController::class, 'index'])->name('jadwal.index');
Route::get('/berita', [NewsPublicController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [NewsPublicController::class, 'show'])->name('berita.show');
Route::get('/fasilitas', [FacilityPublicController::class, 'index'])->name('fasilitas.index');
Route::get('/galeri', [GalleryPublicController::class, 'index'])->name('galeri.index');
Route::get('/kontak', [ContactController::class, 'index'])->name('kontak.index');
Route::post('/kontak', [ContactController::class, 'store'])->name('kontak.store');

// Dashboard route
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->hasRole('super-admin')) {
        return redirect()->route('super-admin.index');
    } elseif ($user->hasRole('admin')) {
        return redirect()->route('admin.index');
    } elseif ($user->hasRole('dokter')) {
        return redirect()->route('dashboard.dokter.index');
    } elseif ($user->hasRole('staff')) {
        return redirect()->route('staff.index');
    } elseif ($user->hasRole('pasien')) {
        return redirect()->route('pasien.index');
    }
    
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard routes per role
Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {

    // Super Admin routes
    Route::middleware('role:super-admin')->prefix('super-admin')->name('super-admin.')->group(function () {
        Route::get('/', function () {
            $stats = [
                'users' => \App\Models\User::count(),
                'doctors' => \App\Models\Doctor::count(),
                'appointments' => \App\Models\Appointment::count(),
                'news' => \App\Models\News::count(),
            ];
            return view('dashboard.super-admin.index', compact('stats'));
        })->name('index');
    });

    // ===================== ADMIN ROUTES =====================
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/', function () {
            $stats = [
                'doctors' => \App\Models\Doctor::count(),
                'appointments_pending' => \App\Models\Appointment::where('status', 'pending')->count(),
                'appointments_today' => \App\Models\Appointment::whereDate('schedule_date', today())->count(),
                'news' => \App\Models\News::where('status', 'published')->count(),
                'patients' => \App\Models\Patient::count(),
                'facilities' => \App\Models\Facility::count(),
            ];
            return view('dashboard.admin.index', compact('stats'));
        })->name('index');

        // CRUD Dokter
        Route::get('/dokter', function () {
            $doctors = \App\Models\Doctor::with(['user', 'department'])->latest()->get();
            return view('dashboard.admin.dokter.index', compact('doctors'));
        })->name('dokter.index');
        Route::get('/dokter/create', function () {
            $departments = \App\Models\Department::all();
            $users = \App\Models\User::role('dokter')->get();
            return view('dashboard.admin.dokter.create', compact('departments', 'users'));
        })->name('dokter.create');
        Route::post('/dokter', function (\Illuminate\Http\Request $r) {
            $r->validate([
                'user_id' => 'required|exists:users,id',
                'specialization' => 'required|string',
                'education' => 'required|string',
                'experience' => 'required|integer|min:0',
                'bio' => 'nullable|string',
                'str_number' => 'nullable|string',
                'department_id' => 'nullable|exists:departments,id',
            ]);
            \App\Models\Doctor::create($r->except(['_token']));
            return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil ditambahkan');
        })->name('dokter.store');
        Route::get('/dokter/{id}/edit', function ($id) {
            $doctor = \App\Models\Doctor::findOrFail($id);
            $departments = \App\Models\Department::all();
            return view('dashboard.admin.dokter.edit', compact('doctor', 'departments'));
        })->name('dokter.edit');
        Route::put('/dokter/{id}', function (\Illuminate\Http\Request $r, $id) {
            $doctor = \App\Models\Doctor::findOrFail($id);
            $r->validate([
                'specialization' => 'required|string',
                'education' => 'required|string',
                'experience' => 'required|integer|min:0',
                'bio' => 'nullable|string',
                'str_number' => 'nullable|string',
                'department_id' => 'nullable|exists:departments,id',
                'is_active' => 'boolean',
            ]);
            $doctor->update($r->except(['_token', '_method']));
            return redirect()->route('admin.dokter.index')->with('success', 'Data dokter berhasil diupdate');
        })->name('dokter.update');
        Route::delete('/dokter/{id}', function ($id) {
            \App\Models\Doctor::findOrFail($id)->delete();
            return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil dihapus');
        })->name('dokter.destroy');

        // CRUD Jadwal
        Route::get('/jadwal', function () {
            $schedules = \App\Models\DoctorSchedule::with('doctor.user')->latest()->get();
            return view('dashboard.admin.jadwal.index', compact('schedules'));
        })->name('jadwal.index');
        Route::get('/jadwal/create', function () {
            $doctors = \App\Models\Doctor::with('user')->get();
            return view('dashboard.admin.jadwal.create', compact('doctors'));
        })->name('jadwal.create');
        Route::post('/jadwal', function (\Illuminate\Http\Request $r) {
            $r->validate([
                'doctor_id' => 'required|exists:doctors,id',
                'day_of_week' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
                'start_time' => 'required',
                'end_time' => 'required',
                'max_quota' => 'required|integer|min:1',
            ]);
            \App\Models\DoctorSchedule::create(array_merge($r->except(['_token']), ['is_active' => true]));
            return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
        })->name('jadwal.store');
        Route::delete('/jadwal/{id}', function ($id) {
            \App\Models\DoctorSchedule::findOrFail($id)->delete();
            return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus');
        })->name('jadwal.destroy');

        // CRUD Berita
        Route::get('/berita', function () {
            $news = \App\Models\News::with(['author', 'category'])->latest()->get();
            $categories = \App\Models\NewsCategory::all();
            return view('dashboard.admin.berita.index', compact('news', 'categories'));
        })->name('berita.index');
        Route::get('/berita/create', function () {
            $categories = \App\Models\NewsCategory::all();
            return view('dashboard.admin.berita.create', compact('categories'));
        })->name('berita.create');
        Route::post('/berita', function (\Illuminate\Http\Request $r) {
            $r->validate([
                'title' => 'required|string|max:255',
                'excerpt' => 'nullable|string',
                'body' => 'required|string',
                'status' => 'required|in:draft,published',
                'category_id' => 'nullable|exists:news_categories,id',
            ]);
            $slug = \Illuminate\Support\Str::slug($r->title) . '-' . time();
            \App\Models\News::create([
                'author_id' => auth()->id(),
                'category_id' => $r->category_id,
                'title' => $r->title,
                'slug' => $slug,
                'excerpt' => $r->excerpt,
                'body' => $r->body,
                'status' => $r->status,
                'published_at' => $r->status === 'published' ? now() : null,
            ]);
            return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil disimpan');
        })->name('berita.store');
        Route::get('/berita/{id}/edit', function ($id) {
            $news = \App\Models\News::findOrFail($id);
            $categories = \App\Models\NewsCategory::all();
            return view('dashboard.admin.berita.edit', compact('news', 'categories'));
        })->name('berita.edit');
        Route::put('/berita/{id}', function (\Illuminate\Http\Request $r, $id) {
            $news = \App\Models\News::findOrFail($id);
            $r->validate([
                'title' => 'required|string|max:255',
                'excerpt' => 'nullable|string',
                'body' => 'required|string',
                'status' => 'required|in:draft,published',
                'category_id' => 'nullable|exists:news_categories,id',
            ]);
            $news->update([
                'category_id' => $r->category_id,
                'title' => $r->title,
                'excerpt' => $r->excerpt,
                'body' => $r->body,
                'status' => $r->status,
                'published_at' => ($r->status === 'published' && !$news->published_at) ? now() : $news->published_at,
            ]);
            return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diupdate');
        })->name('berita.update');
        Route::delete('/berita/{id}', function ($id) {
            \App\Models\News::findOrFail($id)->delete();
            return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus');
        })->name('berita.destroy');

        // CRUD Fasilitas
        Route::get('/fasilitas', function () {
            $facilities = \App\Models\Facility::latest()->get();
            return view('dashboard.admin.fasilitas.index', compact('facilities'));
        })->name('fasilitas.index');
        Route::post('/fasilitas', function (\Illuminate\Http\Request $r) {
            $r->validate(['name' => 'required|string', 'description' => 'nullable|string', 'category' => 'nullable|string']);
            \App\Models\Facility::create(array_merge($r->except(['_token']), ['is_active' => true]));
            return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil ditambahkan');
        })->name('fasilitas.store');
        Route::put('/fasilitas/{id}', function (\Illuminate\Http\Request $r, $id) {
            $facility = \App\Models\Facility::findOrFail($id);
            $r->validate(['name' => 'required|string', 'description' => 'nullable|string', 'category' => 'nullable|string']);
            $facility->update($r->except(['_token', '_method']));
            return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil diupdate');
        })->name('fasilitas.update');
        Route::delete('/fasilitas/{id}', function ($id) {
            \App\Models\Facility::findOrFail($id)->delete();
            return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil dihapus');
        })->name('fasilitas.destroy');

        // CRUD Layanan
        Route::get('/layanan', function () {
            $services = \App\Models\Service::with('department')->latest()->get();
            $departments = \App\Models\Department::all();
            return view('dashboard.admin.layanan.index', compact('services', 'departments'));
        })->name('layanan.index');
        Route::post('/layanan', function (\Illuminate\Http\Request $r) {
            $r->validate(['name' => 'required|string', 'description' => 'nullable|string', 'price_range' => 'nullable|string']);
            $slug = \Illuminate\Support\Str::slug($r->name) . '-' . time();
            \App\Models\Service::create(array_merge($r->except(['_token']), ['slug' => $slug, 'is_active' => true]));
            return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil ditambahkan');
        })->name('layanan.store');
        Route::put('/layanan/{id}', function (\Illuminate\Http\Request $r, $id) {
            $service = \App\Models\Service::findOrFail($id);
            $r->validate(['name' => 'required|string', 'description' => 'nullable|string', 'price_range' => 'nullable|string']);
            $service->update($r->except(['_token', '_method']));
            return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil diupdate');
        })->name('layanan.update');
        Route::delete('/layanan/{id}', function ($id) {
            \App\Models\Service::findOrFail($id)->delete();
            return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil dihapus');
        })->name('layanan.destroy');

        // CRUD Galeri
        Route::get('/galeri', function () {
            $galleries = \App\Models\Gallery::latest()->get();
            return view('dashboard.admin.galeri.index', compact('galleries'));
        })->name('galeri.index');
        Route::post('/galeri', function (\Illuminate\Http\Request $r) {
            $r->validate(['title' => 'required|string', 'category' => 'nullable|string', 'description' => 'nullable|string']);
            \App\Models\Gallery::create($r->except(['_token']));
            return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil ditambahkan');
        })->name('galeri.store');
        Route::delete('/galeri/{id}', function ($id) {
            \App\Models\Gallery::findOrFail($id)->delete();
            return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil dihapus');
        })->name('galeri.destroy');

        // Laporan & Statistik
        Route::get('/laporan', function () {
            $appointments_by_status = \App\Models\Appointment::selectRaw('status, count(*) as total')->groupBy('status')->get();
            $appointments_per_month = \App\Models\Appointment::selectRaw('MONTH(schedule_date) as bln, count(*) as total')
                ->whereYear('schedule_date', date('Y'))->groupBy('bln')->get();
            $top_doctors = \App\Models\Doctor::withCount('appointments')->with('user')->orderByDesc('appointments_count')->take(5)->get();
            $recent_appointments = \App\Models\Appointment::with(['patient.user', 'doctor.user'])->latest()->take(20)->get();
            return view('dashboard.admin.laporan.index', compact(
                'appointments_by_status', 'appointments_per_month', 'top_doctors', 'recent_appointments'
            ));
        })->name('laporan.index');
    });

    // ===================== DOKTER ROUTES =====================
    Route::middleware(['role:dokter', 'ensure.doctor'])->prefix('dokter')->name('dashboard.dokter.')->group(function () {
        Route::get('/', function () {
            $doctor = auth()->user()->doctor;
            if (!$doctor) return redirect()->route('home')->with('error', 'Data dokter tidak ditemukan');
            $appointments_today = \App\Models\Appointment::where('doctor_id', $doctor->id)
                ->whereDate('schedule_date', today())->with(['patient.user'])->get();
            $appointments_pending = \App\Models\Appointment::where('doctor_id', $doctor->id)->where('status', 'pending')->count();
            return view('dashboard.dokter.index', compact('doctor', 'appointments_today', 'appointments_pending'));
        })->name('index');

        // Update profil dokter
        Route::get('/profil', function () {
            $doctor = auth()->user()->doctor;
            $departments = \App\Models\Department::all();
            return view('dashboard.dokter.profil', compact('doctor', 'departments'));
        })->name('profil');
        Route::put('/profil', function (\Illuminate\Http\Request $r) {
            $doctor = auth()->user()->doctor;
            $r->validate([
                'specialization' => 'required|string',
                'education' => 'required|string',
                'experience' => 'required|integer|min:0',
                'bio' => 'nullable|string',
                'str_number' => 'nullable|string',
            ]);
            $doctor->update($r->except(['_token', '_method']));
            // Update nama user juga
            if ($r->name) auth()->user()->update(['name' => $r->name, 'phone' => $r->phone]);
            return redirect()->route('dashboard.dokter.profil')->with('success', 'Profil berhasil diupdate');
        })->name('profil.update');

        // Kelola jadwal praktek
        Route::get('/jadwal', function () {
            $doctor = auth()->user()->doctor;
            $schedules = \App\Models\DoctorSchedule::where('doctor_id', $doctor->id)->get();
            return view('dashboard.dokter.jadwal.index', compact('doctor', 'schedules'));
        })->name('jadwal.index');
        Route::post('/jadwal', function (\Illuminate\Http\Request $r) {
            $doctor = auth()->user()->doctor;
            $r->validate([
                'day_of_week' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
                'start_time' => 'required',
                'end_time' => 'required',
                'max_quota' => 'required|integer|min:1',
            ]);
            \App\Models\DoctorSchedule::create(array_merge($r->except(['_token']), ['doctor_id' => $doctor->id, 'is_active' => true]));
            return redirect()->route('dashboard.dokter.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
        })->name('jadwal.store');
        Route::delete('/jadwal/{id}', function ($id) {
            $doctor = auth()->user()->doctor;
            $schedule = \App\Models\DoctorSchedule::where('id', $id)->where('doctor_id', $doctor->id)->firstOrFail();
            $schedule->delete();
            return redirect()->route('dashboard.dokter.jadwal.index')->with('success', 'Jadwal berhasil dihapus');
        })->name('jadwal.destroy');

        // Semua appointment dokter
        Route::get('/appointments', function () {
            $doctor = auth()->user()->doctor;
            $appointments = \App\Models\Appointment::where('doctor_id', $doctor->id)
                ->with(['patient.user'])->latest()->get();
            return view('dashboard.dokter.appointments', compact('appointments'));
        })->name('appointments');
        Route::post('/appointments/{id}/done', function ($id) {
            $doctor = auth()->user()->doctor;
            $appointment = \App\Models\Appointment::where('id', $id)->where('doctor_id', $doctor->id)->firstOrFail();
            $appointment->update(['status' => 'done']);
            return back()->with('success', 'Status appointment diupdate ke Done');
        })->name('appointments.done');

        // Artikel kesehatan
        Route::get('/artikel', function () {
            $articles = \App\Models\News::where('author_id', auth()->id())->latest()->get();
            $categories = \App\Models\NewsCategory::all();
            return view('dashboard.dokter.artikel.index', compact('articles', 'categories'));
        })->name('artikel.index');
        Route::get('/artikel/create', function () {
            $categories = \App\Models\NewsCategory::all();
            return view('dashboard.dokter.artikel.create', compact('categories'));
        })->name('artikel.create');
        Route::post('/artikel', function (\Illuminate\Http\Request $r) {
            $r->validate([
                'title' => 'required|string|max:255',
                'excerpt' => 'nullable|string',
                'body' => 'required|string',
                'status' => 'required|in:draft,published',
                'category_id' => 'nullable|exists:news_categories,id',
            ]);
            $slug = \Illuminate\Support\Str::slug($r->title) . '-' . time();
            \App\Models\News::create([
                'author_id' => auth()->id(),
                'category_id' => $r->category_id,
                'title' => $r->title,
                'slug' => $slug,
                'excerpt' => $r->excerpt,
                'body' => $r->body,
                'status' => $r->status,
                'published_at' => $r->status === 'published' ? now() : null,
            ]);
            return redirect()->route('dashboard.dokter.artikel.index')->with('success', 'Artikel berhasil disimpan');
        })->name('artikel.store');
        Route::delete('/artikel/{id}', function ($id) {
            $news = \App\Models\News::where('id', $id)->where('author_id', auth()->id())->firstOrFail();
            $news->delete();
            return redirect()->route('dashboard.dokter.artikel.index')->with('success', 'Artikel berhasil dihapus');
        })->name('artikel.destroy');
    });

    // ===================== STAFF ROUTES =====================
    Route::middleware('role:staff')->prefix('staff')->name('staff.')->group(function () {
        Route::get('/', function () {
            $appointments_pending = \App\Models\Appointment::where('status', 'pending')
                ->with(['patient.user', 'doctor.user'])->latest()->get();
            $appointments_today = \App\Models\Appointment::whereDate('schedule_date', today())->count();
            return view('dashboard.staff.index', compact('appointments_pending', 'appointments_today'));
        })->name('index');

        // Konfirmasi/Tolak appointment
        Route::post('/appointments/{id}/confirm', function ($id) {
            $appointment = \App\Models\Appointment::findOrFail($id);
            $appointment->update(['status' => 'confirmed']);
            \App\Models\Notification::create([
                'user_id' => $appointment->patient->user_id,
                'title' => 'Appointment Dikonfirmasi',
                'message' => 'Appointment Anda telah dikonfirmasi',
                'type' => 'success',
            ]);
            return back()->with('success', 'Appointment berhasil dikonfirmasi');
        })->name('appointments.confirm');
        Route::post('/appointments/{id}/reject', function ($id) {
            $appointment = \App\Models\Appointment::findOrFail($id);
            $appointment->update(['status' => 'cancelled']);
            \App\Models\Notification::create([
                'user_id' => $appointment->patient->user_id,
                'title' => 'Appointment Ditolak',
                'message' => 'Appointment Anda ditolak',
                'type' => 'error',
            ]);
            return back()->with('success', 'Appointment berhasil ditolak');
        })->name('appointments.reject');
        Route::post('/appointments/{id}/done', function ($id) {
            $appointment = \App\Models\Appointment::findOrFail($id);
            $appointment->update(['status' => 'done']);
            return back()->with('success', 'Appointment selesai');
        })->name('appointments.done');

        // Antrian harian
        Route::get('/antrian', function () {
            $antrian = \App\Models\Appointment::whereDate('schedule_date', today())
                ->with(['patient.user', 'doctor.user'])->orderBy('start_time')->get();
            return view('dashboard.staff.antrian', compact('antrian'));
        })->name('antrian');

        // Pesan/Kontak
        Route::get('/pesan', function () {
            $pesan = \App\Models\Contact::latest()->get();
            $unread = \App\Models\Contact::unread()->count();
            return view('dashboard.staff.pesan.index', compact('pesan', 'unread'));
        })->name('pesan.index');
        Route::get('/pesan/{id}', function ($id) {
            $pesan = \App\Models\Contact::findOrFail($id);
            if ($pesan->status === 'unread') $pesan->update(['status' => 'read']);
            return view('dashboard.staff.pesan.show', compact('pesan'));
        })->name('pesan.show');
        Route::post('/pesan/{id}/balas', function (\Illuminate\Http\Request $r, $id) {
            $pesan = \App\Models\Contact::findOrFail($id);
            $r->validate(['reply' => 'required|string']);
            $pesan->update(['reply' => $r->reply, 'status' => 'replied']);
            return redirect()->route('staff.pesan.index')->with('success', 'Balasan berhasil disimpan');
        })->name('pesan.reply');
    });

    // ===================== PASIEN ROUTES =====================
    Route::middleware(['role:pasien', 'ensure.patient'])->prefix('pasien')->name('pasien.')->group(function () {
        Route::get('/', function () {
            $patient = auth()->user()->patient;
            if (!$patient) return redirect()->route('home')->with('error', 'Data pasien tidak ditemukan');
            $appointments = \App\Models\Appointment::where('patient_id', $patient->id)
                ->with(['doctor.user'])->latest()->get();
            return view('dashboard.pasien.index', compact('patient', 'appointments'));
        })->name('index');

        Route::get('/booking', function () {
            $doctors = \App\Models\Doctor::active()->with('user', 'schedules')->get();
            return view('dashboard.pasien.booking', compact('doctors'));
        })->name('booking');
        Route::post('/booking', function (\Illuminate\Http\Request $request) {
            $validated = $request->validate([
                'doctor_id' => 'required|exists:doctors,id',
                'schedule_date' => 'required|date|after_or_equal:today',
                'start_time' => 'required',
                'complaint' => 'required|string|min:10|max:500',
            ]);
            $patient = auth()->user()->patient;
            \App\Models\Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $validated['doctor_id'],
                'schedule_date' => $validated['schedule_date'],
                'start_time' => $validated['start_time'],
                'complaint' => $validated['complaint'],
                'status' => 'pending',
            ]);
            \App\Models\Notification::create([
                'user_id' => auth()->id(),
                'title' => 'Appointment Berhasil Dibuat',
                'message' => 'Appointment Anda berhasil dibuat dan menunggu konfirmasi',
                'type' => 'info',
            ]);
            return redirect()->route('pasien.index')->with('success', 'Appointment berhasil dibuat');
        })->name('booking.store');

        // Update profil pasien
        Route::get('/profil', function () {
            $patient = auth()->user()->patient;
            return view('dashboard.pasien.profil', compact('patient'));
        })->name('profil');
        Route::put('/profil', function (\Illuminate\Http\Request $r) {
            $user = auth()->user();
            $patient = $user->patient;
            $r->validate([
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string',
                'nik' => 'nullable|string',
                'birth_date' => 'nullable|date',
                'gender' => 'nullable|in:L,P',
                'blood_type' => 'nullable|string',
                'address' => 'nullable|string',
                'emergency_contact' => 'nullable|string',
            ]);
            $user->update(['name' => $r->name, 'phone' => $r->phone]);
            $patient->update($r->except(['_token', '_method', 'name', 'phone']));
            return redirect()->route('pasien.profil')->with('success', 'Profil berhasil diupdate');
        })->name('profil.update');
    });
});

require __DIR__.'/auth.php';
