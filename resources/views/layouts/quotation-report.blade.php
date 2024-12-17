<!DOCTYPE html>
<html>

<head>
    <title>Quotation {{ $quotation->code }}</title>
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
    <h1>Quotation {{ $quotation->code }}</h1>
    <p><strong>Customer:</strong> {{ $quotation->customer->name }}</p>
    <p><strong>Expiration Date:</strong> {{ $quotation->expDate }}</p>
    <p><strong>Status:</strong> {{ $quotation->status_text }}</p>

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
            @foreach ($details as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>Rp. {{ number_format($detail->price, 2) }}</td>
                    <td>Rp. {{ number_format($detail->qty * $detail->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Grand Total:</td>
                <td class="total">Rp. {{ number_format($grandTotal, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
