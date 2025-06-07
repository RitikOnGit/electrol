@extends('component.header')
@section('title', 'Add Invoice')

@section('content')
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<style>
    .card_title {
        max-width: 80%;
        text-align: center;
    }

    .card_body {
        padding: 1rem 1rem;
    }

    .trow .card {
        height: 100%
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #777;
        padding: 8px 4px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .taxt-align-center {
        text-align: center;
        color: #000;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }
</style>

<div class="content-wrapper">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Invoice Management</h4>
                </div>
                <div class="card-body">
                    <!-- Invoice Form -->
                    <form action="{{ route('invoice-save') }}" method="POST" id="invoice-form">
                        @csrf
                        <div class="form-group">
                            <label for="invoice-number">Invoice Number</label>
                            <input type="text" class="form-control" id="invoice-number" name="invoice_number">
                        </div>
                        <div class="form-group">
                            <label for="customer-name">Customer Name</label>
                            <select id="customer-name" name="customer_name" class="form-control">
                                <option value="" disabled selected>Select Client</option>
                                @foreach ($client_data as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="invoice-date">Invoice Date</label>
                            <input type="date" class="form-control" id="invoice-date" name="invoice_date">
                        </div>
                        <div class="form-group">
                            <label for="pono">P.O.No</label>
                            <input type="number" class="form-control" id="pono" name="pono">
                        </div>
                        <div class="form-group">
                            <label for="po_date">P.O.Date</label>
                            <input type="date" class="form-control" id="po_date" name="po_date">
                        </div>
                        <div class="form-group">
                            <label for="customer-name">Against</label>
                            <input type="text" class="form-control" id="Against" name="Against">
                        </div>
                        <!-- table area -->
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Add Transaction</h5>
                            </div>
                            <div class="">
                                <div class="tableContainer2 table-responsive" style="margin:1.5rem 0">
                                    <table id="discTable">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">Sr. No.</th>
                                                <th style="text-align: center">Discription</th>
                                                <th style="text-align: center">SAC</th>
                                                <th style="text-align: center">QTY.</th>
                                                <th style="text-align: center">RATE</th>
                                                <th style="text-align: center">DISCOUNT(%)</th>
                                                <th style="text-align: center">AMOUNT</th>
                                                <th style="text-align: center; width: 42px;" class="sorting_disabled"
                                                    rowspan="1" colspan="1" aria-label="Add row">

                                                    <button type="button" onclick="addRowTable(event, 'discTable')"
                                                        class="btn btn-success btn-xs">
                                                        +
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="discTableBody">
                                            <tr>
                                                <input type="hidden" name="row_id[]" value="">
                                                <td style="text-align: center">1</td>
                                                <td>
                                                    <input type="textarea" class="row1 col2" name="discription[]"
                                                        placeholder="..." style="">
                                                </td>
                                                <td>
                                                    <input type="text" class="row1 col3" name="sac[]" placeholder="..."
                                                        style="max-width:100px">
                                                </td>
                                                <td>
                                                    <input type="number" class="row1 col4" name="qty[]"
                                                        onkeyup="sumColAndRows(1, 4)" placeholder="..."
                                                        style="max-width:100px">
                                                </td>
                                                <td>
                                                    <input type="number" class="row1 col5" step="00.01" name="rate[]"
                                                        onkeyup="sumColAndRows(1, 5)" placeholder="..."
                                                        style="max-width:100px">
                                                </td>
                                                <td>
                                                    <input type="number" class="row1 col6" name="discount[]"
                                                        step="00.01" max="100"
                                                        onkeyup="if(this.value > 100) this.value = 100; sumColAndRows(1, 6);"
                                                        placeholder="..." style="max-width:100px">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="row1 col7"
                                                        onkeyup="sumtotal(1, 7)" name="amount[]" placeholder="..."
                                                        style="max-width:100px">
                                                </td>
                                                <td></td>
                                            </tr>

                                        </tbody>

                                        <tfoot>

                                            <tr>
                                                <td style="text-align: center">
                                                    <h5 class="slipTitle">Total</h5>
                                                </td>
                                                <td style="text-align: center">
                                                    <span class="slipTitle"></span>
                                                </td>
                                                <td style="text-align: center">
                                                    <span class="slipTitle"></span>
                                                </td>
                                                <td style="text-align: center">
                                                    <span class="slipTitle"></span>
                                                </td>
                                                <td style="text-align: center">
                                                    <span id="colTotal4" class="slipTitle"></span>
                                                </td>
                                                <td style="text-align: center">
                                                    <span id="colTotal5" class="slipTitle"></span>
                                                </td>
                                                <td style="text-align: center">
                                                    <span id="totalTotal" class="slipTitle">0</span>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="amtInWords" name="amtInWords">
                        <!-- end table area -->

                        <!-- <div class="form-group">
                                <label for="amount">Amount</label>
                            </div> -->
                        <!-- <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div> -->
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function addRowTable(event, type) {
        event.preventDefault()
        let row = document.getElementById('discTable').rows.length - 1
        const cascoBuquesTableEmbarcacionesBody = document.getElementById('discTableBody')
        const tr = document.createElement('tr');
        cascoBuquesTableEmbarcacionesBody.appendChild(tr)
        tr.id = `newRowTable${row}`
        tr.innerHTML = `
        <input type="hidden" name="row_id[]">
          <td style="text-align:center">${row}</td>
          <td>
                <input type="textarea" class="row1 col2" name="discription[]" placeholder="..." style="">
          </td>
          <td>
            <input type="text" class="row${row}" name="sac[]" placeholder="..." style="max-width:100px">
          </td>
          <td>
            <input type="number" class="row${row} col4" name="qty[]" onkeyup="sumColAndRows(${row}, 4)" placeholder="..." style="max-width:100px">
          </td>
          <td>
            <input type="number" class="row${row} col5" step="00.01" name="rate[]" onkeyup="sumColAndRows(${row}, 5)" placeholder="..." style="max-width:100px">
          </td>
          <td>
            <input type="number" class="row${row} col6" step="00.01" name="discount[]" onkeyup="sumColAndRows(${row}, 6)" placeholder="..." style="max-width:100px">
          </td>
          <td>
            <input type="number" class="row${row} col7" step="00.01" name="amount[]" placeholder="..." style="max-width:100px">
          </td>
          <td>
              <button id="newRowTable${row}" type="button" class="btn btn-danger btn-xs btn-delete"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
          </td>
          `
    }


    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('btn-delete')) {
            event.preventDefault();
            var id = event.target.id;
            document.getElementById(id).remove();
        }
    });


    // calculation #
    function sumColAndRows(row, col) {
        const table = document.getElementById('discTable');
        console.log(`this is row no ${row}`)
        let col4Input = parseFloat(table.querySelector(`.row${row}.col4`).value) || 0;
        let col5Input = parseFloat(table.querySelector(`.row${row}.col5`).value) || 0;
        let col6Input = parseFloat(table.querySelector(`.row${row}.col6`).value) || 0;
        let col7Input = table.querySelector(`.row${row}.col7`);

        console.log(row);
        col6Input = Math.min(col6Input, 100);
        console.log(col6Input);

        let col7Total = col4Input * col5Input;

        // Apply the discount percentage (if any)
        let discountAmount = (col7Total * col6Input) / 100;

        // Subtract the discount from the total
        col7Total -= discountAmount;

        // Update col7 with the calculated total, rounded to 2 decimal places
        col7Input.value = col7Total.toFixed(2);

        sumtotal(row, col);
    }


    function sumtotal(row, col) {
        const table = document.getElementById('discTable');

        let totalCol7 = 0;
        let col6Elements = table.querySelectorAll('.col7');
        col6Elements.forEach(element => {
            totalCol7 += parseFloat(element.value) || 0;
        });
        table.querySelector('#totalTotal').innerText = totalCol7.toFixed(2);
        let amtWord = convertNumberToWords(totalCol7.toFixed(0));
        document.getElementById('amtInWords').value = amtWord;
    }

    // function numberinput(){
    // let numberInputs = document.querySelectorAll('#nameTable input[type="number"]:not(.col5),#nameTable2 input[type="number"]:not(.col4)');
    // numberInputs.forEach(input => {
    //     input.setAttribute('step', '00.01');
    // });
    // }
    // numberinput();

    // Define an object that maps numbers to their word form
    const numbersToWords = {
        0: "zero",
        1: "one",
        2: "two",
        3: "three",
        4: "four",
        5: "five",
        6: "six",
        7: "seven",
        8: "eight",
        9: "nine",
        10: "ten",
        11: "eleven",
        12: "twelve",
        13: "thirteen",
        14: "fourteen",
        15: "fifteen",
        16: "sixteen",
        17: "seventeen",
        18: "eighteen",
        19: "nineteen",
        20: "twenty",
        30: "thirty",
        40: "forty",
        50: "fifty",
        60: "sixty",
        70: "seventy",
        80: "eighty",
        90: "ninety",
    };

    // Define the function to convert number to words
    function convertNumberToWords(number) {
        if (number === 0) return "zero";

        // Function to convert numbers less than 1000
        function convertLessThanThousand(num) {
            let words = "";

            if (num >= 100) {
                words += convertNumberToWords(Math.floor(num / 100)) + " hundred";
                num %= 100;
            }

            if (num > 0) {
                if (words !== "") words += " and ";
                if (num < 20) words += numbersToWords[num];
                else {
                    words += numbersToWords[Math.floor(num / 10) * 10];
                    if (num % 10 > 0) words += "-" + numbersToWords[num % 10];
                }
            }

            return words;
        }
        let words = "";

        if (number >= 10000000) {
            words += convertLessThanThousand(Math.floor(number / 10000000)) + " crore";
            number %= 10000000;
        }

        if (number >= 100000) {
            words += (words ? " " : "") + convertLessThanThousand(Math.floor(number / 100000)) + " lakh";
            number %= 100000;
        }

        if (number >= 1000) {
            words += (words ? " " : "") + convertLessThanThousand(Math.floor(number / 1000)) + " thousand";
            number %= 1000;
        }

        if (number > 0) {
            words += (words ? " " : "") + convertLessThanThousand(number);
        }

        return words.trim();
    }

    //console.log(convertNumberToWords(545123)); // Output: "five lakh one thousand one hundred and twenty-three"
    // console.log(convertNumberToWords(123456789)); // Output: "twelve crore thirty-four lakh fifty-six thousand seven hundred and eighty-nine"

</script>

@endsection
