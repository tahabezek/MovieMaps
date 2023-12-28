<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* otomatik kayıttan kullanıcı seçince beyaz renk olmasını engelleme */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #333333 inset !important; /* Arka plan rengi */
            -webkit-text-fill-color: #f9ca9c !important; /* Metin rengi */
        }

        /* Diğer tarayıcılar için otomatik doldurulan değerleri grileştir */
        input:-internal-autofill-selected {
            background-color: #333333 !important; /* Arka plan rengi */
            color: #f9ca9c !important; /* Metin rengi */
        }
        body {
            font-family: 'Helvetica', sans-serif;
            background-color: #1e1e1e;
            color: #f9ca9c;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            color: #f9ca9c;
            font-size: 40px;
        }

        .container {
            background-color: #292929;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 12px;
            color: #f9ca9c;
        }

        input {
            padding: 13px;
            margin-bottom: 15px;
            border: 2px solid #f9ca9c;
            border-radius: 8px;
            width: 100%;
            background-color: #333333;
            color: #f9ca9c;
            box-sizing: border-box;
        }

        button {
            padding: 13px;
            background-color: #292929;
            color: #f9ca9c;
            border: 2px solid #f9ca9c;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #1a1a1a;
        }

        .error-message {
            color: red;
            margin-top: 10px;
            width: 100%;
            text-align: center;
        }
    </style>
    <title>Üye Kayıt</title>
</head>

<body>

    <div class="header">
        <h2>Movie Map</h2>
        <p>Filmlerin gizemli dünyasını keşfetmek için hemen kayıt olun!</p>
    </div>

    <div class="container">
        <h1>Üye Kayıt</h1>
        <form id="registrationForm" action="kayit.php" method="post">

            <label for="username"><b>Kullanıcı Adı</b></label>
            <input type="text" id="username" name="username" required>

            <label for="email"><b>E-posta Adresi</b></label>
            <input type="email" id="email" name="email" required>

            <label for="password"><b>Şifre</b></label>
            <input type="password" id="password" name="password" pattern="^(?=.*[A-Z])(?=.*\d).*$"
                title="En az bir büyük harf ve bir sayı içermelidir" required>

            <label for="confirm-password"><b>Şifre Onayla</b></label>
            <input type="password" id="confirm-password" name="confirm-password" required>

            <button type="button" onclick="validateAndSubmit()">Kayıt Ol</button>

            <div class="error-message" id="error-message"></div>
        </form>
    </div>

    <script>
        function validateAndSubmit() {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm-password').value;

            if (password !== confirmPassword) {
                document.getElementById('error-message').innerHTML = 'Şifreler uyuşmuyor.';
            } else {
                var pattern = /^(?=.*[A-Z])(?=.*\d).*$/;
                if (!pattern.test(password)) {
                    document.getElementById('error-message').innerHTML = 'Şifre en az bir büyük harf ve bir sayı içermelidir.';
                } else {
                    document.getElementById('error-message').innerHTML = '';
                    document.getElementById('registrationForm').submit();
                }
            }
        }
    </script>
</body>

</html>
