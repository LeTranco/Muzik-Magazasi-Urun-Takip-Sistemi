<?php
require_once "config.php";

$hata = "";
$basarili = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isim = trim($_POST["isim"]);
    $soyisim = trim($_POST["soyisim"]);
    $email = trim($_POST["email"]);
    $sifre = $_POST["sifre"];

    if (empty($isim) || empty($soyisim) || empty($email) || empty($sifre)) {
        $hata = "Lutfen tum alanlari doldurun!";
    } else {
        $sifre_hash = password_hash($sifre, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO kullanicilar (isim, soyisim, email, sifre_hash) 
                    VALUES (:isim, :soyisim, :email, :sifre_hash)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":isim", $isim);
            $stmt->bindParam(":soyisim", $soyisim);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":sifre_hash", $sifre_hash);
            $stmt->execute();
            $basarili = "Kayit basarili! Artik giris yapabilirsiniz.";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $hata = "Bu e-posta adresi zaten kayitli!";
            } else {
                $hata = "Kayit sirasinda bir hata olustu: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kullanici Kaydi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 shadow">
                    <h2 class="mb-4 text-center">Kullanici Kaydi</h2>
                    <?php if (!empty($hata)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($hata); ?></div>
                    <?php endif; ?>

                    <?php if (!empty($basarili)): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($basarili); ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="isim" class="form-label">İsim</label>
                            <input type="text" name="isim" id="isim" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="soyisim" class="form-label">Soyisim</label>
                            <input type="text" name="soyisim" id="soyisim" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-posta</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="sifre" class="form-label">Sifre</label>
                            <input type="password" name="sifre" id="sifre" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Kayit Ol</button>
                    </form>
                    <div class="mt-3 text-center">
                        <a href="giris.php">Zaten hesabiniz var mi? Giris yap</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>