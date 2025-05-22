<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roman Konversi</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            transition: transform 0.3s;
        }
        .container:hover {
            transform: scale(1.05);
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }
        input {
            width: 85%;
            padding: 12px;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 18px;
            text-align: center;
            outline: none;
            transition: border 0.3s;
        }
        input:focus {
            border-color: #007bff;
        }
        button {
            width: 90%;
            padding: 12px;
            margin-top: 15px;
            border: none;
            background: #007bff;
            color: white;
            font-size: 18px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }
        button:hover {
            background: #0056b3;
            transform: scale(1.05);
        }
        .box {
            margin-top: 20px;
            padding: 15px;
            border-radius: 10px;
            font-size: 22px;
            font-weight: bold;
            color: #007bff;
            background: #f8f9fa;
            border: 1px solid #ccc;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Roman Konversi</h1>
        <input type="text" id="numberInput" placeholder="Masukkan sebuah angka">
        <button onclick="convertToRoman()">Konversi</button>
        <div class="box" id="output">Hasil</div>
    </div>

    <script>
        function convertToRoman() {
            const num = document.getElementById("numberInput").value;
            const output = document.getElementById("output");

            if (!/^[1-9]\d*$/.test(num) || num < 1 || num > 9999) {
                output.innerHTML = "Masukkan nomor yang valid";
                output.style.color = "red";
                return;
            }

            const romanNumerals = [
                { value: 1000, symbol: "M" },
                { value: 900, symbol: "CM" },
                { value: 500, symbol: "D" },
                { value: 400, symbol: "CD" },
                { value: 100, symbol: "C" },
                { value: 90, symbol: "XC" },
                { value: 50, symbol: "L" },
                { value: 40, symbol: "XL" },
                { value: 10, symbol: "X" },
                { value: 9, symbol: "IX" },
                { value: 5, symbol: "V" },
                { value: 4, symbol: "IV" },
                { value: 1, symbol: "I" }
            ];

            let result = "";
            let number = parseInt(num);

            for (const numeral of romanNumerals) {
                while (number >= numeral.value) {
                    result += numeral.symbol;
                    number -= numeral.value;
                }
            }

            output.innerHTML = `Roman: <strong>${result}</strong>`;
            output.style.color = "#007bff";

        }
    </script>
</body>
</html>
