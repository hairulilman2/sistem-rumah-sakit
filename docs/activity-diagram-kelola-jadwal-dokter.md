# Activity Diagram - Kelola Jadwal Dokter

```mermaid
flowchart TD
    Start([Start]) --> A1{User<br/>Role?}
    
    A1 -->|Dokter| A2[Dokter login]
    A1 -->|Admin| A3[Admin login]
    
    A2 --> A4[Buka halaman jadwal praktek sendiri]
    A3 --> A5[Pilih dokter dari daftar]
    A5 --> A4
    
    A4 --> A6[Lihat jadwal praktek saat ini]
    
    A6 --> A7{Aksi<br/>yang Dipilih?}
    
    A7 -->|Tambah| B1[Klik tombol tambah jadwal]
    
    B1 --> B2[Isi form jadwal baru:<br/>- Hari<br/>- Jam mulai<br/>- Jam selesai<br/>- Quota maksimal]
    
    B2 --> B3{Validasi<br/>Input}
    
    B3 -->|Invalid| B4[Tampilkan error:<br/>- Jam tidak valid<br/>- Quota harus > 0]
    B4 --> B2
    
    B3 -->|Valid| B5[Cek konflik jadwal]
    
    B5 --> B6{Ada<br/>Konflik?}
    
    B6 -->|Ya| B7[Tampilkan pesan:<br/>Jadwal bentrok dengan<br/>jadwal existing]
    B7 --> B2
    
    B6 -->|Tidak| B8[Simpan jadwal baru<br/>ke database]
    
    B8 --> B9[Update kalender publik]
    
    B9 --> B10[Log aktivitas]
    
    B10 --> B11[Tampilkan pesan sukses]
    
    B11 --> A6
    
    A7 -->|Edit| C1[Pilih jadwal yang akan diedit]
    
    C1 --> C2[Tampilkan form edit<br/>dengan data existing]
    
    C2 --> C3[Ubah data jadwal]
    
    C3 --> C4{Validasi<br/>Input}
    
    C4 -->|Invalid| C5[Tampilkan error]
    C5 --> C3
    
    C4 -->|Valid| C6[Cek appointment terkait]
    
    C6 --> C7{Ada<br/>Appointment<br/>Confirmed?}
    
    C7 -->|Ya| C8[Tampilkan warning:<br/>Ada X appointment confirmed<br/>pada jadwal ini]
    
    C8 --> C9{Lanjutkan<br/>Edit?}
    
    C9 -->|Tidak| A6
    
    C9 -->|Ya| C10[Cek konflik dengan<br/>jadwal lain]
    
    C7 -->|Tidak| C10
    
    C10 --> C11{Ada<br/>Konflik?}
    
    C11 -->|Ya| C12[Tampilkan pesan konflik]
    C12 --> C3
    
    C11 -->|Tidak| C13[Update jadwal di database]
    
    C13 --> C14[Notifikasi pasien<br/>jika ada perubahan signifikan]
    
    C14 --> C15[Update kalender publik]
    
    C15 --> C16[Log aktivitas]
    
    C16 --> C17[Tampilkan pesan sukses]
    
    C17 --> A6
    
    A7 -->|Hapus| D1[Pilih jadwal yang akan dihapus]
    
    D1 --> D2[Cek appointment terkait]
    
    D2 --> D3{Ada<br/>Appointment<br/>Confirmed?}
    
    D3 -->|Ya| D4[Tampilkan error:<br/>Tidak bisa hapus jadwal<br/>dengan appointment aktif]
    D4 --> A6
    
    D3 -->|Tidak| D5[Tampilkan konfirmasi hapus]
    
    D5 --> D6{Konfirmasi<br/>Hapus?}
    
    D6 -->|Tidak| A6
    
    D6 -->|Ya| D7[Soft delete jadwal<br/>atau set is_active = false]
    
    D7 --> D8[Update kalender publik]
    
    D8 --> D9[Log aktivitas]
    
    D9 --> D10[Tampilkan pesan sukses]
    
    D10 --> A6
    
    A7 -->|Keluar| End([End])
    
    style Start fill:#90EE90
    style End fill:#90EE90
    style A1 fill:#FFE4B5
    style A7 fill:#FFE4B5
    style B3 fill:#FFE4B5
    style B6 fill:#FFE4B5
    style C4 fill:#FFE4B5
    style C7 fill:#FFE4B5
    style C9 fill:#FFE4B5
    style C11 fill:#FFE4B5
    style D3 fill:#FFE4B5
    style D6 fill:#FFE4B5
```

