<?php
session_start();
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: giris.php");
    exit;
}
header("Location: urunler.php");
exit;