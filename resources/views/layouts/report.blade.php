<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Of Materials</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Arial, sans-serif;
            color: #555;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 14px;
            line-height: 20px;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: center;
        }
        .invoice-box table tr td:nth-child(3),
        .invoice-box table tr td:nth-child(4) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.heading td {
            background: #435ebe;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            padding: 10px 5px;
            color: white;
        }
        /* Set column widths */
        .invoice-box table tr.heading td:nth-child(1) {
            width: 40%;
        }
        .invoice-box table tr.heading td:nth-child(2) {
            width: 15%;
        }
        .invoice-box table tr.heading td:nth-child(3),
        .invoice-box table tr.heading td:nth-child(4) {
            width: 22.5%;
        }
        .invoice-box table tr.item td {
            padding: 10px 5px;
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        .header-section {
            display: flex;
            justify-content: space-between;
            padding-bottom: 20px;
        }
        .header-section img {
            max-width: 100px;
        }
        .header-section div {
            text-align: right;
        }
        .total-row {
            text-align: right;
            font-weight: bold;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header-section">
            <div>
                <img src="{{ asset('./assets/compiled/png/icon.png') }}" alt="Logo">
            </div>
            <div>
                <h2>BOM Report</h2>
                Date: 12/10/2024<br>
                BOM Code: A001
            </div>
        </div>
        
        <table>
            <tr class="heading">
                <td>Product Name</td>
                <td>Quantity</td>
                <td>Product Cost</td>
                <td>BoM Cost</td>
            </tr>
            
            <tr class="item">
                <td>Angsle</td>
                <td>1</td>
                <td>Rp 20.000</td>
                <td>Rp 15.000</td>
            </tr>
        </table>

        <div class="total-row">
            <p><strong>Total BoM Cost:</strong> Rp15.000</p>
            <p><strong>Total Product Cost:</strong> Rp20.000</p>
        </div>
    </div>
</body>
</html>
