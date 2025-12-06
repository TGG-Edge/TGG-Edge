<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            color: #000;
        }
        .container {
            width: 95%;
            margin: auto;
        }
        .header-table, .table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: top;
        }
        .header-table .right {
            text-align: right;
        }
        h2 {
            margin: 0;
            font-size: 18px;
        }
        .info {
            margin: 10px 0;
        }
        .table, .table th, .table td {
            border: 1px solid #000;
        }
        .table th, .table td {
            padding: 6px;
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            font-size: 12px;
            margin-top: 20px;
        }
        .footer p {
            margin: 3px 0;
        }
        .bank-details {
            border: 1px solid #000;
            padding: 10px;
            margin-top: 20px;
            font-size: 13px;
        }
        .bank-details strong {
            display: inline-block;
            width: 180px;
        }
    </style>
</head>
<body>
<div class="container">

    {{-- HEADER --}}
    <table class="header-table">
        <tr>
            <td>
                <h2>Invoice</h2>
                <strong>{{ $invoice->source?->name }}</strong><br>
                {{ $invoice->source?->address ?? 'Address not provided' }}<br>
                India<br>
                Tax No: {{ $invoice->source?->tax_number ?? 'N/A' }}
            </td>
            <td class="right">
                <strong>INVOICE #{{ $invoice->invoice_number }}</strong><br>
                Date of Issue: {{ $invoice->created_at?->format('d M, Y') ?? 'N/A' }}
            </td>
        </tr>
    </table>

    {{-- BILLING INFO --}}
    <div class="info">
        <p><strong>Billed To:</strong> {{ $invoice->target?->name ?? 'N/A' }}</p>
        <p><strong>Invoice Status:</strong> {{ ucfirst($invoice->status) }}</p>
    </div>

    {{-- ITEM TABLE --}}
    @php
        $items = $invoice->items ?? [];
        $totalAmount = 0;
        foreach ($items as $item) {
            $totalAmount += floatval($item['amount'] ?? 0);
        }
        $bank = \App\Models\UserBankDetailSecondary::where('user_id', $invoice->source_id)->first();
    @endphp

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Description</th>
                <th class="text-right">Amount (INR)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['description'] ?? 'N/A' }}</td>
                    <td class="text-right">{{ number_format($item['amount'] ?? 0, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align:center;">No items added.</td>
                </tr>
            @endforelse

            <tr>
                <td colspan="2" class="text-right"><strong>Total</strong></td>
                <td class="text-right"><strong>{{ number_format($totalAmount, 2) }} INR</strong></td>
            </tr>
        </tbody>
    </table>

     {{-- BANK DETAILS --}}
    @if($bank)
        <div class="bank-details">
            <strong>Bank Name:</strong> {{ $bank->bank_name ?? 'N/A' }}<br>
            <strong>Account Holder Name:</strong> {{ $bank->account_holder_name ?? 'N/A' }}<br>
            <strong>Account Number:</strong> {{ $bank->account_number ?? 'N/A' }}<br>
            <strong>IFSC Code:</strong> {{ $bank->ifsc_code ?? 'N/A' }}<br>
            <strong>Branch Name:</strong> {{ $bank->branch_name ?? 'N/A' }}
        </div>
    @endif

    {{-- FOOTER --}}
    <div class="footer">
        <p>Payment Terms: 7 days (unless agreed otherwise by both parties)</p>
        <p>This invoice was raised by {{ $invoice->source?->name ?? 'System' }}</p>
        <p>All amounts shown are rounded to two decimal places.</p>
        <p style="margin-top: 20px; text-align:center;"><strong>Thank you for your business!</strong></p>
    </div>

</div>
</body>
</html>
{{-- @php
    $totalAmount = array_sum(array_column($items, 'amount'));
@endphp --}}