<?php
session_start();

// Kullanıcı giriş yapmamışsa giris.html sayfasına yönlendir
if (!isset($_SESSION['username'])) {
    header("Location: giris_yapma.php");
    exit;
}

$hataMesaji = "";

// Form gönderildiyse işlemleri yap
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $filmAdi = $_POST["filmAdi"];
    $imdbPuani = $_POST["imdbPuani"];
    $nedenOneri = $_POST["nedenOneri"];

    // Yüklenen dosyanın bilgileri
    $dosyaAdi = $_FILES["dosya"]["name"];
    $dosyaTmpAdi = $_FILES["dosya"]["tmp_name"];
    $dosyaBoyutu = $_FILES["dosya"]["size"];
    $dosyaTipi = $_FILES["dosya"]["type"];
    $dosyaHata = $_FILES["dosya"]["error"];

    // İzin verilen dosya türleri
    $izinVerilenTurler = array("image/jpeg", "image/jpg", "image/png", "application/pdf");

    // Dosyanın türünü kontrol et
    if (in_array($dosyaTipi, $izinVerilenTurler)) {
        // Dosya boyutunu kontrol et
        if ($dosyaBoyutu <= 4 * 1024 * 1024) { // 4MB
            // Dosyayı belirtilen klasöre taşı
            $hedefKlasor = "yuklenen_afisler/";
            $hedefDosyaYolu = $hedefKlasor . $dosyaAdi;
            $hedefKlasor = "yuklenen_afisler/";

    // Klasör var mı diye kontrol et, yoksa oluştur
    if (!file_exists($hedefKlasor)) {
        mkdir($hedefKlasor, 0777, true);
    }


            if (move_uploaded_file($dosyaTmpAdi, $hedefDosyaYolu)) {
                //echo "Dosya başarıyla yüklendi.";
                // Dosya başarıyla yüklendiyse, veritabanına kayıt yap
                try {
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "uyeler";

                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Veritabanına ekleme işlemi
                    $stmt = $conn->prepare("INSERT INTO oneri (kullaniciadi, film_adi, imdb_puani, neden_oneri, dosya_yolu) 
                        VALUES (:kullaniciadi, :filmAdi, :imdbPuani, :nedenOneri, :dosyaYolu)");
                    $stmt->bindParam(':kullaniciadi', $_SESSION['username']);
                    $stmt->bindParam(':filmAdi', $filmAdi);
                    $stmt->bindParam(':imdbPuani', $imdbPuani);
                    $stmt->bindParam(':nedenOneri', $nedenOneri);
                    $stmt->bindParam(':dosyaYolu', $hedefDosyaYolu);
                    $stmt->execute();
                } catch (PDOException $e) {
                    $hataMesaji = "Veritabanı hatası: " . $e->getMessage();
                }
            } else {
                $hataMesaji = "Dosya yükleme hatası.";
            }
        } else {
            $hataMesaji = "Dosya boyutu 4MB'den küçük olmalıdır.";
        }
    } else {
        $hataMesaji = "Geçersiz dosya türü. Sadece JPEG ve PNG dosyaları desteklenmektedir.";
    }
    header("Location: topluluk.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Film Öneri Yükleme Formu</title>
    <link rel="stylesheet" href="style.css">
    
</head>

<body>
    <div class="container">
        <h1>Film Öneri Yükleme Formu</h1>

        <?php if ($hataMesaji): ?>
            <p class="error-message"><?php echo $hataMesaji; ?></p>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <label for="filmAdi">Film Adı:</label>
            <input type="text" name="filmAdi" required>

            <label for="imdbPuani">IMDb Puanı:</label>
            <input type="text" name="imdbPuani" required>

            <label for="nedenOneri">Neden Öneriyorsunuz:</label>
            <textarea name="nedenOneri" rows="4" required></textarea>

            <label for="dosya">Film Afişi:</label>
            <input type="file" id="dosya" name="dosya" required>

            <button type="submit">Gönder</button>
        </form>

        <p>Ana Sayfaya geri dönmek için <br><a href="logged_in.php">buraya tıklayabilirsiniz.</a></p>
       
    </div>
</body>

</html>
