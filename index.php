<?php

require "koneksi.php";
require "lang.php";

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM buku ORDER BY id DESC");
    $stmt->execute();
    $daftar_buku = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Gagal mengambil data: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="<?= $current_lang; ?>">
<head>
    <meta charset="UTF-8">
    <title><?= __('app_title'); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="nav-bar">
            <div class="nav-lang">
                <a href="?lang=id">Bahasa Indonesia</a>
                <span>|</span>
                <a href="?lang=en">English</a>
            </div>
            <div>
                <?= __('username'); ?>: <strong><?= htmlspecialchars($_SESSION["user"]); ?></strong>
                <span style="color: #cbd5e1; margin: 0 8px;">|</span>
                <a href="logout.php" style="color: #f43f5e;"><?= __('logout'); ?></a>
            </div>
        </div>

        <div class="header-section">
            <h2><?= __('app_title'); ?></h2>
            <a href="tambah.php" class="btn">+ <?= __('tambah'); ?></a>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th><?= __('kode_buku'); ?></th>
                        <th><?= __('judul'); ?></th>
                        <th><?= __('penulis'); ?></th>
                        <th><?= __('kategori'); ?></th>
                        <th><?= __('tahun'); ?></th>
                        <th style="text-align: center; width: 130px;"><?= __('aksi'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftar_buku)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 30px; color: #94a3b8;"><?= __('kosong'); ?></td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($daftar_buku as $buku): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><strong style="color: #0f172a;"><?= htmlspecialchars($buku['kode_buku']); ?></strong></td>
                                <td><?= htmlspecialchars($buku['judul']); ?></td>
                                <td><?= htmlspecialchars($buku['penulis']); ?></td>
                                <td><span class="badge-category"><?= htmlspecialchars($buku['kategori']); ?></span></td>
                                <td><?= htmlspecialchars($buku['tahun']); ?></td>
                                <td style="text-align: center;">
                                    <a href="ubah.php?id=<?= $buku['id']; ?>" class="action-link action-edit"><?= __('ubah'); ?></a>
                                    <span style="color: #cbd5e1; margin: 0 4px;">|</span>
                                    <a href="hapus.php?id=<?= $buku['id']; ?>" onclick="return confirm('<?= __('konfirmasi'); ?>')" class="action-link action-delete"><?= __('hapus'); ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>