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
        }

        input, select, button {
            margin-bottom: 10px;
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
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
    </style>
</head>
<body>

<div id="konverter">
    <h2>Konverter Mata Uang</h2>
    <form id="formKonversi">
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

        <button type="button" onclick="konversiMataUang()">Konversi</button>
    </form>

    <div id="hasil"></div>
</div>

<script>
    function konversiMataUang() {
        var jumlah = document.getElementById('jumlah').value;
        var dariMataUang = document.getElementById('dariMataUang').value;
        var keMataUang = document.getElementById('keMataUang').value;

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var respons = JSON.parse(xhr.responseText);
                var hasil = jumlah * respons.rates[keMataUang];
                
                // Menambahkan pemisah ribuan pada hasil konversi
                hasil = hasil.toLocaleString('id-ID', { style: 'currency', currency: keMataUang });

                document.getElementById('hasil').innerHTML = jumlah + ' ' + dariMataUang + ' = ' + hasil;
            }
        };

        var url = 'https://open.er-api.com/v6/latest/' + dariMataUang;
        xhr.open('GET', url, true);
        xhr.send();
    }
</script>

</body>
</html>
