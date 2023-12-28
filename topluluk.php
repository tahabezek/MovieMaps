<?php
session_start();

// Kullanıcı giriş yapmamışsa giris.html sayfasına yönlendir
if (!isset($_SESSION['username'])) {
    header("Location: giris_yapma.php");
    exit;
}

// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uyeler";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Film önerilerini çek
    $stmt = $conn->prepare("SELECT * FROM oneri ORDER BY id DESC");
    $stmt->execute();
    $oneriler = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Veritabanı hatası: " . $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Recommendations</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            background-color: #1e1e1e;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            width: 80%;
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        h3 a {
            color: #f9ca9c;
            text-decoration: none;
        }

        h3 {
            font-size: 25px;
            margin-bottom: 15px;
            text-align: center;
        }

        .oneri {
            position: relative;
            width: 48%;
            box-sizing: border-box;
            border: 2px solid #f9ca9c;
            padding: 20px;
            margin: 20px 0;
            background-color: #292929;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: background-color 0.3s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .oneri:hover {
            background-color: #333333;
        }

        .yorum-alani {
            width: 100%;
            margin-top: 15px;
            background-color: #333333;
            padding: 20px;
            border-radius: 8px;
        }

        .yorum-yap {
            color: #fff;
            text-decoration: none;
            cursor: pointer;
            transition: color 0.3s;
            position: absolute;
            bottom: 20px;
            right: 20px;
            font-weight: bold;
            font-size: 16px;
        }

        .yorum-yap:hover {
            color: #ff3d3d;
        }

        .yorum {
            color: #f9ca9c;
            font-size: 16px;
            margin: 15px 0;
            line-height: 1.4;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-top: 15px;
            max-height: 300px;
            object-fit: cover;
            display: block;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <h3><a href= "logged_in.php">Movie Map</a></h3>
        <h3><a href= "filmler.php">Filmler</a></h3>
        <h3><a href= "topluluk.php">Topluluk</a></h3>
        <h3><a href= "topluluk.php">Yardım ve Destek</a></h3>
        <h3><a href= "topluluk.php">Hakkımızda</a></h3>

        <h3>Hoş Geldiniz, <?php echo htmlentities(htmlspecialchars($_SESSION['username'])); ?>! (<a href="cikis.php">Çıkış Yap</a>)</h3>

        <?php foreach ($oneriler as $oneri): ?>
            <div class="oneri">
                <p><strong>Kullanıcı Adı:</strong> <?php echo htmlentities(htmlspecialchars($oneri['kullaniciadi'])); ?></p>
                <p><strong>Film Adı:</strong> <?php echo htmlentities(htmlspecialchars($oneri['film_adi'])); ?></p>
                <p><strong>IMDb Puanı:</strong> <?php echo htmlentities(htmlspecialchars($oneri['imdb_puani'])); ?></p>
                <p><strong>Neden Öneri:</strong> <?php echo htmlentities(htmlspecialchars($oneri['neden_oneri'])); ?></p>

                <?php
                $dosyaYolu = $oneri['dosya_yolu'];
                $dosyaTuru = mime_content_type($dosyaYolu);

                if (strpos($dosyaTuru, 'image') === 0) {
                    echo '<img src="' . htmlentities($dosyaYolu) . '" alt="Film Afişi">';
                } 
                elseif (strpos($dosyaTuru, 'application/pdf') === 0) {
                    echo '<embed src="' . htmlentities($dosyaYolu) . '" type="application/pdf" width="100%" height="200px" />';
                } else {
                    echo 'Dosya türü desteklenmiyor.';
                }
                ?>
                
                <!-- Yorum yapma bağlantısı -->
                <a href="yorum.php?id=<?php echo $oneri['id']; ?>" class="yorum-yap">Yorum Yap</a>

                <!-- Yorumları gösterme alanı -->
                <div class="yorum-alani">
                    <?php
                    // Öneriye ait yorumları çek
                    $connYorum = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $stmtYorum = $connYorum->prepare("SELECT * FROM yorumlar WHERE id = :id");
                    $stmtYorum->bindParam(':id', $oneri['id']);
                    $stmtYorum->execute();
                    $yorumlar = $stmtYorum->fetchAll(PDO::FETCH_ASSOC);

                    // Yorumları listele
                    foreach ($yorumlar as $yorum) {
                        echo '<p class="yorum"><strong>' . htmlentities($yorum['yapan_kisi']) . ':</strong> ' . htmlentities($yorum['yorum']) . '</p>';
                    }

                    // Bağlantıyı kapat
                    $connYorum = null;
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>




