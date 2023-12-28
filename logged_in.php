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
                header("Location: logged_in.php");
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

    <meta charset="utf-8">
    <meta name="author" content="templatemo">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

    <title>Ana Sayfa</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

  </head>

<body>

  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="logged_in.php" class="logo">
                        <img src="assets/images/logo1.png" alt="">
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li><a href="logged_in.php" class="active">Ana Sayfa</a></li>
                        <li><a href="filmler.php">Filmler</a></li>
                        <li><a href="topluluk.php">Topluluk</a></li>
                        <li><a href="hakkimizda.php">Hakkımızda</a></li>
                        <li><a href=""><h6 style="color: black;">Hoş Geldiniz, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</h6></a></li>
                        <li><a href="cikis.php">Çıkış Yap</a></li>
                        
                    </ul>   
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->

  <!-- ***** Main Banner Area Start ***** -->
<div class="main-banner">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 align-self-center">
        <div class="header-text">
          <h2>Ready Player One</h2>
          <p>OASIS adı verilen sanal gerçekliğin yaratıcısı öldüğünde, tüm OASIS kullanıcılarına, bulana servetini ve dünyasının kontrolünü verecek olan Paskalya Yumurtasını bulmaları için ölümcül bir meydan okuma yapar</p>
          <div class="buttons">

            <div class="main-button">
              <a href="https://www.youtube.com/watch?v=cSp1dM2Vj48" target="_blank">Fragmanı İzle</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5 offset-lg-1">
        <div class="owl-banner owl-carousel">
          <div class="item">
            <img src="assets/images/banner-01.png" alt="">
          </div>
          <div class="item">
            <img src="assets/images/banner-02.png" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ***** Main Banner Area End ***** -->

