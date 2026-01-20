<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>

    <!-- Bootstrap for responsiveness -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

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

        /* Responsive for tablets and mobile */
        @media (max-width: 992px) { /* iPad landscape & smaller */
            .header-table td {
                display: block;
                width: 100%;
                text-align: left !important;
                margin-bottom: 10px;
            }
            .header-table .right {
                text-align: left !important;
                margin-top: 10px;
            }
            .bank-details strong {
                width: 140px;
            }
            h2 {
                font-size: 16px;
            }
        }

        @media (max-width: 576px) { /* Mobile devices */
            h2 {
                font-size: 14px;
            }
            .bank-details strong {
                width: 120px;
            }
            .table th, .table td {
                padding: 4px;
                font-size: 12px;
            }
            .footer {
                font-size: 11px;
            }
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
                <p style="max-width: 350px; white-space: normal; word-break: break-word;">
                    {{ $invoice->source?->address ?? 'Address not provided' }}
                </p>
                <br>
                India<br>
                 @php
                $idProof = \App\Models\UserIdProofSecondary::where('user_id', $invoice->source->id)->first();
                @endphp
                Pan card No: {{ $idProof?->id_proof_number ?? 'N/A' }}
                <br>
                GST No: {{ $invoice->source?->gst_no ?? 'N/A' }}
                <br>
                Type Of Service: {{ getTypeOfEngagementOptions()[$invoice->source?->type_of_engagement] ?? 'N/A' }}
            </td>
            <td class="right">
                <strong>INVOICE #{{ $invoice->invoice_number }}</strong><br>
                Date of Issue: {{ $invoice->issue_date?->format('d M, Y') ?? 'N/A' }}
            </td>
        </tr>
    </table>
    
    {{-- BILLING INFO --}}
    <div class="info">
        <p style="max-width: 350px; white-space: normal; word-break: break-word;"><strong>Billed To:</strong> {{ $invoice->target?->address ?? 'TGG Eco Ventures Pvt. Ltd. #677, 1st
                                        Floor, 27th Main 13th Cross, Sector-1,
                                        HSR Layout, Bangalore-560102,
                                        Karnataka, India' }}</p>
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

    <div class="table-responsive">
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
    </div>

    {{-- BANK DETAILS --}}
    <br>
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
