<?php
    $conn = new mysqli("localhost", "root", "", "wypozyczalnia");
    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['zwracanie'])) {
        $id_wypozyczenia = intval($_POST['id_wypozyczenia']);
        $data_zwrotu = $conn->real_escape_string($_POST['rzeczywista_data_zwrotu']);

        $query = "UPDATE wypozyczenia SET rzeczywista_data_zwrotu = '$data_zwrotu', status = 'zwrócony' WHERE id_wypozyczenia = $id_wypozyczenia";
        $conn->query($query);
    }

    $klienci = $conn->query("SELECT id_klienta, imie, nazwisko FROM klienci");

    $wypozyczenia = [];
    $id_klienta = null;
    if (isset($_POST['szukaj']) && isset($_POST['id_klienta'])) {
        $id_klienta = intval($_POST['id_klienta']);

        $query = "SELECT id_wypozyczenia, data_wypozyczenia, data_zwrotu, status, rzeczywista_data_zwrotu FROM wypozyczenia WHERE id_klienta = $id_klienta";
        $wypozyczenia = $conn->query($query);
    }
?>



<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wypozyczalnia pojazdów</title>
    <link rel="stylesheet" href="css/zwrot.css">
</head>
<body>
    <nav>
        <li><a href="wyszukiwarka.php">Wyszukiwarka pojazdów</a></li>
        <li><a href="rezerwacja.php">Zarezerwuj pojazd</a></li> 
        <li><a href="zwrot.php">Zwrot pojazdu</a></li>
    </nav>
    <main>
        <section>
        <h2>Wybierz klienta</h2><br>
            <form method="POST" class="klient">
                <select name="id_klienta" required>
                    <option value="">Klienci</option>
                    <?php while ($row = $klienci->fetch_assoc()): ?>
                        <option value="<?= $row['id_klienta'] ?>" <?= ($id_klienta == $row['id_klienta']) ? 'selected' : '' ?>>
                            <?= $row['imie'] . " " . $row['nazwisko'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <button type="submit" name="szukaj">Szukaj</button>
            </form>
        <section>


        </section class="wypozyczenia">
            <?php if (!empty($wypozyczenia) && $wypozyczenia->num_rows > 0): ?>
                <h2>Wypożyczenia:</h2>
                    <?php while ($w = $wypozyczenia->fetch_assoc()): ?>
                        <form method="POST">
                            <div class="wypozyczenie">
                                <div class="wypozyczenie1">
                                    <p>Data wypożyczenia: <?= $w['data_wypozyczenia'] ?></p><br>
                                    <p>Data zwrotu: <?= $w['data_zwrotu'] ?></p>
                                </div>
                                <div class="wypozyczenie2">
                                    <p>Status: <?= $w['status'] ?></p><br>
                                    <div>
                                        <p>Rzeczywista data zwrotu:</p>
                                        <?php if ($w['status'] === 'wypożyczony'): ?>
                                            <input type="hidden" name="id_wypozyczenia" value="<?= $w['id_wypozyczenia'] ?>">
                                            <input type="hidden" name="id_klienta" value="<?= $id_klienta ?>">
                                            <input type="date" name="rzeczywista_data_zwrotu" required>
                                    </div>
                                </div>
                            </div>
                            <div class="zwroc">
                                <button type="submit" name="zwracanie">Zwróć</button>
                            </div>
                        </form>
                        <?php else: ?>
                            <p><?= $w['rzeczywista_data_zwrotu'] ?></p>
                        <?php endif; ?>
                    <?php endwhile; ?>
            <?php elseif (isset($_POST['szukaj'])): ?>
                <p>Brak wypożyczeń dla wybranego klienta.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>