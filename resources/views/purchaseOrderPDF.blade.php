<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            border: 1px solid black;
            padding: 10px 0px 0px;
        }
        .header {
            text-align: right;
        }
        .header img {
            height: 50px;
        }
        .company-info {
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
        }
        .company-info h3 {
            margin: 0;
            font-size: 18px;
        }
        .company-info p {
            margin: 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .termsTable{
            margin-top: -10px;
            margin-bottom: 0.2px;
        }
        .termsTable td strong{
            font-size: 8px;
        }
        .termsTable td{
            font-size: 7px;
        }
        .table th, .table td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }
        .titlebox{
            text-align: center!important;
            font-weight: bold;
        }
        .footer-note {
            margin-top: 10px;
            font-size: 10px;
            line-height: 1.5;
        }
        .signature {
            text-align: center;
            margin-top: 10px;
        }
        .signature img {
            height: 50px;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="company-info">
        <h3>ELEPROJ ENGINEERS</h3>
        <p>(Turnkey MEP Contractors)</p>
        <p>Off. Shop No. 6, Ratan Bhawan Building, Daulat Nagar Road No. 4, Borivali East, Mumbai - 400066</p>
        <p>Email: info@eleprojengineers.com | Web: www.eleprojengineers.com</p>
        <p>Tel: 022-28959525</p>
    </div>

    <table class="table">
        <tr><td colspan="6" class="titlebox">Purchase Order</td></tr>
        <tr>
            <th colspan="3">To,</th>
            <td colspan="3" rowspan="2"><strong>ORDER NO.-</strong> {{$pdfData->order_no}}</td>
        </tr>
        <tr>
            <th colspan="3">{{$pdfData->comp_name ?? 'NA'}}</th>
        </tr>
        <tr>
            <td colspan="3">{{$pdfData->client_address ?? 'NA'}}</td>
            <td colspan="3"><strong>DATE :- </strong>{{$pdfData->start_date ? (\Carbon\Carbon::parse($pdfData->start_date)->format('d-m-Y')) : 'NA'}}</td>
        </tr>
        <tr>
            <th colspan="3">{{$pdfData->client_name ?? 'NA'}}</th>
            <td colspan="3"><strong>SITE NAME :- {{$pdfData->siteName ?? 'NA'}}</strong></td>
        </tr>

        <tr>
            <th colspan="1" style="width:10px">Sr. No.</th>
            <th colspan="1">Description</th>
            <th colspan="1">Quantity</th>
            <th colspan="1">Unit</th>
            <th colspan="1">Rate</th>
            <th colspan="1">Amount</th>
        </tr>
        <tr>
            <td  style="width:10px">1</td>
            <td>{{$pdfData->product_name}}</td>
            <td>{{$pdfData->quantity}}</td>
            <td>{{$pdfData->unit}}</td>
            <td>{{$pdfData->rate}}</td>
            <td>{{$pdfData->total_price}}</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align:center;"><strong>TOTAL</strong></td>
            <td colspan="1">{{$pdfData->total_price}}</td>
        </tr>

        <tr>
            <th colspan="3"><strong>GST No. :- 27DPPPP1888J7L</strong></th>
            <td colspan="3"></td>
        </tr>
        </table>
        <table class="table termsTable">
            <tr>
                <td colspan="2"><small><u><strong>Terms & Conditions</strong></u></small></td>
                <td colspan="1" rowspan="9" style="width:30%">
                    <div class="signature">
                        <p>Authorized Signatory</p>
                        <img src="signature.png" alt="Signature">
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">1. Material will be delivered within 1-2 Days.</td>
            </tr>
            <tr>
                <td colspan="2">2. Material will not as per order will be rejected any time.</td>
            </tr>
            <tr>
                <td colspan="2">3. Tax Invoice should be submitted within 7 days. If not received, then we will not be liable.
                </td>
            </tr>
            <tr>
                <td colspan="2">4. Taxes are EXCLUSIVE in Amount.</td>
            </tr>
            <tr>
                <td colspan="2">5. Any dispute or objection regarding this must be informed within 24 hours from date.</td>
            </tr>
            <tr>
                <td colspan="2">6. Material Factory Test Report will be submitted along with Tax Invoice. Otherwise, we will not
                    be liable to make the payment for the material.</td>
            </tr>
            <tr>
                <td colspan="2">7. Payment: 90 Days After Delivery.</td>
            </tr>
            <tr>
                <td colspan="2">8. Subject to Mumbai Jurisdiction.</td>
            </tr>
        </table>

    <!-- <p class="footer-note"></p> -->
</div>

</body>
</html>
