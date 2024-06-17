<?php
    require_once($_SERVER["DOCUMENT_ROOT"]."/core/db.handle.php");
    require($_SERVER["DOCUMENT_ROOT"]."/core/antiXSS.php");

    if(isset($_POST["gondviselo_neve"]) && !empty($_POST["gondviselo_neve"]) && isset($_POST["gondviselo_email"]) && !empty($_POST["gondviselo_email"]) && isset($_POST["gondviselo_telefon"]) && !empty($_POST["gondviselo_telefon"])) {
        $neve = antixss($_POST["gondviselo_neve"]);
        $email = $_POST["gondviselo_email"];
        $telefon = $_POST["gondviselo_telefon"];

        $check = $db->query("SELECT * FROM gondviselo WHERE email='".$email."' AND telefon='".$telefon."'");
        $checkNum = $check->numRows();
        $check = $check->fetchArray();
        if ($checkNum == 0) {
            $token = openssl_random_pseudo_bytes(36);
			$token = bin2hex($token);
			$db->query("insert into gondviselo(nev, password, email, telefon) values('".$neve."', '_token_".$token."', '".$email."', '".$telefon."');");

			$to = $email;
			$subject = "Regisztráció folytatása";
			$message = "<html><head><style>".
                            "a.button {padding: 12px 24px; border: none; background-color: #007BFF; color: white; border-radius: 5px; letter-spacing: 1px; text-align: center; text-decoration: none; display: inline-block; font-size: 1rem; font-weight: bold; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s ease, box-shadow 0.3s ease; } a.button:hover { background-color: #0056b3; box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1); }".
                        "</style></head><body><p>".
                        "<h3>Kedves ".$neve."!</h3>".
                        "A regisztráció majdnem kész!<br>".
                        "Kérjük, kattintson az alábbi gombra a regisztráció befejezéséhez és a gyermeke(i) jelentkezésének kitöltéséhez:<br><br>".
                        "<a href='https://tabor.johires.hu/reg/?t=".$token."' target='_blank' class='button'>Regisztráció befejezése</a>".
                    "</p></body></html>";

			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: <nevalaszolj@johires.hu>' . "\r\n";
			$headers .= 'Bcc: johir.isaszeg@gmail.com' . "\r\n";
			mail($to,$subject,$message,$headers);

            $valasz = "Sikeresen rögzítettük az adatokat! A ".$email." e-mail címre elküldtük a linket, amin keresztül be tudja fejzeni regisztrációt és gyermek(i) adatát is tudja majd rögzíteni. (Ha nem találja az e-mailt, akkor nézze meg a spam mappában is.)";
        } else if (str_starts_with($check["password"], "_token_")) {
            $valasz = "Ezekkel az adatokkal már lett regisztrálva gondviselő. Korábban küldtünk egy e-mailt a(z) ".$email." e-mail címre, a továbbiakban azt keresse. (Lehet, hogy a spam mappába került.)";
        } else{
            $valasz = "Ezekkel az adatokkal már lett regisztrálva gondviselő. Az email már vissza lett igazolva így már csak be kell jelentkeznie.";
        }
    }

    if (isset($_GET["t"])) {
        $t = $_GET["t"];
        $check = $db->query("SELECT * FROM gondviselo WHERE password = '_token_".$t."'");
        $checkNum2 = $check->numRows();
        $check = $check->fetchArray();
    }

    if (isset($_POST["pass"]) && isset($_POST["pass2"]) && isset($_POST["t"])) {
        $pass = $_POST["pass"];
        $pass2 = $_POST["pass2"];
        $t = $_POST["t"];
        if ($pass == $pass2) {
            $db->query("UPDATE gondviselo SET password = '".hash('sha256', 'JÓ'.htmlspecialchars($pass).'HÍR2024')."' WHERE password = '_token_".$t."'");
            header("Location: /login/");
        } else {
            header("Location: /reg/?t=".$t);
        }
    }


require($_SERVER["DOCUMENT_ROOT"]."/pages/tpl/head.php");

