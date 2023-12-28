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

    <title>Filmler</title>

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
                        <li><a href="logged_in.php" >Ana Sayfa</a></li>
                        <li><a href="filmler.php" class="active">Filmler</a></li>
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

  <div class="page-heading">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h6>Movie Map</h6>
          <h2>Öne Çıkan Fİlmler</h2>
          <span>Ana Sayfa> <a href="#">Filmler</a></span>
        </div>
      </div>
    </div>
    <div class="featured-explore">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="owl-features owl-carousel">
              <div class="item">
                <div class="thumb">
                  <img src="assets/images/afisler/maymunlar.jpg" alt="" style="border-radius: 20px;">
                  <div class="hover-effect">
                    <div class="content">
                      <h4>Maymunlar Cehennemi: Yeni Krallık</h4>
                      <span class="author">
                        <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                        <h6>Taha Bezek<br><a href="#">@tahabezek</a></h6>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="thumb">
                  <img src="assets/images/afisler/ataturk1.png" alt="" style="border-radius: 20px;">
                  <div class="hover-effect">
                    <div class="content">
                      <h4>Atatürk 1</h4>
                      <span class="author">
                        <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                        <h6>Elif Yüksek<br><a href="#">@elfyuksek</a></h6>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="thumb">
                  <img src="assets/images/afisler/sobe.jpg" alt="" style="border-radius: 20px;">
                  <div class="hover-effect">
                    <div class="content">
                      <h4>Sobe</h4>
                      <span class="author">
                        <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                        <h6>Taha Bezek<br><a href="#">@tahabezek</a></h6>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="thumb">
                  <img src="assets/images/afisler/ferrari.png" alt="" style="border-radius: 20px;">
                  <div class="hover-effect">
                    <div class="content">
                      <h4>Ferrari</h4>
                      <span class="author">
                        <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                        <h6>Zahit Uyanık<br><a href="#">@uyanikzahit</a></h6>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="discover-items">
    <div class="container">
      <div class="row">
        <div class="col-lg-5">
          <div class="section-heading">
            <div class="line-dec"></div>
            <h2>Önerilen <em>Filmler</em></h2>
          </div>
        </div>
        <div class="col-lg-7">
          <form id="search-form" name="gs" method="submit" role="search" action="#">
        
          </form>
        </div>
          <div class="col-lg-3">
            <div class="item">
              <div class="row">
                <div class="col-lg-12">
                  <span class="author">
                    <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                  </span>
                  <img src="assets/images/afisler/sagsalim.jpg" alt="" style="border-radius: 20px;">
                  <h4>Sağ Salim 3</h4>
                </div>
                <div class="col-lg-12">
                  <div class="line-dec"></div>
                  <div class="row">
                    <div class="col-6">
                      <span>Yapım Yılı: <br> <strong>2023</strong></span>
                    </div>
                    <div class="col-6">
                      <span>Kategori:<br><strong>Komedi</strong></span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="main-button">
                    <a href="details.html">Fragmanı İzle</a>
                  </div>
                </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="item">
            <div class="row">
              <div class="col-lg-12">
                <span class="author">
                  <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                </span>
                <img src="assets/images/afisler/demon.png" alt="" style="border-radius: 20px;">
                <h4>Demon</h4>
              </div>
              <div class="col-lg-12">
                <div class="line-dec"></div>
                <div class="row">
                  <div class="col-6">
                    <span>Yapım Yılı: <br> <strong>2023</strong></span>
                  </div>
                  <div class="col-6">
                    <span>Kategori:<br><strong>Korku</strong></span>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="main-button">
                  <a href="details.html">Fragmanı İzle</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="item">
            <div class="row">
              <div class="col-lg-12">
                <span class="author">
                  <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                </span>
                <img src="assets/images/afisler/tetikci.jpg" alt="" style="border-radius: 20px;">
                <h4>Tetikçi</h4>
              </div>
              <div class="col-lg-12">
                <div class="line-dec"></div>
                <div class="row">
                  <div class="col-6">
                    <span>Yapım Yılı: <br> <strong>2023</strong></span>
                  </div>
                  <div class="col-6">
                    <span>Kategori:<br><strong>Aksiyon</strong></span>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="main-button">
                  <a href="details.html">Fragmanı İzle</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="item">
            <div class="row">
              <div class="col-lg-12">
                <span class="author">
                  <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                </span>
                <img src="assets/images/afisler/madmax.jpg" alt="" style="border-radius: 20px;">
                <h4>Furiosa a Mad Max Saga</h4>
              </div>
              <div class="col-lg-12">
                <div class="line-dec"></div>
                <div class="row">
                  <div class="col-6">
                    <span>Yapım Yılı: <br> <strong>2023</strong></span>
                  </div>
                  <div class="col-6">
                    <span>Kategori:<br><strong>Macera</strong></span>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="main-button">
                  <a href="details.html">Fragmanı İzle</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="item">
            <div class="row">
              <div class="col-lg-12">
                <span class="author">
                  <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                </span>
                <img src="assets/images/afisler/kolpacino.jpg" alt="" style="border-radius: 20px;">
                <h4>Kolpaçino 4</h4>
              </div>
              <div class="col-lg-12">
                <div class="line-dec"></div>
                <div class="row">
                  <div class="col-6">
                    <span>Yapım Yılı: <br> <strong>2023</strong></span>
                  </div>
                  <div class="col-6">
                    <span>Kategori:<br><strong>Komedi</strong></span>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="main-button">
                  <a href="details.html">Fragmanı İzle</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="item">
            <div class="row">
              <div class="col-lg-12">
                <span class="author">
                  <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                </span>
                <img src="assets/images/afisler/napolyon.jpg" alt="" style="border-radius: 20px;">
                <h4>Napolyon</h4>
              </div>
              <div class="col-lg-12">
                <div class="line-dec"></div>
                <div class="row">
                  <div class="col-6">
                    <span>Yapım Yılı: <br> <strong>2023</strong></span>
                  </div>
                  <div class="col-6">
                    <span>Kategori:<br><strong>Biyografi Tarihi</strong></span>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="main-button">
                  <a href="details.html">Fragmanı İzle</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="item">
            <div class="row">
              <div class="col-lg-12">
                <span class="author">
                  <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                </span>
                <img src="assets/images/afisler/beekepper.jpg" alt="" style="border-radius: 20px;">
                <h4>The Beekeeper</h4>
              </div>
              <div class="col-lg-12">
                <div class="line-dec"></div>
                <div class="row">
                  <div class="col-6">
                    <span>Yapım Yılı: <br> <strong>2023</strong></span>
                  </div>
                  <div class="col-6">
                    <span>Kategori:<br><strong>Aksiyon</strong></span>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="main-button">
                  <a href="details.html">Fragmanı İzle</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="top-seller">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <div class="line-dec"></div>
                    <h2>En çok beğenilen filmler</h2>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="item">
                            <h4>1.</h4>
                            <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                            <h6>Esaretin Bedeli<br><a href="#">Yapım yılı: 1994, Kategori: Dram</a></h6>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="item">
                            <h4>2.</h4>
                            <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                            <h6>Yeşil Yol<br><a href="#">Yapım yılı: 1999, Kategori: Dram</a></h6>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="item">
                            <h4>3.</h4>
                            <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                            <h6>The Godfather<br><a href="#">Yapım yılı: 1999, Kategori: Suç, Mafya</a></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="item">
                            <h4>4.</h4>
                            <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                            <h6>Paralel Evrenler<br><a href="#">Yapım yılı: 2004, Kategori: Bilim Kurgu</a></h6>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="item">
                            <h4>5.</h4>
                            <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                            <h6>Gladyatör<br><a href="#">Yapım yılı: 2000, Kategori: Aksiyon</a></h6>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="item">
                            <h4>6.</h4>
                            <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                            <h6>Yüzüklerin Efendisi: Yüzük Kardeşliği<br><a href="#">Yapım yılı: 2001, Kategori: Fantastik</a></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="item">
                            <h4>7.</h4>
                            <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                            <h6>Batman Başlıyor<br><a href="#">Yapım yılı: 2005, Kategori: Aksiyon</a></h6>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="item">
                            <h4>8.</h4>
                            <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                            <h6>Interstellar<br><a href="#">Yapım yılı: 2014, Kategori: Bilim Kurgu</a></h6>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="item">
                            <h4>9.</h4>
                            <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                            <h6>Prestij<br><a href="#">Yapım yılı: 2006, Kategori: Dram</a></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="item">
                            <h4>10.</h4>
                            <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                            <h6>Departed<br><a href="#">Yapım yılı: 2006, Kategori: Polisiye</a></h6>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="item">
                            <h4>11.</h4>
                            <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                            <h6>Schindler'in Listesi<br><a href="#">Yapım yılı: 1993, Kategori: Tarih</a></h6>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="item">
                            <h4>12.</h4>
                            <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                            <h6>Matrix<br><a href="#">Yapım yılı: 1999, Kategori: Bilim Kurgu</a></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <p>Copyright © 2023 <a href="#">Movie Map</a> - Tüm Hakları Saklıdır.</p>
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