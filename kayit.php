<?php
// kullanıcı oturumunu başlat.
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
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirm-password"];

        // Kullanıcı adının benzersiz olup olmadığını kontrol et
        $stmt = $conn->prepare("SELECT * FROM kayit WHERE kullaniciadi = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            // Kullanıcı adı zaten varsa hata mesajı ile birlikte kayıt sayfasına yönlendir
            $errorMessage = "Bu kullanıcı adı zaten kullanılıyor.";
            header("Location: kayit_olma.php?error=$errorMessage");
            exit;
        }

        // Kullanıcı adı benzersizse, şifreleri kontrol et ve kayıt yap
        if ($password === $confirmPassword) {
            
            // Şifreyi hashleyerek güvenli bir şekilde sakla
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Kayıt işlemi
            $stmt = $conn->prepare("INSERT INTO kayit (kullaniciadi, eposta, sifre) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword); // Hashlenmiş şifreyi kullan
            $stmt->execute();

            // Kayıt işlemi başarılıysa giriş sayfasına yönlendir
            header("Location: giris_yapma.php");
            exit;
        } else {
            // Şifreler uyuşmuyorsa hata mesajı ile birlikte kayıt sayfasına yönlendir
            $errorMessage = "Şifreler uyuşmuyor.";
            header("Location: kayit_olma.php?error=$errorMessage");
            exit;
        }
    }
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}

$conn = null;
?>
