# Congratulations Modal Component

Komponen FlyonUI yang dapat digunakan kembali untuk menampilkan modal ucapan selamat.

## Penggunaan Dasar

```blade
<x-flyonui.congratulations-modal />
```

## Penggunaan dengan Properti Kustom

```blade
<x-flyonui.congratulations-modal
    id="my-custom-modal"
    title="Well Done!"
    message="Your account has been successfully created!<br>Welcome to our platform."
    thankYouMessage="We're glad to have you with us!"
    buttonText="Get Started"
    buttonAction="/dashboard"
    triggerText="Create Account"
    class="bg-gray-100 h-screen py-12"
/>
```

## Properti yang Tersedia

| Properti | Default | Deskripsi |
|----------|---------|-----------|
| `id` | `modal-congratulations` | ID unik untuk modal |
| `title` | `Congratulations!` | Judul modal |
| `message` | `You have successfully subscribed 🎉<br>You will never miss our updates, latest news, and exclusive offers.` | Pesan utama dalam modal |
| `thankYouMessage` | `Thank you for joining our community!` | Pesan terima kasih |
| `buttonText` | `Subscribe` | Teks pada tombol aksi |
| `buttonAction` | `#` | Aksi ketika tombol diklik (URL untuk redirect) |
| `triggerText` | `Open modal` | Teks pada tombol trigger |
| `class` | `bg-base-200 h-dvh py-8 sm:py-16 lg:py-24` | Class CSS tambahan untuk wrapper |

## Contoh Implementasi

```blade
<!-- Dalam file Blade Anda -->
<div>
    <h1>Selamat Datang</h1>
    <p>Klik tombol di bawah untuk melihat modal.</p>
    
    <x-flyonui.congratulations-modal
        title="Selamat Datang!"
        message="Akun Anda telah berhasil dibuat!<br>Selamat bergabung di platform kami."
        buttonText="Mulai Sekarang"
        buttonAction="/dashboard"
        triggerText="Buat Akun"
    />
</div>
```

## Persyaratan

- FlyonUI CSS dan JavaScript harus sudah dimuat
- Iconify dan ikon Tabler harus sudah dikonfigurasi

## Konfigurasi Iconify (jika belum dikonfigurasi)

1. Install dependensi:
```bash
npm i -D @iconify/tailwind4 @iconify-json/tabler
```

2. Tambahkan ke file CSS Anda:
```css
@plugin "@iconify/tailwind4";
```