<?php
// lang.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['lang'])) {
    $pilihan = $_GET['lang'];
    if (in_array($pilihan, ['id', 'en'])) {
        $_SESSION['lang'] = $pilihan;
    }
}

$current_lang = $_SESSION['lang'] ?? 'id';

$translations = [
    'id' => [
        'app_title'   => 'Sistem Katalog Buku',
        'login_title' => 'Silakan Masuk',
        'login'       => 'Masuk',
        'logout'      => 'Keluar',
        'kode_buku'   => 'Kode Buku',
        'judul'       => 'Judul Buku',
        'penulis'     => 'Penulis',
        'kategori'    => 'Kategori',
        'tahun'       => 'Tahun Terbit',
        'aksi'        => 'Aksi',
        'tambah'      => 'Tambah Buku',
        'ubah'        => 'Ubah',
        'hapus'       => 'Hapus',
        'simpan'      => 'Simpan Data',
        'kembali'     => 'Kembali',
        'konfirmasi'  => 'Yakin ingin menghapus buku ini?',
        'kosong'      => 'Belum ada data buku.'
    ],
    'en' => [
        'app_title'   => 'Book Catalog System',
        'login_title' => 'Please Sign In',
        'login'       => 'Login',
        'logout'      => 'Logout',
        'kode_buku'   => 'Book Code',
        'judul'       => 'Title',
        'penulis'     => 'Author',
        'kategori'    => 'Category',
        'tahun'       => 'Year',
        'aksi'        => 'Action',
        'tambah'      => 'Add Book',
        'ubah'        => 'Edit',
        'hapus'       => 'Delete',
        'simpan'      => 'Save Data',
        'kembali'     => 'Back',
        'konfirmasi'  => 'Are you sure you want to delete this book?',
        'kosong'      => 'No book data available.'
    ]
];

function __($key) {
    global $translations, $current_lang;
    return $translations[$current_lang][$key] ?? $key;
}
?>