if (!isset($checkNum2) || (isset($checkNum2) && $checkNum2 == 0)) {
?>

<main class="regMain">
    <h1>REGISZTRÁCIÓ</h1>
    <p lang="hu">Először regisztrálni kell a gondviselőt, majd a megadott e-mail címre beérkezett linken keresztül lesz lehetőség a gyermek(ek) regisztrációja.</p>
    
    <form class="max-w-sm mx-auto mt-10" action="." method="post">
        <label for="gondviselo_nev">Gondviselő neve:</label>
        <div class="flex mb-4">
            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                </svg>
            </span>
            <input type="text" id="gondviselo_nev" name="gondviselo_neve" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5" placeholder="Minta Név" required>
        </div>

        <label for="gondviselo_email">E-mail címe:</label>
        <div class="flex mb-4">
            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                    <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
                    <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/>
                </svg>
            </span>
            <input type="text" id="gondviselo_email" name="gondviselo_email" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5" placeholder="minta@gmail.com" required>
        </div>
        
        <label for="gondviselo_telefon">Telefonszáma:</label>
        <div class="flex items-center mb-4">
            <div id="dropdown-phone-button" data-dropdown-toggle="dropdown-phone" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg" type="button">
                +36
            </div>
            <div class="relative w-full">
                <input type="text" id="gondviselo_telefon" name="gondviselo_telefon" maxlength="11" inputmode="numeric" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-0 border border-gray-300 focus:ring-blue-500 focus:border-blue-500" pattern="[0-9]{2}-[0-9]{3}-[0-9]{4}" placeholder="30-456-7890" required />
            </div>
        </div>

        <div class="flex" style="justify-content: space-between;">
            <button type="button" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 mb-2" id="vissza">VISSZA</button>
            <button type="submit" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">MEHET</button>
        </div>
    </form>

    <?php
        if (isset($valasz)) {
            echo '<p lang="hu">'.$valasz.'</p>';
        }
    ?>
</main>


<script>
    document.getElementById('gondviselo_telefon').addEventListener('input', (a) => {
        value = a.target.value;
        if (a.data != '-' && isNaN(a.data) || a.data == ' ') a.target.value = value.slice(0,-1);
        if (a.data != null && (value.length == 2 || value.length == 6)) {
            a.target.value = value + '-';
        } else if (a.data == null && (value.length == 2 || value.length == 6)) {
            a.target.value = value.slice(0,-1);
        }
    });

    document.getElementById('vissza').addEventListener('click', () => {
        window.location.href = '/'
    });
</script>
<?php
} else {
?>
<main class="regMain">
    <h1>REGISZTRÁCIÓ</h1>
    <p>Üdv <?php echo $check['nev']; ?>!</p>
    <p lang="hu">Utolsó lépésként adjon meg egy jelszót amit a továbbiakban használni tud a bejelentkezéshez.</p>
    
    <form class="max-w-sm mx-auto mt-10" action="." method="post">
        <label for="gondviselo_email">Jelszó:</label>
        <div class="flex mb-4">
            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md">
                <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" aria-labelledby="title"
                    aria-describedby="desc" role="img" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <path data-name="layer1"
                    d="M53.5 0h-43A10.5 10.5 0 0 0 0 10.5v43A10.5 10.5 0 0 0 10.5 64h43A10.5 10.5 0 0 0 64 53.5v-43A10.5 10.5 0 0 0 53.5 0zm-15 48h-13l2.2-17.1a9 9 0 1 1 8.7 0z"
                    fill="#6B7280"></path>
                </svg>
            </span>
            <input type="password" id="pass" name="pass" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5" placeholder="******">
        </div>
        <label for="gondviselo_email">Jelszó újra:</label>
        <div class="flex mb-4">
            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md">
                <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" aria-labelledby="title"
                    aria-describedby="desc" role="img" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <path data-name="layer1"
                    d="M53.5 0h-43A10.5 10.5 0 0 0 0 10.5v43A10.5 10.5 0 0 0 10.5 64h43A10.5 10.5 0 0 0 64 53.5v-43A10.5 10.5 0 0 0 53.5 0zm-15 48h-13l2.2-17.1a9 9 0 1 1 8.7 0z"
                    fill="#6B7280"></path>
                </svg>
            </span>
            <input type="password" id="pass2" name="pass2" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5" placeholder="******">
        </div>
        <input type="password" name="t" value="<?php echo $t; ?>" style="display: none;">
        <div class="flex" style="justify-content: end;">
            <button type="submit" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">MEHET</button>
        </div>
    </form>
</main>

<script>
    var password = document.getElementById("pass")
    , confirm_password = document.getElementById("pass2");

    function validatePassword(){
        if(password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Nem egyeznek meg a jelszavak!");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>
<?php } ?>