# SSL Certificate Generator Web App

Aplikasi web sederhana berbasis PHP untuk membuat Sertifikat SSL secara dinamis berdasarkan data identitas pengguna.

Project ini memungkinkan pengguna untuk:
- Membuat RSA Private Key
- Membuat CSR (Certificate Signing Request)
- Membuat Self-Signed SSL Certificate (.crt)
- Menampilkan Private Key dan Certificate langsung di browser

---

## Fitur

✅ Form Input Dinamis  
✅ Generate RSA Key Pair  
✅ Pembuatan CSR (Certificate Signing Request)  
✅ Generate Self-Signed SSL Certificate  
✅ Masa Berlaku Sertifikat 365 Hari  
✅ Menampilkan Private Key & CRT dalam Textarea  
✅ Dibuat menggunakan PHP Native + OpenSSL

---

## Teknologi yang Digunakan

- PHP
- HTML5
- CSS3
- OpenSSL Extension

---

## Input Form

Aplikasi menerima beberapa data identitas berikut:

| Field | Contoh |
|---|---|
| Country | ID |
| State / Provinsi | Kalimantan Barat |
| Locality / Kota | Pontianak |
| Organization Name | Universitas XYZ |
| Common Name | www.namamu.com |

---

## Cara Kerja Aplikasi

1. Pengguna mengisi form identitas SSL
2. PHP menangkap data menggunakan metode POST
3. Sistem membuat RSA Keypair baru
4. Data form dimasukkan ke array DN (Distinguished Name)
5. CSR dibuat menggunakan OpenSSL
6. CSR ditandatangani menjadi Self-Signed Certificate selama 365 hari
7. Private Key dan Certificate (.crt) ditampilkan ke layar

---

## Struktur Project

```bash
project-folder/
│
├── index.php
├── style.css
├── README.md
└── screenshots/
    └── output.png
```

---

## Cara Menjalankan Project

### 1. Clone Repository

```bash
git clone https://github.com/username/ssl-certificate-generator.git
```

### 2. Pindahkan Project ke Web Server

Contoh menggunakan XAMPP:

```bash
htdocs/ssl-certificate-generator
```

### 3. Aktifkan Extension OpenSSL

Buka file `php.ini`, lalu pastikan baris berikut aktif:

```ini
extension=openssl
```

### 4. Jalankan Project

Buka browser dan akses:

```bash
http://localhost/ssl-certificate-generator
```

---

## Contoh Potongan Kode

```php
$dn = array(
    "countryName" => $_POST['country'],
    "stateOrProvinceName" => $_POST['state'],
    "localityName" => $_POST['locality'],
    "organizationName" => $_POST['organization'],
    "commonName" => $_POST['commonname']
);

$privkey = openssl_pkey_new();

$csr = openssl_csr_new($dn, $privkey);

$sscert = openssl_csr_sign($csr, null, $privkey, 365);
```

---

## Contoh Output

Aplikasi akan menampilkan:

- RSA Private Key
- SSL Certificate (.CRT)

ke dalam elemen HTML `<textarea>`.

---

## Screenshot

Simpan screenshot hasil output ke folder:

```bash
/screenshots/output.png
```

Lalu tampilkan pada README menggunakan:

```md
![Screenshot Output](screenshots/output.png)
```

---

## Tujuan Pembelajaran

Project ini cocok digunakan untuk mempelajari:
- Fungsi OpenSSL pada PHP
- Dasar Sertifikat SSL
- Konsep Kriptografi
- Pengolahan Form Web
- Proses Pembuatan CSR & CRT

---

## Catatan

- Sertifikat yang dibuat adalah **Self-Signed Certificate**
- Cocok untuk pembelajaran dan pengembangan lokal
- Tidak disarankan digunakan untuk kebutuhan produksi

---

## Author

Dibuat oleh: Muhammad Naufal Welendra

GitHub: https://github.com/Nopal121

---

## License

Project ini bersifat open-source dan bebas digunakan untuk kebutuhan pembelajaran.
