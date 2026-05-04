# Class Diagram - Sistem Informasi Rumah Sakit

```mermaid
classDiagram
    class User {
        +int id
        +string name
        +string email
        +string password
        +string phone
        +string photo
        +boolean is_active
        +datetime email_verified_at
        +datetime created_at
        +datetime updated_at
        +datetime deleted_at
        +hasOne() doctor
        +hasOne() patient
        +hasMany() auditLogs
        +hasMany() notifications
        +hasMany() news
        +scopeActive() query
        +getPhotoUrlAttribute() string
    }

    class Doctor {
        +int id
        +int user_id
        +string nik
        +string specialization
        +string education
        +int experience
        +string str_number
        +string photo
        +text bio
        +boolean is_active
        +datetime created_at
        +datetime updated_at
        +datetime deleted_at
        +belongsTo() user
        +belongsTo() department
        +hasMany() schedules
        +hasMany() appointments
        +scopeActive() query
        +getPhotoUrlAttribute() string
    }

    class DoctorSchedule {
        +int id
        +int doctor_id
        +string day_of_week
        +time start_time
        +time end_time
        +int max_quota
        +boolean is_active
        +datetime created_at
        +datetime updated_at
        +belongsTo() doctor
        +scopeActive() query
    }

    class Department {
        +int id
        +string name
        +string slug
        +text description
        +string icon
        +int head_doctor_id
        +boolean is_active
        +datetime created_at
        +datetime updated_at
        +datetime deleted_at
        +belongsTo() headDoctor
        +hasMany() doctors
        +hasMany() services
        +scopeActive() query
    }

    class Service {
        +int id
        +int department_id
        +string name
        +string slug
        +text description
        +string image
        +string price_range
        +boolean is_active
        +datetime created_at
        +datetime updated_at
        +datetime deleted_at
        +belongsTo() department
        +scopeActive() query
        +getImageUrlAttribute() string
    }

    class Patient {
        +int id
        +int user_id
        +string nik
        +date birth_date
        +enum gender
        +string blood_type
        +text address
        +string emergency_contact
        +datetime created_at
        +datetime updated_at
        +datetime deleted_at
        +belongsTo() user
        +hasMany() appointments
        +getAgeAttribute() int
    }

    class Appointment {
        +int id
        +int patient_id
        +int doctor_id
        +date schedule_date
        +time start_time
        +text complaint
        +enum status
        +text notes
        +datetime created_at
        +datetime updated_at
        +datetime deleted_at
        +belongsTo() patient
        +belongsTo() doctor
        +scopePending() query
        +scopeConfirmed() query
        +scopeToday() query
    }

    class News {
        +int id
        +int author_id
        +int category_id
        +string title
        +string slug
        +text excerpt
        +longtext body
        +string image
        +enum status
        +datetime published_at
        +datetime created_at
        +datetime updated_at
        +datetime deleted_at
        +belongsTo() author
        +belongsTo() category
        +scopePublished() query
        +getImageUrlAttribute() string
    }

    class NewsCategory {
        +int id
        +string name
        +string slug
        +datetime created_at
        +datetime updated_at
        +hasMany() news
    }

    class Facility {
        +int id
        +string name
        +text description
        +string image
        +string category
        +boolean is_active
        +datetime created_at
        +datetime updated_at
        +scopeActive() query
        +getImageUrlAttribute() string
    }

    class Gallery {
        +int id
        +string title
        +string image
        +string category
        +text description
        +datetime created_at
        +datetime updated_at
        +getImageUrlAttribute() string
    }

    class Contact {
        +int id
        +string name
        +string email
        +string phone
        +string subject
        +text message
        +enum status
        +text reply
        +datetime created_at
        +datetime updated_at
        +scopeUnread() query
        +scopeRead() query
        +scopeReplied() query
    }

    class AuditLog {
        +int id
        +int user_id
        +string action
        +string model_type
        +int model_id
        +json old_values
        +json new_values
        +string ip_address
        +datetime created_at
        +datetime updated_at
        +belongsTo() user
    }

    class Notification {
        +int id
        +int user_id
        +string title
        +text message
        +string type
        +boolean is_read
        +datetime created_at
        +datetime updated_at
        +belongsTo() user
        +scopeUnread() query
    }

    class Setting {
        +int id
        +string key
        +text value
        +datetime created_at
        +datetime updated_at
        +static get() mixed
        +static set() bool
    }

    %% Relationships
    User "1" --o "0..1" Doctor : has
    User "1" --o "0..1" Patient : has
    User "1" --o "*" AuditLog : creates
    User "1" --o "*" Notification : receives
    User "1" --o "*" News : writes
    
    Doctor "1" --o "*" DoctorSchedule : has
    Doctor "1" --o "*" Appointment : handles
    Doctor "*" --o "1" Department : belongs to
    
    Department "1" --o "*" Service : provides
    
    Patient "1" --o "*" Appointment : makes
    
    Appointment "*" --o "1" Doctor : with
    Appointment "*" --o "1" Patient : for
    
    News "*" --o "1" NewsCategory : categorized by
    News "*" --o "1" User : authored by
```

