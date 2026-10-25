<?php
$mysqli = new mysqli("localhost", "root", "", "wypozyczalnia");
$komunikat = "";
$id_klienta = null;

$klienci = $mysqli->query("SELECT id_klienta, imie, nazwisko FROM klienci ORDER BY nazwisko, imie");

if (isset($_POST['klient_submit'])) {
    if (!empty($_POST['istniejacy_klient'])) {
        $id_klienta = mysqli_real_escape_string($mysqli, $_POST['istniejacy_klient']);
        $komunikat = "Wybrano istniejącego klienta.";
    } 
    else {
        $imie = mysqli_real_escape_string($mysqli, $_POST['imie']);
        $nazwisko = mysqli_real_escape_string($mysqli, $_POST['nazwisko']);
        $email = mysqli_real_escape_string($mysqli, $_POST['email']);
        $telefon = mysqli_real_escape_string($mysqli, $_POST['telefon']);

        $sql = "INSERT INTO klienci (imie, nazwisko, email, telefon) 
                VALUES ('$imie', '$nazwisko', '$email', '$telefon')";
        if ($mysqli->query($sql)) {
            $id_klienta = $mysqli->insert_id;
            $komunikat = "Nowy klient został zapisany.";
        } else {
            $komunikat = "Błąd przy dodawaniu klienta.";
        }
    } 
}

