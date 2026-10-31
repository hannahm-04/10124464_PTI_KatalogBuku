<?php
require "koneksi.php";
require "lang.php";

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET["id"] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

$kategori_list = [];
try {
    $stmtKat = $pdo->query("SELECT DISTINCT kategori FROM buku WHERE kategori IS NOT NULL AND kategori != '' ORDER BY kategori ASC");
    $kategori_list = $stmtKat->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {}

$error = [];

try {
    $stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
    $stmt->execute([":id" => $id]);
    $buku = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$buku) die("Data buku tidak ditemukan.");
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

$kode_buku = $buku["kode_buku"];
$judul     = $buku["judul"];
$penulis   = $buku["penulis"];
$kategori  = $buku["kategori"];
$tahun     = $buku["tahun"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $kode_buku = htmlspecialchars(trim($_POST["kode_buku"] ?? ""));
    $judul     = htmlspecialchars(trim($_POST["judul"] ?? ""));
    $penulis   = htmlspecialchars(trim($_POST["penulis"] ?? ""));
    $kategori  = htmlspecialchars(trim($_POST["kategori"] ?? ""));
    $tahun     = htmlspecialchars(trim($_POST["tahun"] ?? ""));

    if (empty($kode_buku)) $error[] = "Kode buku tidak boleh kosong.";
    if (empty($judul)) $error[] = "Judul buku tidak boleh kosong.";
    if (empty($penulis)) $error[] = "Nama penulis tidak boleh kosong.";
    if (empty($kategori)) $error[] = "Kategori tidak boleh kosong.";
    if (!is_numeric($tahun)) $error[] = "Tahun terbit harus berupa angka.";

    if (empty($error)) {
        try {
            $stmtUpdate = $pdo->prepare("UPDATE buku SET kode_buku = :kode_buku, judul = :judul, penulis = :penulis, kategori = :kategori, tahun = :tahun WHERE id = :id");
            $stmtUpdate->execute([
                ":kode_buku" => $kode_buku,
                ":judul"     => $judul,
                ":penulis"   => $penulis,
                ":kategori"  => $kategori,
                ":tahun"     => $tahun,
                ":id"        => $id
            ]);
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $error[] = "Gagal memperbarui data: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $current_lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('ubah'); ?> - <?= __('app_title'); ?></title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #f7caca 0%, #e5d8ec 50%, #93a9d1 100%);
            color: #334155;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 24px 16px;
        }
        .card {
            background: #ffffff;
            width: 100%;
            max-width: 480px;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
            border: 1px solid #e2e8f0;
        }
        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 13px;
        }
        .top-nav a {
            color: #e8a5a5;
            text-decoration: none;
            font-weight: 600;
        }
        .top-nav a:hover {
            text-decoration: underline;
        }
        h2 {
            font-size: 20px;
            color: #7890b8;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 16px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #7890b8;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            font-size: 14px;
            color: #1e293b;
            background-color: #f8fafc;
            transition: all 0.2s;
        }
        input[type="text"]:focus {
            outline: none;
            border-color: #38bdf8;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2);
        }
        .btn-group {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }
        .btn {
            flex: 1;
            padding: 11px;
            border-radius: 10px;
            border: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: 0.2s;
        }
        .btn-primary {
            background-color: #f7caca;
            color: #ffffff;
        }
        .btn-primary:hover {
            background-color: #e8a5a5;
        }
        .btn-secondary {
            background-color: #f7caca;
            color: #ffffff;
        }
        .btn-secondary:hover {
            background-color: #e8a5a5;
        }
        .alert-error {
            background-color: #fff1f2;
            border: 1px solid #fecdd3;
            color: #e11d48;
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="top-nav">
            <div>
                <a href="?id=<?= $id; ?>&lang=id">ID</a> | <a href="?id=<?= $id; ?>&lang=en">EN</a>
            </div>
        </div>

        <h2><?= __('ubah'); ?></h2>

        <?php if (!empty($error)): ?>
            <div class="alert-error">
                <?php foreach ($error as $e): ?>
                    <p style="margin: 2px 0;">• <?= $e; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="ubah.php?id=<?= $id; ?>">
            <div class="form-group">
                <label><?= __('kode_buku'); ?></label>
                <input type="text" name="kode_buku" value="<?= $kode_buku; ?>">
            </div>
            <div class="form-group">
                <label><?= __('judul'); ?></label>
                <input type="text" name="judul" value="<?= $judul; ?>">
            </div>
            <div class="form-group">
                <label><?= __('penulis'); ?></label>
                <input type="text" name="penulis" value="<?= $penulis; ?>">
            </div>
            <div class="form-group">
                <label><?= __('kategori'); ?></label>
                <input type="text" name="kategori" list="kategori-list" value="<?= $kategori; ?>" placeholder="Ketik atau pilih kategori..." autocomplete="off">
                <datalist id="kategori-list">
                    <?php foreach ($kategori_list as $kat): ?>
                        <option value="<?= htmlspecialchars($kat); ?>">
                    <?php endforeach; ?>
                </datalist>
            </div>
            <div class="form-group">
                <label><?= __('tahun'); ?></label>
                <input type="text" name="tahun" value="<?= $tahun; ?>">
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary"><?= __('simpan'); ?></button>
                <a href="index.php" class="btn btn-secondary"><?= __('kembali'); ?></a>
            </div>
        </form>
    </div>
</body>
</html>