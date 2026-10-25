<?php
    include("./polaczenie.php");
    $conn = new mysqli("localhost", "root", "", "wypozyczalnia");
    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    $typ_selected = isset($_GET['typ']) ? $conn->real_escape_string($_GET['typ']) : '';
    $marka_selected = isset($_GET['marka']) ? $conn->real_escape_string($_GET['marka']) : '';
    $model_selected = isset($_GET['model']) ? $conn->real_escape_string($_GET['model']) : '';

    $typy = $conn->query("SELECT DISTINCT typ FROM pojazdy");

    $marki = [];
    if ($typ_selected) {
        $marki_query = $conn->query("SELECT DISTINCT marka FROM pojazdy WHERE typ = '$typ_selected'");
        while ($row = $marki_query->fetch_assoc()) {
            $marki[] = $row['marka'];
        }
    } 

    $modele = [];
    if ($marka_selected) {
        $modele_query = $conn->query("SELECT DISTINCT model FROM pojazdy WHERE marka = '$marka_selected'");
        while ($row = $modele_query->fetch_assoc()) {
            $modele[] = $row['model'];
        }
    }

    $where = "";
    if ($model_selected) {
        $where = "WHERE model = '$model_selected'";
    } elseif ($marka_selected) {
        $where = "WHERE marka = '$marka_selected'";
    } elseif ($typ_selected) {
        $where = "WHERE typ = '$typ_selected'";
    }

    $pojazdy = $conn->query("SELECT * FROM pojazdy $where");
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wypożyczalnia pojazdów</title>
    <link rel="stylesheet" href="css/wyszukiwarka.css">
</head>
<body>
    <nav>
        <li><a href="wyszukiwarka.php">Wyszukiwarka pojazdów</a></li>
        <li><a href="rezerwacja.php">Zarezerwuj pojazd</a></li> 
        <li><a href="zwrot.php">Zwrot pojazdu</a></li>
    </nav>
    <main>
        <section class="wyszukiwarka">
                <form method="GET">
                    <div class="typ">
                        <h2>Wybierz typ pojazdu:</h2>
                        <select name="typ" onchange="this.form.submit()">
                            <option value="">Typ pojazdu</option>
                            <?php while ($row = $typy->fetch_assoc()): ?>
                                <option value="<?= $row['typ'] ?>" <?= ($typ_selected == $row['typ']) ? 'selected' : '' ?>>
                                    <?= $row['typ'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="marka">
                        <h2>Wybierz markę pojazdu:</h2>
                        <select name="marka" onchange="this.form.submit()" <?= $typ_selected ? '' : 'disabled' ?>>
                            <option value="">Marka</option>
                            <?php foreach ($marki as $marka): ?>
                                <option value="<?= $marka ?>" <?= ($marka_selected == $marka) ? 'selected' : '' ?>>
                                    <?= $marka ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="model">
                        <h2>Wybierz model pojazdu:</h2>
                        <select name="model" onchange="this.form.submit()" <?= $marka_selected ? '' : 'disabled' ?>>
                            <option value="">Model</option>
                            <?php foreach ($modele as $model): ?>
                                <option value="<?= $model ?>" <?= ($model_selected == $model) ? 'selected' : '' ?>>
                                    <?= $model ?>
                                </option>
                            <?php endforeach; ?>
                        </select>        
                    </div>
                </form>
        </section>
        
        <section class="oferta">
            <h2>Nasze pojazdy:</h2>
            <div class="wyniki">
                <?php if ($pojazdy && $pojazdy->num_rows > 0): ?>
                    <?php while ($pojazd = $pojazdy->fetch_assoc()): ?>
                        <div class="auto">
                            <img src="<?= $pojazd['zdjecie'] ?>" alt="<?= $pojazd['model'] ?>">
                            <h3><?= $pojazd['marka'] ?> <?= $pojazd['model'] ?></h3>
                            <p>Rok produkcji: <?= $pojazd['rok_produkcji'] ?></p>
                            <p>Cena za dzień: <?= number_format($pojazd['cena_za_dzien'], 2) ?> zł</p>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html>
