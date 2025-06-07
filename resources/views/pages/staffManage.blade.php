@extends('component.header')
@section('title', 'Staff Management')
<!-- Add modal  -->
@section('modal-content')
<h2 class="mt-2" id="form-title">Add Staff</h2>
<form id="submit_form" action="" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="staff_id" name="staff_id">
    <div class="row">
        <div class="form-group">
            <label for="input1">Staff Name</label>
            <input type="text" id="staff_name" name="staff_name" class="form-control">
        </div>
        <div class="form-group">
            <label for="input1">Email id.</label>
            <input type="email" id="email" name="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="input1">Phone no.</label>
            <input type="number" id="phone" name="phone" class="form-control">
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select id="role" name="role" class="form-control">
                <option value="" disabled selected>Select role</option>
                <option value="role">role 1</option>
                <option value="role">role 2</option>
                <option value="role">role 3</option>
            </select>
        </div>
        <div class="row">
            <div class="form-group">
                <label for="aadhar">Aadhar Card No.</label>
                <input type="number" id="aadhar" name="aadhar" class="form-control">
                <small id="aadharError" class="error"></small>
            </div>
            <div class="form-group">
                <label for="aadhar_photo">Aadhar Photo</label>
                <input type="file" id="aadhar_photo" name="aadhar_photo" class="form-control" accept="image/*">
                <img id="aadhar_preview" class="preview" src="#" alt="Aadhar Photo Preview" />
            </div>
            <div class="form-group">
                <label for="pan_num">PAN Card No.</label>
                <input type="text" id="pan_num" name="pan_num" class="form-control" style="/*text-transform:uppercase;*/" maxlength="10">
                <small id="panError" class="error"></small>
            </div>
            <div class="form-group">
                <label for="pan_photo">PAN Photo</label>
                <input type="file" id="pan_photo" name="pan_photo" class="form-control" accept="image/*">
                <img id="pan_preview" class="preview" src="#" alt="PAN Photo Preview" />
            </div>
        </div>


        <div class="d-flex justify-content-center">
            <button type="button" class="cancel-button btn btn-danger" data-bs-dismiss="modal"
                style='margin-right:8px;'>Close</button>
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

    .form-group {
        margin-bottom: 15px;
    }

    .preview {
        display: none;
        width: 100px;
        height: 100px;
        margin-top: 10px;
    }

    .error {
        color: red;
        font-size: 12px;
    }
    .upper{display: flex;
    justify-content: center;}
    .upper .doc_img{
    height: 60px;
    width: auto;
    max-width: 60px;
    margin-bottom: 6px;
    }
</style>
<div class="content-wrapper">
    <div class="row">
        <div class="col-sm-12">
            <div class="d-sm-flex align-items-center justify-content-between border-bottom">

                <button type="button" class="btn btn-primary text-white me-0 mb-2" onclick="openModal('Add')">
                    <i class="fa fa-plus"></i> Add
                </button>
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
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Aadhar</th>
                                            <th>Pan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @if (isset($data) && $data->count() === 0)
                                        <tr>
                                            <td colspan="8" class="highlight"><p style="text-align:center;">No data available</p></td>
                                        </tr>
                                        @else
                                        @foreach ($data as $data)
                                            <tr>
                                                <td class="py-1">{{$i}}</td>
                                                <td>{{$data->name}}</td>
                                                <td>{{$data->phone}}</td>
                                                <td>{{$data->email}}</td>
                                                <td>{{$data->role}}</td>
                                                <td>
                                                    <div class="upper">
                                                        <img class="doc_img" src="{{ asset('storage/'. $data->aadhar_photo)}}" alt="Aadhar Img"></div>
                                                    <div class="lower">{{$data->aadhar_number}}</div>
                                                </td>
                                                <td>
                                                    <div class="upper">
                                                        <img class="doc_img" src="{{asset('storage/'.$data->pan_photo)}}" alt="Pan Img"></div>
                                                    <div class="lower">{{$data->pan_number}}</div>
                                                </td>
                                                <td>
                                                    <div class="action_btn">
                                                        <button class="editbtn btn btn-light">Edit</button>
                                                        <button class="editbtn btn btn-danger">Delete</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php  $i++; ?>
                                        @endforeach
                                        @endif

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
<script src="{{ asset('assets/js/doc_validator.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#submit_form').on('submit', function (e) {
            e.preventDefault();

            // Create a new FormData object
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: '{{ route("add-staff.save") }}',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    alert('Form submitted successfully.');
                    $('#Modal1').modal('hide');
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
                    document.getElementById('form-title').innerText = 'Edit Staff';
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
        document.getElementById('form-title').innerText = `${type} Staff`;
        $('#Modal1').modal('show');
    }
    </script>


@endsection
