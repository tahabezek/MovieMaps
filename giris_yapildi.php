<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uyeler";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $stmt = $conn->prepare("SELECT * FROM kayit WHERE kullaniciadi = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Kullanıcı doğru giriş yaptığında
            if (password_verify($password, $row["sifre"])) {
                $_SESSION['username'] = $username;
                $_SESSION['fullname'] = $row["kullaniciadi"];
                header("Location: giris_yapildi.php");
                exit;
            } else {
                // Yanlış şifre durumunda
                $errorMessage = "Kullanıcı adı veya şifre hatalı.";
                header("Location: giris_yapma.php");
                exit;
            }
        } else {
            // Kullanıcı bulunamadığında
            $errorMessage = "Kullanıcı bulunamadı.";
            header("Location: giris_yapma.php?error=$errorMessage");
            exit;
        }
    }
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}

$conn = null;
?>

<?php


// Kullanıcı giriş yapmamışsa giris.html sayfasına yönlendir
if (!isset($_SESSION['username'])) {
    header("Location: giris_yapma.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Başarılı</title>
</head>

<body>
<h1>Hoş Geldiniz, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</h1>
    <p>Kullanıcı adı: <?php echo htmlspecialchars($_SESSION['username']); ?></p>

    <p><a href="film_oneri.php">Dosya Yükleme Sayfası</a></p>

    <p><a href="cikis.php">Çıkış Yap</a></p>
</body>

</html>

