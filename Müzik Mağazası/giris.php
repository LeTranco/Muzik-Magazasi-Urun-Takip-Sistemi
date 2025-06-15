<?php
session_start();
require_once "config.php";
$hata = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $sifre = $_POST["sifre"];

    if (empty($email) || empty($sifre)) {
        $hata = "Lutfen tum alanlari doldurun!";
    } else {
        try {
            $sql = "SELECT kullanici_id, isim, soyisim, sifre_hash FROM kullanicilar WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($sifre, $user["sifre_hash"])) {
                    $_SESSION["kullanici_id"] = $user["kullanici_id"];
                    $_SESSION["isim"] = $user["isim"];
                    $_SESSION["soyisim"] = $user["soyisim"];
                    header("Location: dashboard.php");
                    exit;
                } else {
                    $hata = "E-posta veya sifre yanlis!";
                }
            } else {
                $hata = "E-posta veya sifre yanlis!";
            }
        } catch (PDOException $e) {
            $hata = "Hata olustu: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 shadow">
                    <h2 class="mb-4 text-center">Giriş Yap</h2>
                    <?php if (!empty($hata)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($hata); ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-posta</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="sifre" class="form-label">Şifre</label>
                            <input type="password" name="sifre" id="sifre" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
                    </form>
                    <div class="mt-3 text-center">
                        <a href="kaydol.php">Hesabiniz yok mu? Kayit olun</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>