## Swimlane Diagram

```mermaid
sequenceDiagram
    participant U as Dokter/Admin
    participant S as Sistem
    participant DB as Database
    participant P as Pasien (jika ada)

    U->>S: Login & buka jadwal
    
    alt User = Admin
        U->>S: Pilih dokter
    end
    
    S->>DB: Query jadwal dokter
    DB-->>S: List jadwal
    S->>U: Tampilkan jadwal

    alt Tambah Jadwal
        U->>S: Klik tambah
        U->>S: Isi form jadwal
        S->>S: Validasi input
        
        alt Invalid
            S->>U: Tampilkan error
        else Valid
            S->>DB: Cek konflik jadwal
            DB-->>S: Hasil cek
            
            alt Ada konflik
                S->>U: Pesan jadwal bentrok
            else Tidak konflik
                S->>DB: Simpan jadwal baru
                DB-->>S: Jadwal created
                S->>DB: Update kalender publik
                S->>DB: Log aktivitas
                S->>U: Pesan sukses
            end
        end
        
    else Edit Jadwal
        U->>S: Pilih jadwal & edit
        S->>DB: Get data jadwal
        DB-->>S: Data jadwal
        S->>U: Tampilkan form edit
        U->>S: Ubah data & submit
        S->>S: Validasi input
        
        alt Invalid
            S->>U: Tampilkan error
        else Valid
            S->>DB: Cek appointment terkait
            DB-->>S: Jumlah appointment
            
            alt Ada appointment
                S->>U: Warning ada appointment
                U->>S: Konfirmasi lanjut
            end
            
            S->>DB: Cek konflik jadwal
            DB-->>S: Hasil cek
            
            alt Ada konflik
                S->>U: Pesan konflik
            else Tidak konflik
                S->>DB: Update jadwal
                DB-->>S: Updated
                
                opt Perubahan signifikan
                    S->>P: Notifikasi perubahan
                end
                
                S->>DB: Update kalender publik
                S->>DB: Log aktivitas
                S->>U: Pesan sukses
            end
        end
        
    else Hapus Jadwal
        U->>S: Pilih jadwal & hapus
        S->>DB: Cek appointment terkait
        DB-->>S: Jumlah appointment
        
        alt Ada appointment confirmed
            S->>U: Error tidak bisa hapus
        else Tidak ada appointment
            S->>U: Konfirmasi hapus
            U->>S: Konfirmasi ya
            S->>DB: Soft delete jadwal
            DB-->>S: Deleted
            S->>DB: Update kalender publik
            S->>DB: Log aktivitas
            S->>U: Pesan sukses
        end
    end
```

## Deskripsi Proses

### 1. Akses Halaman Jadwal

#### Dokter:
- Login dengan role 'dokter'
- Langsung akses jadwal praktek sendiri
- Hanya bisa mengelola jadwal milik sendiri

#### Admin:
- Login dengan role 'admin'
- Akses halaman manajemen jadwal dokter
- Pilih dokter dari dropdown/list
- Bisa mengelola jadwal semua dokter

### 2. Tampilan Jadwal Saat Ini
- Sistem query tabel doctor_schedules berdasarkan doctor_id
- Tampilkan dalam format tabel atau kalender:
  - Hari praktek
  - Jam mulai - Jam selesai
  - Quota maksimal
  - Status (Aktif/Nonaktif)
  - Jumlah appointment yang sudah terjadwal
  - Aksi (Edit, Hapus, Toggle Status)

### 3. Tambah Jadwal Baru

#### Form Input:
- **Hari**: Dropdown (Senin - Minggu)
- **Jam Mulai**: Time picker (format 24 jam)
- **Jam Selesai**: Time picker (format 24 jam)
- **Quota Maksimal**: Number input (default 20)
- **Status**: Checkbox aktif (default checked)

