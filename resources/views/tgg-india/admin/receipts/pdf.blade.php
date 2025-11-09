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
            width: 220px; /* match the first screenshot width */
            background-color: #D0E1F3;
            padding: 10px;
            margin: 20px;
            text-align: center;
        }

        .receipt-sidebar h5 {
            background-color: #1155cc;
            color: #fff;
            padding: 50px 0;
            margin: 0;
            font-size: 16px;
            letter-spacing: 1px;
        }

        .receipt-sidebar img {
            width: 60px;
            margin: 20px 0;
        }

        .company-info {
            font-size: 12px;
            line-height: 1.4;
            color: #797979ff;
            padding: 0 15px 20px 15px;
        }

        /* Main Body */
        .receipt-body {
            flex: 1;
            padding: 40px 50px;
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
            margin-bottom: 20px;
        }

        table th {
            background-color: #0b4da2;
            color: #fff;
            padding: 10px;
            text-align: left;
        }

        table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        table td.amount {
            text-align: right;
        }

        .text-end {
            text-align: right;
        }

        .fw-bold { font-weight: bold; }

        /* .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            margin-left: auto;
            margin-top: 5px;
        } */
        
        .signature-line1 {
            border-top: 1px solid #c6c6c6ff;
            width: 170px;
            margin-left: auto;
            margin-top: -6px;
        }

        .signature-line {
            border-top: 1px solid #c6c6c6ff;
            width: 130px;
            margin-top: -6px;
            margin-right:740px;
        }

        .amount-section {
            margin-top: 10px;
            font-size: 13px;
        }

        .date-receipt{
            margin-left:700px;
        }

        .comp{
            margin-right:775px !important;
        }

        .sign{
            margin-top:130px;
        }

    </style>
</head>
<body>

<div class="receipt-container">
    <!-- Sidebar -->
    <div class="receipt-sidebar">
        <h5>RECEIPT</h5>
        <img src="{{ asset('assets/tgg-india/images/tgg-india-fav.jpg') }}" alt="Company Logo">
        <div class="company-info">
            <strong>TGG Eco Ventures Pvt. Ltd.</strong><br>
            <br/>
            #677, 1st Floor<br>
            27th Main 13th Cross,<br>
            Sector-1, HSR Layout<br>
            Bangalore-560102,<br>
            Karnataka, India<br>
            office@tggindia.com
        </div>
    </div>

    <!-- Main Body -->
    <div class="receipt-body">
        <div class="d-flex mb-3 date-receipt">
            <div>
                <p><strong>DATE:</strong> {{ $receipt->created_at?->format('d M, Y') ?? 'N/A' }}</p>
                <div class="signature-line1"></div>
                <p><strong>RECEIPT NO:</strong> {{ $receipt->receipt_number }}</p>
                <div class="signature-line1"></div>
            </div>
        </div>

        <div class="mb-4">
            <p><strong>TO</strong>
            <div class="signature-line"></div>
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

       <table style="width:100%; border-collapse: collapse; font-family: 'Poppins', sans-serif;">
    <thead>
        <tr style="background-color:#1966d2; color:white; text-align:left; height:30px;">
            <th style="padding:5px 10px; border:1px solid #ccc;">DESCRIPTION</th>
            <th style="padding:5px 10px; border:1px solid #ccc;">AMOUNT</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($items as $item)
            <tr>
                <td style="padding:5px 10px; border:1px solid #ccc;">{{ $item['description'] ?? 'N/A' }}</td>
                <td style="padding:5px 10px; border:1px solid #ccc; text-align:right;">{{ number_format($item['amount'] ?? 0, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2" style="padding:5px 10px; border:1px solid #ccc; background-color:#f2f2f2;">No items added</td>
            </tr>
        @endforelse
        <tr>
            <td style="padding:5px 10px; text-align:right; font-weight:bold; border:1px solid #ccc;">Received</td>
            <td style="padding:5px 10px; border:1px solid #ccc; background-color:#dbe9f8; text-align:right;">{{ number_format($totalAmount, 2) }}</td>
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

        <div class="text-end mt-5 sign">
            <p class='comp'>Company Signature</p>
            <div class="signature-line"></div>
        </div>
    </div>
</div>

</body>
</html>
