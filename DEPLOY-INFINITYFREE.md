# Panduan Deploy Sakuci Framework ke InfinityFree

## 📋 Checklist Pre-Deploy

- [ ] PHP 8.1+ support (di InfinityFree biasanya default)
- [ ] Database MySQL sudah dibuat di InfinityFree
- [ ] Username & password database sudah tercatat

---

## 🚀 Langkah Deploy (Paling Gampang)

### **Langkah 1: Siapkan folder di PC**

Buat folder di desktop: `sakuci-infinityfree`

### **Langkah 2: Copy file dari Sakuci**

Dalam folder `sakuci-infinityfree`, copy:

```
Dari public/          → Copy ke sakuci-infinityfree/
├── index.php         ✓
├── css/              ✓
├── vendor/           ✓
└── .htaccess         ✓

Dari root project     → Copy ke sakuci-infinityfree/
├── app/              ✓
├── config/           ✓
├── core/             ✓
├── database/         ✓
├── resources/        ✓
├── routes/           ✓
├── storage/          ✓
└── .env              ✓
```

### **Langkah 3: Edit `.env`**

Buka `.env` di folder `sakuci-infinityfree`, sesuaikan:

```ini
APP_NAME=Sakuci
APP_DEBUG=true
APP_URL=https://domain-anda.infinityfree.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nama_database_infinityfree
DB_USERNAME=username_infinityfree
DB_PASSWORD=password_infinityfree
```

**Isi dengan data dari InfinityFree** (cek di Control Panel → MySQL)

### **Langkah 4: Upload ke InfinityFree**

1. Login ke InfinityFree Control Panel
2. Buka **File Manager**
3. Masuk ke folder **public_html**
4. Upload semua isi folder `sakuci-infinityfree` ke sini
5. Tunggu upload selesai

### **Langkah 5: Buat Database**

1. Di Control Panel InfinityFree
2. Buka **MySQL Databases**
3. Buat database baru (catat nama, username, password)
4. Update `.env` dengan data ini

### **Langkah 6: Jalankan Migrasi**

Migrasi tidak bisa via CLI di InfinityFree. Akses via URL:
```
https://domain-anda.infinityfree.com/sakuci
```

Atau buat file PHP temp untuk jalankan:
```php
<?php
require 'core/bootstrap.php';
// Jalankan migrate manual atau import SQL
```

---

## ✅ Testing

Buka di browser:
```
https://domain-anda.infinityfree.com
```

Harus muncul halaman welcome Sakuci Framework

---

## 🐛 Troubleshoot

### Error: "Headers already sent"
→ Pastikan tidak ada file kosong atau BOM di `.env` dan `config/`

### Error: "Class not found"
→ Pastikan folder `core/` sudah upload

### Error: "Database connection failed"
→ Cek `.env` - data database harus benar

### Blank page
→ Set `APP_DEBUG=true` di `.env` untuk lihat error

---

## 💡 Tips

- InfinityFree auto-backup, tapi backup manual juga bagus
- Jangan hardcode password di code, gunakan `.env`
- Test dulu di localhost dengan `php sakuci serve`

---

**Berhasil? Bagus! 🎉**

Kalau ada error, simpan pesan error dan email ke support InfinityFree atau diskusikan di forum.
