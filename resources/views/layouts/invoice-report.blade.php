<!DOCTYPE html>
<html>

<head>
    <title>Quotation </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .total {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>

<body>
    <h1>Quotation {{ $invoice->id }}</h1>
    <p><strong>Customer:</strong> </p>
    <p><strong>Expiration Date:</strong> </p>
    <p><strong>Status:</strong> </p>

    <h3>Products:</h3>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
           
                <tr>
                    <td></td>
                    <td></td>
                    <td>Rp. </td>
                    <td>Rp. </td>
                </tr>
           
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Grand Total:</td>
                <td class="total">Rp. </td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
