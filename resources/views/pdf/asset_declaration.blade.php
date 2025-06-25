<!DOCTYPE html>
<html>
<head>
    <title>Asset Declaration</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 13px;
            color: #333;
            line-height: 1.6;
            margin: 30px;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 8px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 6px 8px;
            vertical-align: top;
        }
        .info-table td.label {
            font-weight: bold;
            width: 180px;
            background: #f9f9f9;
        }
        .section {
            margin-top: 20px;
        }
        ol {
            padding-left: 20px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 8px;
            text-decoration: underline;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #555;
        }
    </style>
</head>
<body>

    <h2>Asset Reimbursement Declaration</h2>

    <table class="info-table">
        <tr><td class="label">Employee ID:</td><td>{{ $employee_id }}</td></tr>
        <tr><td class="label">Employee Code:</td><td>{{ $empCode }}</td></tr>
        <tr><td class="label">Employee Name:</td><td>{{ $fullName }}</td></tr>
        <tr><td class="label">Asset:</td><td>{{ $asset_name }}</td></tr>
        <tr><td class="label">Model Name:</td><td>{{ $model_name }}</td></tr>
        <tr><td class="label">Model Number:</td><td>{{ $model_no }}</td></tr>
        <tr><td class="label">Company:</td><td>{{ $comName }}</td></tr>
        <tr><td class="label">Purchase Date:</td><td>{{ $purchase_date }}</td></tr>
        <tr><td class="label">Dealer Name:</td><td>{{ $dealer_name }}</td></tr>
        <tr><td class="label">Dealer Number:</td><td>{{ $dealer_number }}</td></tr>
        <tr><td class="label">Bill Number:</td><td>{{ $bill_number }}</td></tr>
        <tr><td class="label">Request Amount:</td><td>{{ $ReqAmt }}</td></tr>
        <tr><td class="label">Price:</td><td>{{ number_format($price, 2) }}</td></tr>
    </table>

    <div class="section">
        <div class="section-title">Remarks:</div>
        <p>{{ $remarks }}</p>
    </div>

    <div class="section">
        <div class="section-title">Declaration:</div>
        <ol>
            <li>I have purchased the above-mentioned asset for official use.</li>
            <li>This is my asset and has not been transferred to the company.</li>
            <li>The asset is used primarily for business purposes.</li>
            <li>I have read and understood the company’s policy on asset reimbursements.</li>
            <li>I agree to cooperate fully with the company’s recovery process.</li>
            <li>This declaration is submitted via ESS and shall be deemed valid.</li>
            <li>This expense is claimed under <strong>Section 37(1)</strong> of the Income Tax Act.</li>
            <li>I indemnify the company against false declarations or misuse.</li>
        </ol>
    </div>
    <p style="margin-top: 15px; font-weight: bold; color: green;">
        Your request and declaration have been submitted successfully and recorded with Ref. ID: ESS/AR/{{ now()->format('Y') }}/{{ str_pad($assetId, 4, '0', STR_PAD_LEFT) }}.
    </p>


    <div class="footer">
        <p><strong>Declaration Accepted:</strong> {{ $declared_status === 'Y' ? 'Yes' : 'No' }}</p>
        <p><strong>IP Address:</strong> {{ $ip_address }}</p>
        <p><strong>Submitted At:</strong> {{ now()->format('d-m-Y H:i:s') }}</p>
    </div>


</body>
</html>