if (isset($_POST['rezerwacja_submit'])) {
    $marka = mysqli_real_escape_string($mysqli, $_POST['marka']);
    $model = mysqli_real_escape_string($mysqli, $_POST['model']);
    $data_wypozyczenia = mysqli_real_escape_string($mysqli, $_POST['data_wypozyczenia']);
    $data_zwrotu = mysqli_real_escape_string($mysqli, $_POST['data_zwrotu']);
    $id_klienta = mysqli_real_escape_string($mysqli, $_POST['id_klienta']);

    $result = $mysqli->query("SELECT id FROM pojazdy WHERE model = '$model'");
    if ($row = $result->fetch_assoc()) {
        $id_pojazdu = $row['id'];

        $check = $mysqli->query("SELECT COUNT(*) as liczba FROM wypozyczenia 
                                 WHERE id_pojazdu = $id_pojazdu AND status = 'wypożyczony'");
        $countRow = $check->fetch_assoc();

        if ($countRow['liczba'] > 0) {
            $komunikat = "Ten pojazd został już wypożyczony.";
        } else {
            $sql = "INSERT INTO wypozyczenia (id_pojazdu, id_klienta, data_wypozyczenia, data_zwrotu, status)
                    VALUES ($id_pojazdu, $id_klienta, '$data_wypozyczenia', '$data_zwrotu', 'wypożyczony')";
            if ($mysqli->query($sql)) {
                $komunikat = "Rezerwacja została zapisana.";
            } else {
                $komunikat = "Błąd przy zapisie rezerwacji.";
            }
        }
    } else {
        $komunikat = "Nie znaleziono pojazdu o wybranym modelu.";
    }
}
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wypożyczalnia pojazdów</title>
    <link rel="stylesheet" href="css/rezerwacja.css">
</head>
<body>
    <nav>
        <li><a href="wyszukiwarka.php">Wyszukiwarka pojazdów</a></li>
        <li><a href="rezerwacja.php">Zarezerwuj pojazd</a></li> 
        <li><a href="zwrot.php">Zwrot pojazdu</a></li>
    </nav>
    <main>
        <h1>Wybierz istniejącego klienta albo stwórz nowego</h1><br>
        <form method="POST">
            <section class="klient">
                <div class="klient1">
                    <h2>Istniejący klienci</h2>
                    <select name="istniejacy_klient">
                        <option value="">Klienci</option>
                        <?php while ($klient = $klienci->fetch_assoc()): ?>
                            <option value="<?= $klient['id_klienta'] ?>">
                                <?= htmlspecialchars($klient['imie'] . ' ' . $klient['nazwisko']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="klient2">
                    <h2>Imię</h2><br>
                    <input type="text" name="imie">
                    <h2>Nazwisko</h2><br>
                    <input type="text" name="nazwisko">
                </div>
                <div class="klient3">
                    <h2>Email</h2><br>
                    <input type="email" name="email">
                    <h2>Numer telefonu</h2><br>
                    <input type="tel" name="telefon">
                </div>
            </section><br>
            <div id="wyslij">
                <button type="submit" name="klient_submit">Wyślij</button>
            </div>
        </form>

        <?php if ($id_klienta): ?>
            <br><h1>Wypełnij formularz rezerwacji</h1><br>
            <form method="POST">
                <section class="wypozyczenie">

                    <div class="wypoz1">
                        <h2>1. Wybierz markę pojazdu:</h2><br>
                        <select name="marka" id="marka" required onchange="aktualizujModele()">
                            <option value="">Marka</option>
                            <option value="Dodge">Dodge</option>
                            <option value="Mercedes">Mercedes</option>
                            <option value="Toyota">Toyota</option>
                            <option value="Volkswagen">Volkswagen</option>
                            <option value="Peugeot">Peugeot</option>
                            <option value="Citroen">Citroen</option>
                            <option value="Honda">Honda</option>
                            <option value="Suzuki">Suzuki</option>
                            <option value="Junak">Junak</option>
                        </select><br>
    
                        <h2>2. Wybierz model pojazdu:</h2><br>
                        <select name="model" id="model" required>
                            <option value="">Model</option>
                        </select><br>           
                    </div>
    
                    <div class="wypoz2">
                        <h2>3. Data wypożyczenia</h2>
                        <input class="data" type="date" name="data_wypozyczenia" required><br>
                        <h2>4. Data zwrotu</h2>
                        <input class="data" type="date" name="data_zwrotu" required>
                    </div>
                </section>
                <input type="hidden" name="id_klienta" value="<?php echo $id_klienta; ?>">
                <div id="wyslij">
                    <button type="submit" name="rezerwacja_submit">Wyślij</button>
                </div>
            </form>

            <script>
                const modelePojazdow = {
                    "Dodge": ["Charger", "Challenger Shaker Widebody", "Durango 5,7 R/T"],
                    "Mercedes": ["A 180 AMG Line", "S 500 4MATIC", "GLE 400d Coupe"],
                    "Toyota": ["Supra GR 3.0", "Corolla Hybrid", "Land Cruiser V8"],
                    "Volkswagen": ["Crafter Furgon", "Transporter T6.1", "Caddy Cargo Maxi"],
                    "Peugeot": ["Boxer Furgon L3H2", "Expert Long", "Partner Van"],
                    "Citroen": ["Jumper L3H2 2.2 HDi", "Berlingo Van 1.5 BlueHDi", "Jumpy 2.0 BlueHDi XL"],
                    "Honda": ["PCX125", "Forza125", "SH125i"],
                    "Suzuki": ["Address 110", "Burgman 125", "Lets 125"],
                    "Junak": ["N-125", "City 125", "Eco 125"]
                };

                function aktualizujModele() {
                    const marka = document.getElementById("marka").value;
                    const modelSelect = document.getElementById("model");

                    modelSelect.innerHTML = "";

                    if (marka && modelePojazdow[marka]) {
                        modelePojazdow[marka].forEach(model => {
                            const option = document.createElement("option");
                            option.value = model;
                            option.text = model;
                            modelSelect.appendChild(option);
                        });
                    } else {
                        const defaultOption = document.createElement("option");
                        defaultOption.text = "-- Najpierw wybierz markę --";
                        defaultOption.value = "";
                        modelSelect.appendChild(defaultOption);
                    }
                }
            </script>
        <?php endif; ?>

        <?php if ($komunikat): ?>
            <p class="komunikat"><strong><?php echo $komunikat; ?></strong></p>
        <?php endif; ?>
    </main>
</body>
</html>