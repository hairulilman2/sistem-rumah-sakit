# Activity Diagram - Registrasi dan Login

```mermaid
flowchart TD
    Start([Start]) --> A1[Pengunjung membuka halaman registrasi]
    
    A1 --> A2[Mengisi form registrasi:<br/>Nama, Email, Password, Phone, NIK, dll]
    
    A2 --> A3{Validasi<br/>Data}
    
    A3 -->|Invalid| A4[Tampilkan pesan error]
    A4 --> A2
    
    A3 -->|Valid| A5[Simpan data user ke database]
    
    A5 --> A6[Assign role 'pasien']
    
    A6 --> A7[Buat record patient]
    
    A7 --> A8[Kirim email verifikasi]
    
    A8 --> A9[Tampilkan pesan sukses]
    
    A9 --> A10[Pengunjung cek email]
    
    A10 --> A11[Klik link verifikasi]
    
    A11 --> A12[Update email_verified_at]
    
    A12 --> A13[Redirect ke halaman login]
    
    A13 --> B1[User input email & password]
    
    B1 --> B2{Validasi<br/>Kredensial}
    
    B2 -->|Invalid| B3[Tampilkan pesan error]
    B3 --> B1
    
    B2 -->|Valid| B4{Email<br/>Verified?}
    
    B4 -->|No| B5[Tampilkan pesan verifikasi email]
    B5 --> B1
    
    B4 -->|Yes| B6{User<br/>Active?}
    
    B6 -->|No| B7[Tampilkan pesan akun nonaktif]
    B7 --> End1([End])
    
    B6 -->|Yes| B8[Buat session]
    
    B8 --> B9[Log aktivitas login]
    
    B9 --> B10{Cek Role<br/>User}
    
    B10 -->|Super Admin| B11[Redirect ke Dashboard Super Admin]
    B10 -->|Admin| B12[Redirect ke Dashboard Admin]
    B10 -->|Dokter| B13[Redirect ke Dashboard Dokter]
    B10 -->|Staff| B14[Redirect ke Dashboard Staff]
    B10 -->|Pasien| B15[Redirect ke Dashboard Pasien]
    
    B11 --> End2([End])
    B12 --> End2
    B13 --> End2
    B14 --> End2
    B15 --> End2
    
    style Start fill:#90EE90
    style End1 fill:#FFB6C1
    style End2 fill:#90EE90
    style A3 fill:#FFE4B5
    style B2 fill:#FFE4B5
    style B4 fill:#FFE4B5
    style B6 fill:#FFE4B5
    style B10 fill:#FFE4B5
```

## Swimlane Diagram

```mermaid
sequenceDiagram
    participant P as Pengunjung
    participant S as Sistem
    participant DB as Database
    participant E as Email Server

    Note over P,E: Proses Registrasi
    P->>S: Buka halaman registrasi
    P->>S: Isi form registrasi
    S->>S: Validasi input
    alt Data Invalid
        S->>P: Tampilkan error
    else Data Valid
        S->>DB: Simpan user baru
        DB-->>S: User created
        S->>DB: Assign role 'pasien'
        S->>DB: Buat record patient
        S->>E: Kirim email verifikasi
        E-->>P: Email verifikasi
        S->>P: Tampilkan pesan sukses
    end

    Note over P,E: Verifikasi Email
    P->>P: Cek email
    P->>S: Klik link verifikasi
    S->>DB: Update email_verified_at
    DB-->>S: Updated
    S->>P: Redirect ke login

    Note over P,E: Proses Login
    P->>S: Input email & password
    S->>DB: Cek kredensial
    DB-->>S: User data
    alt Kredensial Invalid
        S->>P: Tampilkan error
    else Email Not Verified
        S->>P: Pesan verifikasi email
    else User Not Active
        S->>P: Pesan akun nonaktif
    else Login Success
        S->>S: Buat session
        S->>DB: Log aktivitas
        S->>S: Cek role user
        S->>P: Redirect ke dashboard sesuai role
    end
```

## Deskripsi Proses

### 1. Registrasi
- Pengunjung mengakses halaman registrasi
- Mengisi form dengan data: nama, email, password, phone, NIK, tanggal lahir, gender, alamat
- Sistem melakukan validasi:
  - Email harus unik dan format valid
  - Password minimal 8 karakter
  - NIK harus 16 digit dan unik
  - Semua field required harus diisi
- Jika valid, sistem:
  - Menyimpan data user ke tabel users
  - Assign role 'pasien' menggunakan Spatie Permission
  - Membuat record di tabel patients dengan user_id
  - Mengirim email verifikasi
- Tampilkan pesan sukses dan instruksi cek email

### 2. Verifikasi Email
- User menerima email dengan link verifikasi
- Klik link akan mengupdate kolom email_verified_at
- Redirect ke halaman login

### 3. Login
- User input email dan password
- Sistem validasi kredensial dengan database
- Cek apakah email sudah diverifikasi
- Cek apakah user aktif (is_active = true)
- Jika semua valid:
  - Buat session login
  - Log aktivitas ke audit_logs
  - Redirect ke dashboard sesuai role:
    - Super Admin → /dashboard/super-admin
    - Admin → /dashboard/admin
    - Dokter → /dashboard/dokter
    - Staff → /dashboard/staff
    - Pasien → /dashboard/pasien

### Decision Points
- **Validasi Data**: Cek kelengkapan dan format data registrasi
- **Validasi Kredensial**: Cek kecocokan email dan password
- **Email Verified**: Cek apakah email sudah diverifikasi
- **User Active**: Cek status aktif user
- **Cek Role**: Tentukan dashboard tujuan berdasarkan role

### Error Handling
- Data registrasi invalid → Tampilkan pesan error spesifik per field
- Kredensial salah → "Email atau password salah"
- Email belum diverifikasi → "Silakan verifikasi email terlebih dahulu"
- Akun nonaktif → "Akun Anda telah dinonaktifkan, hubungi admin"
