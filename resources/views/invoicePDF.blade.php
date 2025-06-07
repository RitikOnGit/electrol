<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-header h2 {
            margin: 0;
        }

        .invoice-details {
            width: 100%;
            /* margin-bottom: 10px; */
        }

        .invoice-details td.parenttable {
            padding: 2px 4px;
            border: 0.8px solid #000;
        }

        td.toptd {
            padding: 4px;
            border: 0.8px solid #000;
            border-bottom: 0;
            text-align: center;
            font-weight: bold;
        }

        table td {
            font-size: 14px;
        }

        table th {
            font-size: 15px;
        }

        .invoice-table, .bottom-table {
            width: 100%;
            border-collapse: collapse;
            /* margin-bottom: 20px; */
        }
        .bottom-table td{
            border: 0.8px solid #000;
        }

        .invoice-table th,
        .invoice-table td {
            border: 0.8px solid #000;
            padding: 6px;
            text-align: center;
        }

        .invoice-table th {
            background-color: #f2f2f2;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
            /* margin-bottom: 20px; */
        }

        .totals-table td {
            padding: 5px;
            border: 0.8px solid #000;
        }

        .signature {
            text-align: right;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .signature img {
            height: 50px;
        }

        .terms {
            font-size: 11px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="invoice-header">
        <h2>ELEPROJ ENGINEERS (Turnkey MEP Contractor)</h2>
        <p>PILLAR OF FUTURE</p>
    </div>
    <table class="invoice-details" style="width:100%;border-collapse: collapse;">
        <tr>
            <td colspan="2" class="toptd">INVOICE</td>
        </tr>
        <tr>
            <td class="parenttable" style="width:50%">
                <table class="">
                    <tr>
                        <td><strong>To:</strong></td>
                        <td>{{$invoiceData->customer_name ?? 'NA'}},<br>
                            {{$invoiceData->comp_name ?? 'Company Name not available'}},<br>
                            {{$invoiceData->customer_address ?? 'NA'}}</>
                    </tr>
                    <tr>
                        <td><strong>Date:</strong></td>
                        <td>{{$invoiceData->invoice_date ?? 'NA'}}</td>
                    </tr>
                    <tr>
                        <td><strong>GSTIN:</strong></td>
                        <td>{{$invoiceData->cust_gst ?? 'NA'}}</td>
                    </tr>
                </table>
            </td>
            <td class="parenttable" style="width:50%;vertical-align:top;">
                <table class="">
                    <tr>
                        <td><strong>Invoice No: </strong>{{$invoiceData->invoice_number ?? 'NA'}}</td>
                    </tr>
                    <tr>
                        <td><strong>Date:-
                            </strong>{{$invoiceData->invoice_date ? (\Carbon\Carbon::parse($invoiceData->invoice_date)->format('d-m-Y')) : 'NA'}}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>P.O. No: </strong> {{$invoiceData->pono ?? 'NA'}}</td>
                    </tr>
                    <tr>
                        <td><strong>P.O. Date: </strong>{{$invoiceData->po_date ?? 'NA'}}</td>
                    </tr>
                    <tr>
                        <td><strong>Against: </strong>{{$invoiceData->Against ?? 'NA'}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>


    <table class="invoice-table">
        <thead>
            <tr>
                <th>S.N.</th>
                <th>Description</th>
                <th>SAC</th>
                <th>QTY</th>
                <th>RATE</th>
                <th>DISCOUNT</th>
                <th>AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach ($invData as $data)
                <tr>
                    <td class="">{{$i}}</td>
                    <td style="text-align:left;">{{$data->description}}</td>
                    <td>{{$data->sac}}</td>
                    <td>{{$data->qty}}</td>
                    <td>{{$data->rate}}</td>
                    <td>{{$data->discount ?? '0'}}%</td>
                    <td>{{$data->amt}}</td>
                </tr>
                <?php    $i++;  ?>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2"></td>
                <td></td>
                <td style="padding:2px 0;">{{$invoiceData->amount}}</td>
            </tr>
        </tbody>
    </table>
    <table class="invoice-table">
        <tbody>
            @php
use NumberToWords\NumberToWords;
$numberToWords = new NumberToWords();
$numberTransformer = $numberToWords->getNumberTransformer('en');

$gst_amt = ($invoiceData->amount * 18) / 100;
            @endphp
            <tr>
                <td style="width:64%;text-align:left;">Amount Chargeable (in words):</td>
                <td style="width:10%">CGST(9%)</td>
                <td style="width:10%">9%</td>
                <td style="width:16%">{{number_format((float) ($gst_amt / 2), 2, '.')}}</td>
            </tr>
            <tr>
                @php
$amtwithgst = $numberTransformer->toWords(($invoiceData->amount + $gst_amt));
                @endphp
                <td rowspan="2">{{ucfirst($invoiceData->amt_words ?? $amtwithgst)}} Only</td>
                <td>SGST(9%)</td>
                <td>9%</td>
                <td>{{number_format((float) ($gst_amt / 2), 2, '.')}}</td>
            </tr>
            <tr>
                <td><strong>Totoal</strong></td>
                <td></td>
                <td>{{number_format((float) $invoiceData->amount + $gst_amt, 2, '.')}}</td>
            </tr>
        </tbody>
    </table>

    <table class="invoice-table">
        <thead>
            <tr>
                <th rowspan="2">HSN/SAC</th>
                <th rowspan="2">Taxable Value</th>
                <th colspan="2">Central Tax</th>
                <th colspan="2">State Tax</th>
            </tr>
            <tr>
                <th>Rate</th>
                <th>Amount</th>
                <th>Rate</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @php $totalTax = 0; @endphp

            @foreach ($invData as $data)
                        @php
    $tax = ($data->amt * 9) / 100;
    $totalTax += $tax;
                        @endphp
                        <tr>
                            <td>{{ $data->sac }}</td>
                            <td>{{ $data->amt }}</td>
                            <td>9%</td>
                            <td>{{ number_format((float) $tax, 2, '.', '') }}</td>
                            <td>9%</td>
                            <td>{{ number_format((float) $tax, 2, '.', '') }}</td>
                        </tr>
            @endforeach

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><strong>TOTAL</strong></td>
                <td></td>
                <td></td>
                <td>{{ number_format((float) $totalTax, 2, '.', '') }}</td>
                <td></td>
                <td>{{ number_format((float) $totalTax, 2, '.', '') }}</td>
            </tr>
        </tbody>
    </table>
    <table class="totals-table" style="width:100%">
        <tr>
            @php
$amountInWords = $numberTransformer->toWords($invoiceData->amount);
            @endphp
            <td>{{ ucfirst($invoiceData->amt_words ?? $amountInWords) }} Only</td>
        </tr>
    </table>

    <table class="bottom-table"><tbody>
        <tr>
            <td style="width:50%;">
                <ul style="list-style: none; padding-left: 4px;">
                    <li><strong>Bankers</strong>:- ICICI BANK LTD.</li>
                    <li><strong>IFS Code</strong>:- ICICI0001232(Borivali West, Mumbai)</li>
                    <li><strong>A/c No.</strong>:- 123205500350</li>
                    <li><strong>GSTIN: 27CDPPP7888F1ZL</strong></li>
                    <li><strong>PAN</strong> : CDPPP7888F</li>
                </ul>
            </td>
            <td style="vertical-align: top; margin-top:14px;">
                <div><strong>Discription:</strong>
                I/We hereby</div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="terms">
                    <p>Terms & Conditions:</p>
                    <ul style="padding-left: 12px;">
                        <li>Payment to be made within 7 days.</li>
                        <li>Payment should be made by DD/Cheque or at our office.</li>
                        <li>We reserve the right to demand payment at any time.</li>
                        <li>Subject to jurisdiction.</li>
                    </ul>
                </div>
            </td>
            <td style="text-align:end;">
                <div class="signature">
                    <p>For M/S. ELEPROJ ENGINEERS</p>
                    <img src="/signature_image" alt="Signature" />
                    <p>Authorized Signatory</p>
                </div>
            </td>
        </tr>
    </tbody></table>
</body>

</html>
