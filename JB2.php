<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konverter Mata Uang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #konverter {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input, select, button {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        button {
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        #hasil {
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php
    function konversiMataUang($jumlah, $dariMataUang, $keMataUang) {
        $url = 'https://open.er-api.com/v6/latest/' . $dariMataUang;
        $data = file_get_contents($url);
        $respons = json_decode($data);

        if ($respons && isset($respons->rates->{$keMataUang})) {
            $hasil = $jumlah * $respons->rates->{$keMataUang};
            $hasil = number_format($hasil, 2, ',', '.');
            return $jumlah . ' ' . $dariMataUang . ' = ' . $hasil . ' ' . $keMataUang;
        } else {
            return 'Data kurs tidak valid.';
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $jumlah = $_POST['jumlah'];
        $dariMataUang = $_POST['dariMataUang'];
        $keMataUang = $_POST['keMataUang'];

        $hasilKonversi = konversiMataUang($jumlah, $dariMataUang, $keMataUang);
    }
?>

<div id="konverter">
    <h2>Konverter Mata Uang</h2>
    <form method="post">
        <label for="jumlah">Jumlah:</label>
        <input type="number" id="jumlah" name="jumlah" step="0.01" required>

        <label for="dariMataUang">Dari Mata Uang:</label>
        <select id="dariMataUang" name="dariMataUang" required>
            <option value="USD">USD (Dolar Amerika)</option>
            <option value="MYR">MYR (Ringgit Malaysia)</option>
            <option value="SAR">SAR (Riyal Arab Saudi)</option>
            <option value="EUR">EUR (Euro)</option>
        </select>

        <label for="keMataUang">Ke Mata Uang:</label>
        <select id="keMataUang" name="keMataUang" required>
            <option value="IDR">IDR (Rupiah Indonesia)</option>
        </select>

        <button type="submit">Konversi</button>
    </form>

    <?php
        if (isset($hasilKonversi)) {
            echo '<div id="hasil">' . $hasilKonversi . '</div>';
        }
    ?>
</div>

</body>
</html>
