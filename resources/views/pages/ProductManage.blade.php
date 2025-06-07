@extends('component.header')
@section('title', 'Product Management')
<!-- Add modal  -->
@section('modal-content')
<h2 class="mt-2" id="form-title">Add Product</h2>
<form id="submit_form" action="" method="POST">
    @csrf
    <input type="hidden" id="product_id" name="product_id">
    <div class="row">
        <div class="form-group">
            <label for="pname">Product Name</label>
            <input type="text" id="pname" name="pname" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="product_price">Product Price</label>
            <input type="number" id="product_price" name="product_price" class="form-control" required>
        </div>
        <div class="form-group">
    <label for="units">Units</label>
    <select id="units" name="units" class="form-control" required>
        <option disabled selected>Select Unit</option>
        <option value="kg">Kilogram (kg)</option>
        <option value="g">Gram (g)</option>
        <option value="lb">Pound (lb)</option>
        <option value="oz">Ounce (oz)</option>
        <option value="l">Liter (l)</option>
        <option value="ml">Milliliter (ml)</option>
        <option value="m">Meter (m)</option>
        <option value="cm">Centimeter (cm)</option>
        <option value="mm">Millimeter (mm)</option>
        <!-- Add more units as needed -->
    </select>
    <span id="units-error" class="text-danger" style="display: none;">Please select a unit.</span>
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
                            <th>Unit</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach ($product_data as $data)
                        <tr>
                          <td class="py-1">{{$i}}</td>
                          <!-- <td>{{$data->pro_id}}</td> -->
                          <td>{{$data->name}}</td>
                          <td>{{$data->price}}</td>
                          <td>{{$data->unit}}</td>
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
          let units =  $('#units').val();
          console.log(units)
            $('#submit_form').on('submit', function (e) {
                e.preventDefault();
                let units = $('#units').val();
        if (units === "" || units === null) {
            event.preventDefault();
            $('#units-error').show();
            } else {
                $('#units-error').hide();
                $.ajax({
                    type: 'POST',
                    url: '{{ route("product.save") }}',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        alert('Form submitted successfully.');
                        console.log(response);
                        $('#Modal1').modal('hide');
                        location.reload();
                    },
                    error: function (xhr) {
                        alert('Form submission failed.');
                        console.log(xhr.responseText);
                    }
                });
            }
            });

            // units
            $('#units').on('change', function() {
            let units = $(this).val();
            if (units !== "") {
                $('#units-error').hide();
            }
    });
// edit function
document.querySelectorAll('.edit-product-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const url = `{{ url('/product_list') }}/${productId}`;
              fetch(url)
                .then(response => response.json())
                .then(data => {
              console.log(data);
                    document.getElementById('form-title').innerText = 'Edit Product';
                    document.getElementById('product_id').value = data.id;
                    document.getElementById('pname').value = data.name;
                    document.getElementById('product_price').value = data.price;
                    document.getElementById('units').value = data.unit;
                    $('#Modal1').modal('show');
                });
        });
    });
        });

        function openModal(type){
        document.getElementById('form-title').innerText = `${type} Product`;
        $('#Modal1').modal('show');
    }
    </script>

          @endsection
