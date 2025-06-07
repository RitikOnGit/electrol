@extends('component.header')
@section('title', 'Stock Management')
<!-- Add modal  -->
@section('modal-content')
<h2 class="mt-2" id="form-title">Add Product</h2>
<form id="submit_form" action="" method="POST">
    @csrf
    <input type="hidden" id="order_id" name="order_id">
    <div class="row">
        <div class="form-group">
            <label for="siteName">Site name</label>
            <select id="siteName" name="siteName" class="form-control" required>
                <option value="" disabled selected>Select a site</option>
                @foreach ($site_data as $site)
                    <option value="{{ $site->id }}">{{ $site->site_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
        <label for="siteSuperviser">Superviser</label>
            <select id="siteSuperviser" name="siteSuperviser" class="form-control" required>
                <option value="" disabled selected>Select Superviser</option>
                @foreach ($emp_data as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
        <label for="client_name">Client Name</label>
            <select id="client_name" name="client_name" class="form-control" required>
                <option value="" disabled selected>Select Client</option>
                @foreach ($client_data as $data)
                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="product_name">Product Name</label>
            <select id="product_name" name="product_name" class="form-control" required>
                <option value="" disabled selected>Select Product</option>
                @foreach ($productData as $data)
                    <option value="{{ $data->id }}" data-price="{{ $data->price }}">{{ $data->name }}</option>
                @endforeach
            </select>
            <span id="product_price"></span>
        </div>
        <div class="form-group">
            <label for="quantity">Qty.</label>
            <input type="number" id="quantity" name="quantity" class="form-control">
        </div>
        <div class="form-group">
            <label for="total_price">Total Rate</label>
            <input type="text" id="total_price" name="total_price" class="form-control" readonly>
        </div>
        <div class="form-group">
            <label for="remark">Remark</label>
            <input type="text" id="remark" name="remark" class="form-control">
        </div>
        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" id="start_date" name="start_date" class="form-control">
        </div>
        <div class="form-group">
        <span id="request_message"></span>
        </div>



        <div class="d-flex justify-content-center">
        <button type="button" class="cancel-button btn btn-danger" data-bs-dismiss="modal" style='margin-right:8px;'>Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</form>
@endsection
@include('component.modal_body')



@section('content')
<style>
    .form-group {
    width: 50%;
}
</style>
          <div class="content-wrapper">
            <div class="row">
              <div class="col-sm-12">
                  <div class="d-sm-flex align-items-center justify-content-between border-bottom">

                        <div class="btn-wrapper">

                        <button type="button" class="btn btn-primary text-white me-0 mb-2" onclick="openModal('Add')">
                        <i class="fa fa-plus"></i> Add
                        </button>
                        </div>
                    </div>

          <div class="">

              <div class="col-lg-12 grid-margin stretch-card mt-2">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Product List</h4>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Sr no.</th>
                            <th>Site Name</th>
                            <th>Site Superviser</th>
                            <th>Client</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Start date</th>
                            <th>Remark</th>
                            <th>Approval Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach ($purchaseOrder_data as $data)
                            <tr>
                              <td class="py-1">{{$i}}</td>
                              <td>{{$data->siteName}}</td>
                              <td>{{$data->siteSuperviser}}</td>
                              <td>{{$data->client_name}}</td>
                              <td>{{$data->product_name}}</td>
                              <td>{{$data->quantity}}</td>
                              <td>{{$data->total_price}}</td>
                              <td>{{$data->start_date}}</td>
                              <td>{{$data->remark}}</td>
                              <td>
                                @if(is_null($data->approval_status))
                                    No Status
                                @elseif($data->approval_status == 0)
                                    Pending
                                @elseif($data->approval_status == 1)
                                    Approved
                                @else
                                    Unknown Status
                                @endif
                            </td>
                              <td>
                                <div class="action_btn">
                                <a href="{{ route('purchase-pdf', ['purchaseId' => $data->id]) }}" target="_blank" class="btn btn-success">
                                        <i class="mdi mdi-printer" title="Print"></i>
                                        </a>
                                    <!-- <button class="editbtn btn btn-light edit-product-btn" data-product-id="{{$data->id}}">Edit</button> -->
                                    <!-- <button class="editbtn btn btn-danger">Delete</button> -->
                                </div>
                              </td>
                            </tr>
                            <?php    $i++; ?>
                        @endforeach

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

                </div>
              </div>
            </div>
          </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          <script>
        $(document).ready(function () {
            $('#submit_form').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '{{ route("add-purchase-order") }}',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        alert('Form submitted successfully.');
                        console.log(response);
                    },
                    error: function (xhr) {
                        alert('Form submission failed.');
                        console.log(xhr.responseText);
                    }
                });
            });

// edit function
document.querySelectorAll('.edit-product-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const url = `{{ url('/products') }}/${productId}`;
              fetch(url)
                .then(response => response.json())
                .then(data => {
              console.log(data);
                    document.getElementById('form-title').innerText = 'Edit Product';
                    document.getElementById('product_id').value = data.id;
                    document.getElementById('pname').value = data.name;
                    document.getElementById('product_price').value = data.amt;
                    document.getElementById('product_qty').value = data.quantity;
                    document.getElementById('siteName').value = data.siteName;
                    document.getElementById('siteLocation').value = data.siteLocation;
                    document.getElementById('siteSuperviser').value = data.siteSuperviser;
                    $('#Modal1').modal('show'); // Open the modal
                });
        });
    });


        });

        function openModal(type){
        document.getElementById('form-title').innerText = `${type} Product`;
        $('#Modal1').modal('show');
    }

    // calculate price with quantity
    document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_name');
    const quantityInput = document.getElementById('quantity');
    const totalPriceInput = document.getElementById('total_price');

    function calculateTotalPrice() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const price = parseFloat(selectedOption.getAttribute('data-price'));
        const quantity = parseInt(quantityInput.value, 10);
        const requestMessageSpan = document.getElementById('request_message');

        if (!isNaN(price) && !isNaN(quantity)) {
            const total = price * quantity;
            totalPriceInput.value = total.toFixed(2); // Assuming two decimal places for currency
            var priceValue = parseFloat(total);
               if (priceValue >= 100000) {
                   requestMessageSpan.textContent = 'Request will send to Admin';
               } else {
                   requestMessageSpan.textContent = 'Request will send to Site Incharge';
               }
        } else {
            totalPriceInput.value = '';
        }
    }

    productSelect.addEventListener('change', calculateTotalPrice);
    quantityInput.addEventListener('input', calculateTotalPrice);
});
// request_message
        document.getElementById('product_name').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var price = selectedOption.getAttribute('data-price');
            document.getElementById('product_price').textContent = price ? `Price: ₹ ${price}` : '';
        });
    </script>

          @endsection
