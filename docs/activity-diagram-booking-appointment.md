# Activity Diagram - Booking Appointment

```mermaid
flowchart TD
    Start([Start]) --> A1[Pasien login ke sistem]
    
    A1 --> A2[Buka halaman booking appointment]
    
    A2 --> A3[Pilih departemen]
    
    A3 --> A4[Sistem load daftar dokter<br/>berdasarkan departemen]
    
    A4 --> A5[Pilih dokter]
    
    A5 --> A6[Sistem load jadwal dokter]
    
    A6 --> A7{Jadwal<br/>Tersedia?}
    
    A7 -->|Tidak| A8[Tampilkan pesan<br/>tidak ada jadwal]
    A8 --> A5
    
    A7 -->|Ya| A9[Tampilkan kalender jadwal]
    
    A9 --> A10[Pasien pilih tanggal]
    
    A10 --> A11[Sistem cek ketersediaan slot]
    
    A11 --> A12{Slot<br/>Tersedia?}
    
    A12 -->|Penuh| A13[Tampilkan pesan slot penuh]
    A13 --> A10
    
    A12 -->|Tersedia| A14[Pilih waktu appointment]
    
    A14 --> A15[Isi keluhan/complaint]
    
    A15 --> A16{Validasi<br/>Form}
    
    A16 -->|Invalid| A17[Tampilkan error]
    A17 --> A15
    
    A16 -->|Valid| A18[Simpan appointment ke database<br/>dengan status 'pending']
    
    A18 --> A19[Buat notifikasi untuk pasien]
    
    A19 --> A20[Buat notifikasi untuk dokter]
    
    A20 --> A21[Buat notifikasi untuk staff]
    
    A21 --> A22[Kirim email konfirmasi ke pasien]
    
    A22 --> A23[Log aktivitas booking]
    
    A23 --> A24[Tampilkan pesan sukses<br/>& nomor booking]
    
    A24 --> A25[Redirect ke halaman<br/>riwayat appointment]
    
    A25 --> End([End])
    
    style Start fill:#90EE90
    style End fill:#90EE90
    style A7 fill:#FFE4B5
    style A12 fill:#FFE4B5
    style A16 fill:#FFE4B5
```

## Swimlane Diagram

```mermaid
sequenceDiagram
    participant P as Pasien
    participant S as Sistem
    participant DB as Database
    participant N as Notification Service

    P->>S: Login & buka booking
    P->>S: Pilih departemen
    S->>DB: Query dokter by departemen
    DB-->>S: List dokter
    S->>P: Tampilkan daftar dokter

    P->>S: Pilih dokter
    S->>DB: Query jadwal dokter
    DB-->>S: List jadwal
    
    alt Tidak ada jadwal
        S->>P: Pesan tidak ada jadwal
    else Ada jadwal
        S->>P: Tampilkan kalender
        P->>S: Pilih tanggal
        S->>DB: Cek ketersediaan slot
        DB-->>S: Jumlah appointment hari itu
        
        alt Slot penuh
            S->>P: Pesan slot penuh
        else Slot tersedia
            S->>P: Tampilkan form
            P->>S: Isi keluhan & submit
            S->>S: Validasi input
            
            alt Invalid
                S->>P: Tampilkan error
            else Valid
                S->>DB: Simpan appointment
                DB-->>S: Appointment created
                
                par Kirim Notifikasi
                    S->>N: Notif ke pasien
                    S->>N: Notif ke dokter
                    S->>N: Notif ke staff
                    N-->>P: Email konfirmasi
                end
                
                S->>DB: Log aktivitas
                S->>P: Pesan sukses & nomor booking
                S->>P: Redirect ke riwayat
            end
        end
    end
```

## Deskripsi Proses

### 1. Persiapan Booking
- Pasien harus login terlebih dahulu
- Akses halaman booking appointment
- Sistem menampilkan form multi-step

### 2. Pemilihan Departemen
- Pasien memilih departemen (IGD, Poli Umum, Poli Gigi, dll)
- Sistem query database untuk mendapatkan dokter yang terkait dengan departemen tersebut
- Tampilkan daftar dokter dengan foto, nama, spesialisasi

### 3. Pemilihan Dokter
- Pasien memilih dokter yang diinginkan
- Sistem query jadwal praktek dokter dari tabel doctor_schedules
- Filter jadwal yang aktif (is_active = true)

### 4. Cek Ketersediaan Jadwal
- Jika dokter tidak memiliki jadwal aktif:
  - Tampilkan pesan "Dokter belum memiliki jadwal praktek"
  - Kembali ke pemilihan dokter
- Jika ada jadwal:
  - Tampilkan kalender dengan hari-hari praktek dokter
  - Highlight tanggal yang tersedia

### 5. Pemilihan Tanggal dan Waktu
- Pasien memilih tanggal dari kalender
- Sistem cek jumlah appointment yang sudah ada pada tanggal tersebut
- Bandingkan dengan max_quota dari doctor_schedules
- Jika slot penuh (appointment >= max_quota):
  - Tampilkan pesan "Slot penuh, pilih tanggal lain"
  - Kembali ke pemilihan tanggal
- Jika slot tersedia:
  - Tampilkan waktu praktek (start_time - end_time)
  - Lanjut ke form keluhan

### 6. Pengisian Form
- Pasien mengisi keluhan/complaint (textarea)
- Validasi:
  - Complaint tidak boleh kosong
  - Minimal 10 karakter
  - Maksimal 500 karakter

### 7. Penyimpanan Data
- Simpan ke tabel appointments dengan data:
  - patient_id (dari user yang login)
  - doctor_id (dokter yang dipilih)
  - schedule_date (tanggal yang dipilih)
  - start_time (dari jadwal dokter)
  - complaint (keluhan pasien)
  - status = 'pending'
- Generate nomor booking unik

### 8. Notifikasi
- Buat notifikasi untuk pasien: "Appointment Anda berhasil dibuat"
- Buat notifikasi untuk dokter: "Appointment baru dari [nama pasien]"
- Buat notifikasi untuk staff: "Appointment baru perlu konfirmasi"
- Kirim email konfirmasi ke pasien dengan detail appointment

### 9. Logging dan Redirect
- Log aktivitas ke audit_logs
- Tampilkan pesan sukses dengan nomor booking
- Redirect ke halaman riwayat appointment

### Decision Points
- **Jadwal Tersedia**: Cek apakah dokter memiliki jadwal aktif
- **Slot Tersedia**: Cek apakah quota belum penuh
- **Validasi Form**: Cek kelengkapan dan format input

### Business Rules
- Pasien hanya bisa booking untuk tanggal hari ini atau ke depan
- Satu pasien maksimal 3 appointment pending
- Tidak bisa booking di hari yang sama dengan appointment lain yang sudah confirmed
- Appointment otomatis cancelled jika tidak dikonfirmasi dalam 24 jam
