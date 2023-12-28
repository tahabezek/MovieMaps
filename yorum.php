<?php
session_start();

// Veritabanı bağlantı bilgileri
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uyeler";

// Veritabanı bağlantısını oluştur
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Bağlantı hatası: " . $e->getMessage());
}

// Hedeflenen öneri ID'sini al
$oneriId = isset($_GET['id']) ? $_GET['id'] : null;

// Öneri ID'si verilmediyse veya geçerli değilse hata mesajı göster
if (!$oneriId) {
    die("Hatalı öneri ID'si.");
}

// Veritabanından öneri bilgilerini al
try {
    $stmt = $conn->prepare("SELECT * FROM oneri WHERE id = :oneriId");
    $stmt->bindParam(':oneriId', $oneriId);
    $stmt->execute();
    $oneri = $stmt->fetch(PDO::FETCH_ASSOC);

    // Öneri bulunamazsa hata mesajı göster
    if (!$oneri) {
        die("Öneri bulunamadı.");
    }
} catch (PDOException $e) {
    die("Veritabanı hatası: " . $e->getMessage());
}

// Yorum gönderilmişse kaydet
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $yorum = $_POST["yorum"];

    // Yorumu veritabanına kaydet
    try {
        $stmt = $conn->prepare("INSERT INTO yorumlar (yapilan_yorum, yapan_kisi, yapilan_film, yorum, id, yapilan_kisi) VALUES (:yapilan_yorum, :kullaniciadi, :filmAdi, :yorum, :id, :yapilan_kisi)");
        $stmt->bindParam(':kullaniciadi', $_SESSION['username']);
        $stmt->bindParam(':filmAdi', $oneri['film_adi']);
        $stmt->bindParam(':id', $oneri['id']);
        $stmt->bindParam(':yapilan_kisi', $oneri['kullaniciadi']);
        $stmt->bindParam(':yapilan_yorum', $oneri['neden_oneri']);
        $stmt->bindParam(':yorum', $yorum);
        $stmt->execute();

        // Yorum eklendikten sonra kullanıcıyı başka bir sayfaya yönlendir
        header("Location: topluluk.php");
        exit;
    } catch (PDOException $e) {
        die("Veritabanı hatası: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yorum Yap</title>
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
            width: 50%;
            margin-top: 20px;
            color: #f9ca9c; /* Kullanıcı adının rengi */
        }

        p {
            text-align: center;
            color: #f9ca9c; /* Öneri detaylarındaki yazı rengi */
            margin: 5px 0;
        }

        h1  {
            text-align: center;
        }

        .oneri {
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
            position: relative;
        }

        .oneri:hover {
            background-color: #333333;
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

        form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #f9ca9c; /* Yorumun yazı rengi */
        }

        textarea {
           
            width: 100%;
            height: 100px;
            margin-top: 10px;
            resize: none;
            border-radius: 10px;
            background-color: #333333; /* Arka plan rengi */
            color: #f9ca9c; /* Metin rengi */
            border: 2px solid #f9ca9c; /* Kenar rengi ve kalınlığı */
            font-size: 18px; /* Yazı boyutu */

        }

        button {
            margin-top: 10px;
            padding: 10px;
            cursor: pointer;
            border-radius: 10px;
            width: 100px;
            height: 60px;
            color: #f9ca9c;
            background-color: #292929; /* Daha uyumlu bir renk */
            border: 2px solid #f9ca9c; /* Kenar rengi ve kalınlığı */
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #1a1a1a; /* Hover durumunda arkaplan rengini biraz daha koyu yap */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Yorum Yap</h1>

        <div class="oneri">
            <p><strong>Kullanıcı Adı:</strong> <?php echo htmlentities(htmlspecialchars($oneri['kullaniciadi'])); ?></p>
            <p><strong>Film Adı:</strong> <?php echo htmlentities(htmlspecialchars($oneri['film_adi'])); ?></p>
            <p><strong>IMDb Puanı:</strong> <?php echo htmlentities(htmlspecialchars($oneri['imdb_puani'])); ?></p>
            <p><strong>Neden Öneri:</strong> <?php echo htmlentities(htmlspecialchars($oneri['neden_oneri'])); ?></p>
            
            <!-- Yüklenen dosyanın türüne göre ekrana yazdırma -->
            <?php
                $dosyaYolu = $oneri['dosya_yolu'];
                $dosyaTuru = mime_content_type($dosyaYolu);

                // Dosya türüne göre özel içerik gösterimi
                if (strpos($dosyaTuru, 'image') === 0) {
                    // Resim dosyası
                    echo '<img src="' . htmlentities($dosyaYolu) . '" alt="Film Afişi">';
                } 
                elseif (strpos($dosyaTuru, 'application/pdf') === 0) {
                    // PDF dosyası
                    echo '<embed src="' . htmlentities($dosyaYolu) . '" type="application/pdf" width="100%" height="200px" />';
                } else {
                    // Diğer dosya türleri
                    echo 'Dosya türü desteklenmiyor.';
                }
            ?>
        </div>

        <form action="" method="post">
            <label for="yorum">Yorumunuz:</label>
            <textarea id="yorum" name="yorum" required></textarea><br>
            <button type="submit">Yorum Yap</button>
        </form>
    </div>
</body>

</html>

