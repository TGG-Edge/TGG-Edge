<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Receipt #{{ $receipt->receipt_number }}</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
            color: #000;
        }

        .receipt-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .receipt-sidebar {
            width: 25%;
            background-color: #e8f1fb;
            padding: 30px 20px;
            text-align: center;
        }

        .receipt-sidebar h5 {
            background-color: #0b4da2;
            color: #fff;
            padding: 10px 0;
            margin-bottom: 20px;
            font-size: 16px;
            letter-spacing: 1px;
        }

        .receipt-sidebar img {
            width: 80px;
            margin: 15px 0;
        }

        .company-info {
            font-size: 13px;
            line-height: 1.6;
        }

        /* Main Body */
        .receipt-body {
            width: 75%;
            padding: 40px;
            box-sizing: border-box;
        }

        .d-flex {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .mb-3 { margin-bottom: 15px; }
        .mb-4 { margin-bottom: 25px; }
        .mt-5 { margin-top: 50px; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        table th {
            background-color: #0b4da2;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .fw-bold { font-weight: bold; }

        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            margin-left: auto;
            margin-top: 5px;
        }

        .amount-section {
            margin-top: 20px;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="receipt-container">
    <!-- Sidebar -->
    <div class="receipt-sidebar">
        <h5>RECEIPT</h5>
        <img src="{{ public_path('images/tgg-logo.png') }}" alt="Company Logo">
        <div class="company-info">
            <p><strong>TGG Eco Ventures Pvt. Ltd.</strong></p>
            <p>#577, 1st Floor<br>
                27th Main 13th Cross,<br>
                Sector-1, HSR Layout<br>
                Bangalore-560102,<br>
                Karnataka, India</p>
            <p>office@tggindia.com</p>
        </div>
    </div>

    <!-- Main Body -->
    <div class="receipt-body">
        <div class="d-flex mb-3">
            <div>
                <p><strong>DATE:</strong> {{ $receipt->created_at?->format('d M, Y') ?? 'N/A' }}</p>
                <p><strong>RECEIPT NO:</strong> {{ $receipt->receipt_number }}</p>
            </div>
        </div>

        <div class="mb-4">
            <p><strong>TO</strong><br>
                <strong>{{ $receipt->target?->name ?? 'Name' }}</strong><br>
                {{ $receipt->target?->address ?? 'Address' }}<br>
                {{ $receipt->target?->phone ?? '' }} {{ $receipt->target?->email ? '/ ' . $receipt->target?->email : '' }}
            </p>
        </div>

        @php
            $items = $receipt->items ?? [];
            $totalAmount = 0;
            foreach ($items as $item) {
                $totalAmount += floatval($item['amount'] ?? 0);
            }
        @endphp

        <table>
            <thead>
                <tr>
                    <th>DESCRIPTION</th>
                    <th>AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td>{{ $item['description'] ?? 'N/A' }}</td>
                        <td>{{ number_format($item['amount'] ?? 0, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2">No items added</td></tr>
                @endforelse
                <tr>
                    <td class="text-end fw-bold">Received</td>
                    <td>{{ number_format($totalAmount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        @php
            $totalAmount = floatval($totalAmount ?? 0);
            if (class_exists(\NumberFormatter::class)) {
                $formatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
                $integerPart = (int) floor($totalAmount);
                $fractionPart = (int) round(($totalAmount - $integerPart) * 100);
                $wordsInteger = $integerPart > 0 ? $formatter->format($integerPart) : 'zero';
                $wordsFraction = $fractionPart > 0 ? $formatter->format($fractionPart) . ' paise' : '';
                $combined = trim($wordsInteger . ($wordsFraction ? ' and ' . $wordsFraction : ''));
                $amountInWords = ucwords($combined) . ' only';
            } else {
                $amountInWords = number_format($totalAmount, 2) . ' INR only';
            }
        @endphp

        <div class="amount-section">
            <p><strong>Amount in words:</strong> {{ $amountInWords }}</p>
        </div>

        <div class="text-end mt-5">
            <p>Company Signature</p>
            <div class="signature-line"></div>
        </div>
    </div>
</div>

</body>
</html>