<div class="categories-collections">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="col-lg-12">
          <div class="collections">
            <div class="row">
              <div class="col-lg-12">
                <div class="section-heading">
                  <div class="line-dec"></div>
                  <h2>Eleştirmenlerden <em>Tam Not Alan</em> Filmler</h2>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="owl-collection owl-carousel" data-items="8" data-margin="20" data-autoplay="true" data-loop="true">

                  <div class="item">
                    <img src="assets/images/afisler/bihter.jpg" alt="">
                    <div class="down-content">
                      <h4>Bihter</h4>
                      <span class="collection">Yapım Yılı: <br><strong>2023</strong></span>
                      <span class="category">Kategori: <br><strong>Dram, Romantik</strong></span>
                      <div class="main-button">
                        <a href="filmler.php">Fragmanı İzle</a>
                      </div>
                    </div>
                  </div>

                  <div class="item">
                    <img src="assets/images/afisler/albanian.jpg" alt="">
                    <div class="down-content">
                      <h4>The Albanian Virgin</h4>
                      <span class="collection">Yapım Yılı: <br><strong>2021</strong></span>
                      <span class="category">Kategori: <br><strong>Dram</strong></span>
                      <div class="main-button">
                        <a href="filmler.php">Fragmanı İzle</a>
                      </div>
                    </div>
                  </div>

                  <div class="item">
                    <img src="assets/images/afisler/olumludunya.jpg" alt="">
                    <div class="down-content">
                      <h4>Ölümlü Dünya 2</h4>
                      <span class="collection">Yapım Yılı: <br><strong>2023</strong></span>
                      <span class="category">Kategori: <br><strong>Absürt Komedi</strong></span>
                      <div class="main-button">
                        <a href="filmler.php">Fragmanı İzle</a>
                      </div>
                    </div>
                  </div>

                  <div class="item">
                    <img src="assets/images/afisler/ataturk.png" alt="">
                    <div class="down-content">
                      <h4>Atatürk 2</h4>
                      <span class="collection">Yapım Yılı: <br><strong>2023</strong></span>
                      <span class="category">Kategori: <br><strong>Biyografi Tarihi</strong></span>
                      <div class="main-button">
                        <a href="filmler.php">Fragmanı İzle</a>
                      </div>
                    </div>
                  </div>

              

                  <div class="item">
                    <img src="assets/images/afisler/beekepper.jpg" alt="">
                    <div class="down-content">
                      <h4>Beekeeper</h4>
                      <span class="collection">Yapım Yılı: <br><strong>2023</strong></span>
                      <span class="category">Kategori: <br><strong>Aksiyon</strong></span>
                      <div class="main-button">
                        <a href="filmler.php">Fragmanı İzle</a>
                      </div>
                    </div>
                  </div>

                  <div class="item">
                    <img src="assets/images/afisler/alya.jpg" alt="">
                    <div class="down-content">
                      <h4>Alya</h4>
                      <span class="collection">Yapım Yılı: <br><strong>2023</strong></span>
                      <span class="category">Kategori: <br><strong>Dram</strong></span>
                      <div class="main-button">
                        <a href="filmler.php">Fragmanı İzle</a>
                      </div>
                    </div>
                  </div>

                  <div class="item">
                    <img src="assets/images/afisler/hayat.jpg" alt="">
                    <div class="down-content">
                      <h4>Hayat</h4>
                      <span class="collection">Yapım Yılı: <br><strong>2023</strong></span>
                      <span class="category">Kategori: <br><strong>Dram</strong></span>
                      <div class="main-button">
                        <a href="filmler.php">Fragmanı İzle</a>
                      </div>
                    </div>
                  </div>
                   
                  <!-- bir filmin yapısı -->
                  <div class="item">
                    <img src="assets/images/afisler/maestro.jpg" alt="">
                    <div class="down-content">
                      <h4>Maestro</h4>
                      <span class="collection">Yapım Yılı: <br><strong>2023</strong></span>
                      <span class="category">Kategori: <br><strong>Aksiyon</strong></span>
                      <div class="main-button">
                        <a href="filmler.php">Fragmanı İzle</a>
                      </div>
                    </div>
                  </div>

                      <!-- Diğer film öğeleri buraya eklenebilir -->

                  

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

  <div class="create-nft">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="section-heading">
            <div class="line-dec"></div>
            <h2>İnsanlara İzlemeleri İçin Tavsiyede Bulun.</h2>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="main-button">
            <a href="film_oneri.php">Film Önerisinde Bulunmak İçin Tıklayınız.</a>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="item first-item">
            <div class="number">
              <h6>1</h6>
            </div>
            <div class="icon">
              <img src="assets/images/icon-02.png" alt="">
            </div>
            <h4>Filmin Afişini Yükleyin</h4>
            <p>Önereceğiniz filmin resmi afişini yükleyin. Böylelikle insanların film hakkında ön bilgiye sahip olmalarını sağlarsınız.</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="item second-item">
            <div class="number">
              <h6>2</h6>
            </div>
            <div class="icon">
              <img src="assets/images/icon-04.png" alt="">
            </div>
            <h4>Filmin IMDB Puanını Yazın.</h4>
            <p>Filmin IMDB puanını yükleyerek insanlara filmin uzmanlardan ve analizcilerden aldığı notu gösterirsiniz.</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="item">
            <div class="icon">
              <img src="assets/images/icon-06.png" alt="">
            </div>
            <h4>Filmi Neden Önerdiğinizi Yazın.</h4>
            <p>Filmi neden önerdiğinizi belirterek diğer insanların ilgisini çekip önerdiğiniz filmi izlemelerini sağlayabilirsiniz.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="currently-market">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <div class="section-heading">
          <div class="line-dec"></div>
          <h2><em>Önerilen Filmler</em></h2>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="filters">
          <ul>
            <li data-filter="*" class="active">Tümü</li>
            <li data-filter=".dram">Dram</li>
            <li data-filter=".korku">Korku</li>
            <li data-filter=".komedi">Komedi</li>
            <li data-filter=".gerilim">Gerilim</li>
            <li data-filter=".macera">Macera</li>
          </ul>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="row grid">
          <!-- Drama Filmleri -->
          <div class="col-lg-6 currently-market-item all dram">
            <div class="item">
              <div class="left-image">
                <img src="assets/images/afisler/bihter.jpg" alt="" style="border-radius: 20px; min-width: 195px;">
              </div>
              <div class="right-content">
                <!-- Film Bilgileri -->
                  <h4>Bihter</h4>
                  <span class="author">
                    <img src="assets/images/author.jpg" alt="" style="max-width: 50px; border-radius: 50%;">
                    <h6>Taha Bezek<br><a href="#">@tahabezek</a></h6>
                  </span>
                  <div class="line-dec"></div>
                  <span class="bid">
                    Yapım Yılı: 2023<br><em>IMDB puanı: 8.3</em><br>Yönetmen: Jason Reitman<br>Oyuncular: Bill Murray, Dan Aykroyd
                  </span>
                  <div class="text-button">
                    <a href="details.html">Fragmanı İzle</a>
                  </div>

              </div>
            </div>
          </div>
          <!-- Diğer Drama Filmleri -->

          <div class="col-lg-6 currently-market-item all dram">
            <div class="item">
              <div class="left-image">
                <img src="assets/images/afisler/ataturk1.png" alt="" style="border-radius: 20px; min-width: 195px;">
              </div>
              <div class="right-content">
                <!-- Film Bilgileri -->
                <h4>Atatürk</h4>
                  <span class="author">
                    <img src="assets/images/author.jpg" alt="" style="max-width: 50px; border-radius: 50%;">
                    <h6>Taha Bezek<br><a href="#">@tahabezek</a></h6>
                  </span>
                  <div class="line-dec"></div>
                  <span class="bid">
                    Yapım Yılı: 2023<br><em>IMDB puanı: 8.3</em><br>Yönetmen: Jason Reitman<br>Oyuncular: Bill Murray, Dan Aykroyd
                  </span>
                  <div class="text-button">
                    <a href="details.html">Fragmanı İzle</a>
                  </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 currently-market-item all dram">
            <div class="item">
              <div class="left-image">
                <img src="assets/images/afisler/sobe.jpg" alt="" style="border-radius: 20px; min-width: 195px;">
              </div>
              <div class="right-content">
                <!-- Film Bilgileri -->
                <h4>Sobe</h4>
                  <span class="author">
                    <img src="assets/images/author.jpg" alt="" style="max-width: 50px; border-radius: 50%;">
                    <h6>Taha Bezek<br><a href="#">@tahabezek</a></h6>
                  </span>
                  <div class="line-dec"></div>
                  <span class="bid">
                    Yapım Yılı: 2023<br><em>IMDB puanı: 8.3</em><br>Yönetmen: Jason Reitman<br>Oyuncular: Bill Murray, Dan Aykroyd
                  </span>
                  <div class="text-button">
                    <a href="details.html">Fragmanı İzle</a>
                  </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 currently-market-item all dram">
            <div class="item">
              <div class="left-image">
                <img src="assets/images/afisler/aquaman.jpg" alt="" style="border-radius: 20px; min-width: 195px;">
              </div>
              <div class="right-content">
                <!-- Film Bilgileri -->
                <h4>Aquaman ve Kayıp Krallık</h4>
                  <span class="author">
                    <img src="assets/images/author.jpg" alt="" style="max-width: 50px; border-radius: 50%;">
                    <h6>Taha Bezek<br><a href="#">@tahabezek</a></h6>
                  </span>
                  <div class="line-dec"></div>
                  <span class="bid">
                    Yapım Yılı: 2023<br><em>IMDB puanı: 8.3</em><br>Yönetmen: Jason Reitman<br>Oyuncular: Bill Murray, Dan Aykroyd
                  </span>
                  <div class="text-button">
                    <a href="details.html">Fragmanı İzle</a>
                  </div>
              </div>
            </div>
          </div>
          
          <!-- Korku Filmleri -->
          <div class="col-lg-6 currently-market-item all korku">
            <div class="item">
              <div class="left-image">
                <img src="assets/images/afisler/dakota.jpg" alt="" style="border-radius: 20px; min-width: 195px;">
              </div>
              <div class="right-content">
                <!-- Film Bilgileri -->
                <h4>Dakota</h4>
                  <span class="author">
                    <img src="assets/images/author.jpg" alt="" style="max-width: 50px; border-radius: 50%;">
                    <h6>Taha Bezek<br><a href="#">@tahabezek</a></h6>
                  </span>
                  <div class="line-dec"></div>
                  <span class="bid">
                    Yapım Yılı: 2023<br><em>IMDB puanı: 8.3</em><br>Yönetmen: Jason Reitman<br>Oyuncular: Bill Murray, Dan Aykroyd
                  </span>
                  <div class="text-button">
                    <a href="details.html">Fragmanı İzle</a>
                  </div>
              </div>
            </div>
          </div>
          <!-- Diğer Korku Filmleri -->

          <div class="col-lg-6 currently-market-item all korku">
            <div class="item">
              <div class="left-image">
                <img src="assets/images/afisler/madmax.jpg" alt="" style="border-radius: 20px; min-width: 195px;">
              </div>
              <div class="right-content">
                <!-- Film Bilgileri -->
                <h4>Mad Max</h4>
                  <span class="author">
                    <img src="assets/images/author.jpg" alt="" style="max-width: 50px; border-radius: 50%;">
                    <h6>Taha Bezek<br><a href="#">@tahabezek</a></h6>
                  </span>
                  <div class="line-dec"></div>
                  <span class="bid">
                    Yapım Yılı: 2023<br><em>IMDB puanı: 8.3</em><br>Yönetmen: Jason Reitman<br>Oyuncular: Bill Murray, Dan Aykroyd
                  </span>
                  <div class="text-button">
                    <a href="details.html">Fragmanı İzle</a>
                  </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 currently-market-item all korku">
            <div class="item">
              <div class="left-image">
                <img src="assets/images/afisler/exorcsit.jpg" alt="" style="border-radius: 20px; min-width: 195px;">
              </div>
              <div class="right-content">
                <!-- Film Bilgileri -->
                <h4>Exorcsit</h4>
                  <span class="author">
                    <img src="assets/images/author.jpg" alt="" style="max-width: 50px; border-radius: 50%;">
                    <h6>Taha Bezek<br><a href="#">@tahabezek</a></h6>
                  </span>
                  <div class="line-dec"></div>
                  <span class="bid">
                    Yapım Yılı: 2023<br><em>IMDB puanı: 8.3</em><br>Yönetmen: Jason Reitman<br>Oyuncular: Bill Murray, Dan Aykroyd
                  </span>
                  <div class="text-button">
                    <a href="details.html">Fragmanı İzle</a>
                  </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 currently-market-item all korku">
            <div class="item">
              <div class="left-image">
                <img src="assets/images/afisler/hayaletavcilari.jpg" alt="" style="border-radius: 20px; min-width: 195px;">
              </div>
              <div class="right-content">
                <!-- Film Bilgileri -->
                <h4>Hayalet Avcıları</h4>
                  <span class="author">
                    <img src="assets/images/author.jpg" alt="" style="max-width: 50px; border-radius: 50%;">
                    <h6>Taha Bezek<br><a href="#">@tahabezek</a></h6>
                  </span>
                  <div class="line-dec"></div>
                  <span class="bid">
                    Yapım Yılı: 2023<br><em>IMDB puanı: 8.3</em><br>Yönetmen: Jason Reitman<br>Oyuncular: Bill Murray, Dan Aykroyd
                  </span>
                  <div class="text-button">
                    <a href="details.html">Fragmanı İzle</a>
                  </div>
              </div>
            </div>
          </div>

          <!-- Komedi Filmleri -->
          <div class="col-lg-6 currently-market-item all komedi">
            <div class="item">
              <div class="left-image">
                <img src="assets/images/afisler/kungfu.jpg" alt="" style="border-radius: 20px; min-width: 195px;">
              </div>
              <div class="right-content">
                <!-- Film Bilgileri -->
                <h4>Kung Fu Panda 4</h4>
                  <span class="author">
                    <img src="assets/images/author.jpg" alt="" style="max-width: 50px; border-radius: 50%;">
                    <h6>Taha Bezek<br><a href="#">@tahabezek</a></h6>
                  </span>
                  <div class="line-dec"></div>
                  <span class="bid">
                    Yapım Yılı: 2023<br><em>IMDB puanı: 8.3</em><br>Yönetmen: Jason Reitman<br>Oyuncular: Bill Murray, Dan Aykroyd
                  </span>
                  <div class="text-button">
                    <a href="details.html">Fragmanı İzle</a>
                  </div>
              </div>
            </div>
          </div>
          <!-- Diğer Komedi Filmleri -->

          <!-- Gerilim Filmleri -->
          <div class="col-lg-6 currently-market-item all gerilim">
            <div class="item">
              <div class="left-image">
                <img src="assets/images/afisler/sessizgece.jpg" alt="" style="border-radius: 20px; min-width: 195px;">
              </div>
              <div class="right-content">
                <!-- Film Bilgileri -->
                <h4>Sessiz Gece</h4>
                  <span class="author">
                    <img src="assets/images/author.jpg" alt="" style="max-width: 50px; border-radius: 50%;">
                    <h6>Taha Bezek<br><a href="#">@tahabezek</a></h6>
                  </span>
                  <div class="line-dec"></div>
                  <span class="bid">
                    Yapım Yılı: 2023<br><em>IMDB puanı: 8.3</em><br>Yönetmen: Jason Reitman<br>Oyuncular: Bill Murray, Dan Aykroyd
                  </span>
                  <div class="text-button">
                    <a href="details.html">Fragmanı İzle</a>
                  </div>
              </div>
            </div>
          </div>
          <!-- Diğer Gerilim Filmleri -->

          <!-- Macera Filmleri -->
          <div class="col-lg-6 currently-market-item all macera">
            <div class="item">
              <div class="left-image">
                <img src="assets/images/afisler/murat.jpg" alt="" style="border-radius: 20px; min-width: 195px;">
              </div>
              <div class="right-content">
                <!-- Film Bilgileri -->
                <h4>Murat Göğebakan</h4>
                  <span class="author">
                    <img src="assets/images/author.jpg" alt="" style="max-width: 50px; border-radius: 50%;">
                    <h6>Taha Bezek<br><a href="#">@tahabezek</a></h6>
                  </span>
                  <div class="line-dec"></div>
                  <span class="bid">
                    Yapım Yılı: 2023<br><em>IMDB puanı: 8.3</em><br>Yönetmen: Jason Reitman<br>Oyuncular: Bill Murray, Dan Aykroyd
                  </span>
                  <div class="text-button">
                    <a href="details.html">Fragmanı İzle</a>
                  </div>
              </div>
            </div>
          </div>

          
          <!-- Diğer Macera Filmleri -->
        </div>
      </div>
    </div>
  </div>
</div>

  
  
  

  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <p>Copyright © 2023 <a href="#">Movie Map</a> - Tüm Hakları Saklıdır.
        </div>
      </div>
    </div>
  </footer>



  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>

  <script src="assets/js/tabs.js"></script>
  <script src="assets/js/popup.js"></script>
  <script src="assets/js/custom.js"></script>

  </body>
</html>