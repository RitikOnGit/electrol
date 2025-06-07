@extends('component.header')
@section('title', 'Staff Management')
<!-- Add modal  -->
@section('modal-content')
<h2 class="mt-2" id="form-title">Add Tender</h2>
<form id="submit_form" action="" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="tender_id" name="tender_id">
    <div class="row">

    <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" id="start_date" name="start_date" class="form-control">
        </div>
        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" id="end_date" name="end_date" class="form-control">
        </div>
        <div class="form-group">
            <label for="department">Department</label>
            <select id="department" name="department" class="form-control">
                <option value="" disabled selected>Select Department</option>
                <option value="department1">Department 1</option>
                <option value="department2">Department 2</option>
                <option value="department3">Department 3</option>
            </select>
        </div>
        <div class="form-group">
            <label for="emd_amount">EMD Amount</label>
            <input type="number" id="emd_amount" name="emd_amount" class="form-control">
        </div>
        <div class="form-group">
            <label for="tender_fees">Tender Fees</label>
            <input type="number" id="tender_fees" name="tender_fees" class="form-control">
        </div>
        <div class="form-group">
            <label for="accounting_no">Accounting Number</label>
            <input type="number" id="accounting_no" name="accounting_no" class="form-control">
        </div>
        <div class="form-group">
            <label for="tender_expenses">Tender Expenses</label>
            <input type="number" id="tender_expenses" name="tender_expenses" class="form-control">
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
            <label for="siteLocation">Site Location</label>
            <select id="siteLocation" name="siteLocation" class="form-control">
                <option value="" disabled selected>Select location</option>
                <option value="location1">Location 1</option>
                <option value="location2">Location 2</option>
                <option value="location3">Location 3</option>
            </select>
        </div>
        <div class="form-group">
            <label for="phone">Phone no.</label>
            <input type="number" id="phone" name="phone" class="form-control">
        </div>
        <div class="form-group">
            <label for="email_id">Email id.</label>
            <input type="email" id="email_id" name="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="input1">GST</label>
            <input type="text" id="gst" name="gst" class="form-control">
        </div>
        <div class="form-group">
            <label for="company_type">Company Type</label>
            <select id="company_type" name="company_type" class="form-control">
                <option value="" disabled selected>Select Type</option>
                <option value="role">Type 1</option>
                <option value="role">Type 2</option>
                <option value="role">Type 3</option>
            </select>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="pan_num">PAN Card No.</label>
                <input type="text" id="pan_num" name="pan_num" class="form-control" maxlength="10">
                <small id="panError" class="error"></small>
            </div>
            <div class="form-group">
                <label for="pan_photo">PAN Photo</label>
                <input type="file" id="pan_photo" name="pan_photo" class="form-control" accept="image/*">
                <img id="pan_preview" class="preview" src="#" alt="PAN Photo Preview" />
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <button type="button" class="cancel-button btn btn-danger" data-bs-dismiss="modal" style="margin-right:8px;">Close</button>
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
                            <h4 class="card-title">Tender List</h4>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr no.</th>
                                        <th>Client Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Company Type</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Department</th>
                                        <th>EMD Amount</th>
                                        <th>Tender Fees</th>
                                        <th>Tender Expenses</th>
                                        <th>GST</th>
                                        <th>Accounting No.</th>
                                        <th>PAN</th>
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
                                            @foreach ($tenderlist as $data)
                                                <tr>
                                                    <td class="py-1">{{$i}}</td>
                                                    <td>{{$data->c_name}}</td>
                                                    <td>{{$data->phone}}</td>
                                                    <td>{{$data->email}}</td>
                                                    <td>{{$data->company_type}}</td>
                                                    <td>{{$data->start_date}}</td>
                                                    <td>{{$data->end_date}}</td>
                                                    <td>{{$data->department}}</td>
                                                    <td>{{$data->emd_amount}}</td>
                                                    <td>{{$data->tender_fees}}</td>
                                                    <td>{{$data->tender_expenses}}</td>
                                                    <td>{{$data->gst}}</td>
                                                    <td>{{$data->accounting_no}}</td>
                                                    <td>
                                                        <div class="upper">
                                                            @if($data->pan_photo)
                                                                <img class="doc_img" src="{{ asset('storage/tender/' . $data->pan_photo) }}" alt="PAN Img">
                                                            @else
                                                                <span>No Image</span>
                                                            @endif
                                                        </div>
                                                        <div class="lower">{{$data->pan_number}}</div>
                                                    </td>
                                                    <td>
                                                        <div class="action_btn">
                                                            <button class="editbtn btn btn-light">Edit</button>
                                                            <button class="editbtn btn btn-danger">Delete</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php        $i++; ?>
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
                url: '{{ route("add-tender") }}',
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
                    // location.reload();
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
                    document.getElementById('form-title').innerText = 'Edit Tender';
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
        document.getElementById('form-title').innerText = `${type} Tender`;
        $('#Modal1').modal('show');
    }
    </script>


@endsection