## Deskripsi Class

### User
Class utama untuk autentikasi dan otorisasi. Menggunakan Spatie Permission untuk role-based access control. Memiliki relasi dengan Doctor, Patient, AuditLog, Notification, dan News.

### Doctor
Menyimpan informasi dokter termasuk spesialisasi, pendidikan, dan pengalaman. Setiap dokter terhubung dengan satu User dan memiliki banyak jadwal praktek serta appointment.

### DoctorSchedule
Mengelola jadwal praktek dokter per hari dengan quota maksimal pasien. Setiap schedule terkait dengan satu dokter.

### Department
Departemen/unit layanan di rumah sakit. Memiliki banyak dokter dan layanan. Dapat memiliki kepala departemen (head_doctor).

### Service
Layanan medis yang disediakan oleh departemen. Menyimpan informasi layanan termasuk deskripsi dan range harga.

### Patient
Data pasien yang terhubung dengan User. Menyimpan informasi medis dasar seperti NIK, tanggal lahir, golongan darah, dan kontak darurat.

### Appointment
Janji temu antara pasien dan dokter. Memiliki status (pending, confirmed, cancelled, done) dan menyimpan keluhan serta catatan.

### News
Berita dan artikel kesehatan. Ditulis oleh user (admin/dokter) dan dikategorikan. Memiliki status draft atau published.

### NewsCategory
Kategori untuk mengelompokkan berita (Kesehatan, Pengumuman, Kegiatan, Tips Kesehatan).

### Facility
Fasilitas yang tersedia di rumah sakit (ICU, Ruang Operasi, Farmasi, dll).

### Gallery
Galeri foto rumah sakit yang dapat dikategorikan.

### Contact
Pesan dari pengunjung melalui form kontak. Memiliki status (unread, read, replied) dan dapat dibalas oleh staff/admin.

### AuditLog
Log aktivitas user untuk audit trail. Menyimpan aksi, model yang diubah, nilai lama dan baru, serta IP address.

### Notification
Notifikasi untuk user. Dapat berupa notifikasi appointment, pengumuman, atau informasi lainnya.

### Setting
Pengaturan sistem dalam format key-value. Digunakan untuk konfigurasi global seperti nama RS, logo, kontak, dll.

## Relasi Antar Class

- **One-to-One**: User ↔ Doctor, User ↔ Patient
- **One-to-Many**: 
  - User → AuditLog, Notification, News
  - Doctor → DoctorSchedule, Appointment
  - Department → Doctor, Service
  - Patient → Appointment
  - NewsCategory → News
- **Many-to-One**:
  - Doctor → Department
  - Appointment → Doctor, Patient
  - News → User (author), NewsCategory
