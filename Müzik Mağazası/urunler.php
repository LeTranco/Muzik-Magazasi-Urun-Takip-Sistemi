<?php
session_start();
require_once "config.php";
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: giris.php");
    exit;
}
$hata = "";
$basarili = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["guncelle_id"])) {
    $id = intval($_POST["guncelle_id"]);
    $urun_adi = trim($_POST["urun_adi"]);
    $kategori = trim($_POST["kategori"]);
    $fiyat = floatval($_POST["fiyat"]);
    $stok = intval($_POST["stok"]);
    $aciklama = trim($_POST["aciklama"]);

    if ($id && $urun_adi && $kategori && $fiyat > 0 && $stok >= 0) {
        $stmt = $conn->prepare("UPDATE urunler SET urun_adi=:urun_adi, kategori=:kategori, fiyat=:fiyat, stok=:stok, aciklama=:aciklama WHERE urun_id=:id");
        $stmt->bindParam(":urun_adi", $urun_adi);
        $stmt->bindParam(":kategori", $kategori);
        $stmt->bindParam(":fiyat", $fiyat);
        $stmt->bindParam(":stok", $stok);
        $stmt->bindParam(":aciklama", $aciklama);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        header("Location: urunler.php");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST["guncelle_id"])) {
    $urun_adi = trim($_POST["urun_adi"]);
    $kategori = trim($_POST["kategori"]);
    $fiyat = floatval($_POST["fiyat"]);
    $stok = intval($_POST["stok"]);
    $aciklama = trim($_POST["aciklama"]);

    if (empty($urun_adi) || empty($kategori) || $fiyat <= 0 || $stok < 0) {
        $hata = "Lutfen zorunlu alanlari dogru sekilde doldurun.";
    } else {
        $stmt = $conn->prepare("INSERT INTO urunler (urun_adi, kategori, fiyat, stok, aciklama) VALUES (:urun_adi, :kategori, :fiyat, :stok, :aciklama)");
        $stmt->bindParam(":urun_adi", $urun_adi);
        $stmt->bindParam(":kategori", $kategori);
        $stmt->bindParam(":fiyat", $fiyat);
        $stmt->bindParam(":stok", $stok);
        $stmt->bindParam(":aciklama", $aciklama);
        $stmt->execute();
    }
}

if (isset($_GET["sil"])) {
    $sil_id = intval($_GET["sil"]);
    $stmt = $conn->prepare("DELETE FROM urunler WHERE urun_id = :id");
    $stmt->bindParam(":id", $sil_id);
    $stmt->execute();
    header("Location: urunler.php");
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Urun Yonetimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
<nav class="d-flex justify-content-end mb-4">
    <span class="me-3">Hos geldin, <strong><?= $_SESSION["isim"] ?></strong></span>
    <a href="cikis.php" class="btn btn-outline-secondary btn-sm">Cikis Yap</a>
</nav>
    <h2 class="text-center mb-4">Yeni Urun Ekle</h2>
    <form method="post" class="mb-5">
        <div class="row mb-2">
            <div class="col"><input type="text" name="urun_adi" class="form-control" placeholder="Urun Adi *" required></div>
            <div class="col"><input type="text" name="kategori" class="form-control" placeholder="Kategori *" required></div>
            <div class="col"><input type="number" name="fiyat" step="0.01" class="form-control" placeholder="Fiyat (₺) *" required></div>
            <div class="col"><input type="number" name="stok" class="form-control" placeholder="Stok *" required></div>
        </div>
        <textarea name="aciklama" class="form-control mb-2" placeholder="Aciklama"></textarea>
        <button type="submit" class="btn btn-primary">Urun Ekle</button>
    </form>

    <h2 class="text-center">Urun Listesi</h2>
    <table class="table table-bordered table-striped text-center">
        <tr>
            <th>ID</th>
            <th>Urun Adi</th>
            <th>Kategori</th>
            <th>Fiyat</th>
            <th>Stok</th>
            <th>Aciklama</th>
            <th>İslemler</th>
        </tr>
        <?php
        $stmt = $conn->query("SELECT * FROM urunler ORDER BY urun_id DESC");
        foreach ($stmt as $row): ?>
        <tr>
            <td><?= $row["urun_id"] ?></td>
            <td><?= htmlspecialchars($row["urun_adi"]) ?></td>
            <td><?= htmlspecialchars($row["kategori"]) ?></td>
            <td><?= $row["fiyat"] ?></td>
            <td><?= $row["stok"] ?></td>
            <td><?= htmlspecialchars($row["aciklama"]) ?></td>
            <td>
                <a href="?duzenle=<?= $row["urun_id"] ?>" class="btn btn-sm btn-primary">Duzenle</a>
                <a href="?sil=<?= $row["urun_id"] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Silmek istediginize emin misiniz?')">Sil</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

<?php

if (isset($_GET["duzenle"])) {
    $id = intval($_GET["duzenle"]);
    $stmt = $conn->prepare("SELECT * FROM urunler WHERE urun_id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $urun = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($urun):
?>
    <hr>
    <h2 class="text-center">Urun Guncelle</h2>
    <form method="post" class="mb-5">
        <input type="hidden" name="guncelle_id" value="<?= $urun["urun_id"] ?>">
        <div class="row mb-2">
            <div class="col"><input type="text" name="urun_adi" class="form-control" value="<?= htmlspecialchars($urun["urun_adi"]) ?>" required></div>
            <div class="col"><input type="text" name="kategori" class="form-control" value="<?= htmlspecialchars($urun["kategori"]) ?>" required></div>
            <div class="col"><input type="number" name="fiyat" step="0.01" class="form-control" value="<?= $urun["fiyat"] ?>" required></div>
            <div class="col"><input type="number" name="stok" class="form-control" value="<?= $urun["stok"] ?>" required></div>
        </div>
        <textarea name="aciklama" class="form-control mb-2"><?= htmlspecialchars($urun["aciklama"]) ?></textarea>
        <button type="submit" class="btn btn-success">Guncelle</button>
    </form>
<?php
    endif;
}
?>
</body>
</html>