#### Validasi:
- Jam selesai harus lebih besar dari jam mulai
- Minimal durasi praktek 1 jam
- Maksimal durasi praktek 12 jam
- Quota harus antara 1-100
- Semua field required

#### Cek Konflik:
- Query jadwal existing untuk dokter yang sama
- Cek apakah ada jadwal di hari yang sama dengan rentang waktu yang overlap
- Contoh konflik:
  - Existing: Senin 08:00-12:00
  - New: Senin 10:00-14:00 → KONFLIK
  - New: Senin 13:00-17:00 → OK

#### Jika Valid:
- Simpan ke tabel doctor_schedules
- Update cache kalender publik
- Log aktivitas: "Menambah jadwal praktek [hari] [jam]"

### 4. Edit Jadwal Existing

#### Proses:
- Klik tombol edit pada jadwal
- Form terisi dengan data existing
- User ubah data yang diperlukan
- Submit form

#### Validasi Tambahan:
- Cek apakah ada appointment confirmed pada jadwal ini
- Query: `SELECT COUNT(*) FROM appointments WHERE doctor_id = ? AND day_of_week = ? AND status = 'confirmed'`
- Jika ada appointment:
  - Tampilkan warning: "Ada X appointment confirmed pada jadwal ini"
  - Berikan opsi:
    - Lanjutkan edit (appointment tetap valid)
    - Batal edit

#### Perubahan Signifikan:
Jika ada perubahan pada jam praktek > 1 jam:
- Kirim notifikasi ke semua pasien dengan appointment confirmed
- Notifikasi: "Jadwal praktek Dr. [nama] berubah dari [jam lama] menjadi [jam baru]"
- Berikan opsi reschedule jika pasien tidak bisa

#### Jika Valid:
- Update record di doctor_schedules
- Update kalender publik
- Kirim notifikasi jika perlu
- Log aktivitas: "Mengubah jadwal praktek [hari] dari [jam lama] ke [jam baru]"

### 5. Hapus Jadwal

#### Validasi:
- Cek appointment confirmed pada jadwal ini
- Jika ada appointment confirmed:
  - Tampilkan error: "Tidak dapat menghapus jadwal dengan appointment aktif"
  - Sarankan untuk nonaktifkan jadwal saja
  - Tidak bisa lanjut hapus

#### Jika Tidak Ada Appointment:
- Tampilkan modal konfirmasi:
  - "Yakin ingin menghapus jadwal [hari] [jam]?"
  - Tombol: Batal | Hapus
- Jika konfirmasi Ya:
  - Soft delete (set deleted_at) atau
  - Set is_active = false
  - Update kalender publik
  - Log aktivitas: "Menghapus jadwal praktek [hari] [jam]"

### 6. Toggle Status Aktif/Nonaktif
- Fitur tambahan untuk menonaktifkan sementara tanpa hapus
- Jadwal nonaktif tidak muncul di kalender publik
- Tidak bisa booking appointment pada jadwal nonaktif
- Appointment existing tetap valid

### Decision Points
- **User Role**: Tentukan akses (dokter hanya jadwal sendiri, admin semua)
- **Validasi Input**: Cek kelengkapan dan format data
- **Ada Konflik**: Cek overlap dengan jadwal existing
- **Ada Appointment Confirmed**: Validasi sebelum edit/hapus
- **Lanjutkan Edit**: Konfirmasi jika ada appointment
- **Konfirmasi Hapus**: Konfirmasi sebelum delete

### Business Rules
- Dokter hanya bisa kelola jadwal sendiri
- Admin bisa kelola jadwal semua dokter
- Tidak boleh ada jadwal overlap untuk dokter yang sama
- Tidak bisa hapus jadwal dengan appointment confirmed
- Perubahan signifikan harus notifikasi pasien
- Semua perubahan jadwal harus tercatat di audit log
- Jadwal nonaktif tidak muncul di kalender publik
- Minimal durasi praktek 1 jam, maksimal 12 jam
- Quota minimal 1, maksimal 100 pasien per sesi
