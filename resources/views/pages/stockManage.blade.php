@extends('component.header')
@section('title', 'Stock Management')
<!-- Add modal  -->
@section('modal-content')
<h2 class="mt-2" id="form-title">Add Product</h2>
<form id="submit_form" action="" method="POST">
    @csrf
    <input type="hidden" id="product_id" name="product_id">
    <div class="row">
        <div class="form-group">
            <label for="product_name">Product Name</label>
            <select id="product_name" name="pname" class="form-control" required>
                <option value="" disabled selected>Select Product</option>
                @foreach ($productData as $data)
                    <option value="{{ $data->id }}" data-price="{{ $data->price }}">{{ $data->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="input1">Product Qty.</label>
            <input type="number" id="product_qty" name="product_qty" class="form-control">
        </div>
        <div class="form-group">
            <label for="input1">Product Price</label>
            <input type="number" id="product_price" name="product_price" class="form-control">
            <span id="productPrice"></span>
        </div>
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
            <label for="siteLocation">Site Location</label>
            <select id="siteLocation" name="siteLocation" class="form-control">
                <option value="" disabled selected>Select location</option>
                <option value="location1">Location 1</option>
                <option value="location2">Location 2</option>
                <option value="location3">Location 3</option>
            </select>
        </div>
        <div class="form-group">
        <label for="siteSuperviser">Superviser</label>
            <select id="siteSuperviser" name="siteSuperviser" class="form-control" required>
                <option value="" disabled selected>Select Superviser</option>
                @foreach ($superviser as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                @endforeach
            </select>
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
                            <!-- <th>Product Id</th> -->
                            <th>Product Name</th>
                            <th>Amount</th>
                            <th>Quantity</th>
                            <th>Superviser</th>
                            <th>Site Location</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data_list as $data)
                        <tr>
                          <td class="py-1">{{$i}}</td>
                          <td>{{$data->product_name}}</td>
                          <td>{{$data->amt}}</td>
                          <td>{{$data->quantity}}</td>
                          <td>{{$data->siteSuperviser}}</td>
                          <td>{{$data->siteLocation}}</td>
                          <td>
                            <div class="action_btn">
                                <button class="editbtn btn btn-light edit-product-btn" data-product-id="{{$data->id}}">Edit</button>
                                <button class="editbtn btn btn-danger">Delete</button>
                            </div>
                          </td>
                        </tr>
                        <?php $i++; ?>
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
                    url: '{{ route("stock.save") }}',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        alert('Form submitted successfully.');
                        window.location.reload();
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
            const url = `{{ url('/stock_list') }}/${productId}`;
              fetch(url)
                .then(response => response.json())
                .then(data => {
              console.log(data);
                    document.getElementById('form-title').innerText = 'Edit Product';
                    document.getElementById('product_id').value = data.id;
                    document.getElementById('product_name').value = data.name;
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

    document.getElementById('product_name').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var price = selectedOption.getAttribute('data-price');
            document.getElementById('productPrice').textContent = price ? `Price: ₹ ${price}` : '';
            document.getElementById('product_price').value = price ? `${price}` : '';

        });
    </script>

          @endsection
