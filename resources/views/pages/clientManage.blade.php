@extends('component.header')
@section('title', 'Client Manager')
<!-- Add modal  -->
@section('modal-content')
<h2 class="mt-2" id="form-title">Add Client</h2>
<form id="submit_form" action="" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="client_id" name="client_id">
    <div class="row">
        <div class="form-group">
            <label for="client_name">Client name</label>
            <input type="text" id="client_name" name="client_name" class="form-control">
        </div>
        <div class="form-group">
            <label for="input1">Email id.</label>
            <input type="email" id="email" name="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="phone">Contact no.</label>
            <input type="number" id="phone" name="phone" class="form-control">
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="location" class="form-control">
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
         <div class="form-group">
            <label for="gst_no">GST no.</label>
            <input type="text" id="gst_no" name="gst_no" class="form-control">
        </div>
        <div class="form-group">
            <label for="comp_name">Company name</label>
            <input type="text" id="comp_name" name="comp_name" class="form-control">
        </div>
        <div class="form-group">
            <label for="comp_type">Company type</label>
            <select id="comp_type" name="comp_type" class="form-control">
                <option value="" disabled selected>Select type</option>
                <option value="type1">type 1</option>
                <option value="type2">type 2</option>
                <option value="type3">type 3</option>
            </select>
        </div>

        <div class="d-flex justify-content-center">
            <button type="button" class="cancel-button btn btn-danger" data-bs-dismiss="modal"
                style='margin-right:8px;'>Close</button>
            <button id="submit_button" type="submit" class="btn btn-primary">Save</button>
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
                            <th>Client Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Location</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data as $data)
                        <tr>
                          <td class="py-1">{{$i}}</td>
                          <td>{{$data->c_name}}</td>
                          <td>{{$data->email}}</td>
                          <td>{{$data->phone}}</td>
                          <td>{{$data->location}}</td>
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
<script src="{{ asset('assets/js/doc_validator.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#submit_form').on('submit', function (e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        type: 'POST',
        url: '{{ route("client-add") }}',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            $('#Modal1').modal('hide');
            alert('Form submitted successfully.');
            console.log(response);
            setTimeout(() =>{window.location.reload();},400)
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
            const clientId = this.dataset.productId;
            const url = `{{ url('/client-edit') }}/${clientId}`;
              fetch(url)
                .then(response => response.json())
                .then(data => {
              console.log(data);
                    document.getElementById('form-title').innerText = 'Edit Staff';
                    document.getElementById('client_id').value = data.id;
                    document.getElementById('client_name').value = data.c_name;
                    document.getElementById('comp_name').value = data.comp_name;
                    document.getElementById('email').value = data.email;
                    document.getElementById('phone').value = data.phone;
                    document.getElementById('address').value = data.location;
                    document.getElementById('gst_no').value = data.gst_no;
                    document.getElementById('pan_num').value = data.pan_no;
                    document.getElementById('comp_type').value = data.comp_type;

                    const panPhotoInput = document.getElementById('pan_photo');
                    const panPreview = document.getElementById('pan_preview');

                    if (data.pan_photo) {
                        panPreview.style.display = 'block';
                        panPreview.src = `storage/${data.pan_photo}`;
                        panPhotoInput.disabled = true;
                        panPhotoInput.style.display = 'none';
                    } else {}

                    $('#Modal1').modal('show'); // Open the modal
                });
            });
        });
    });

        function openModal(type){
        document.getElementById('form-title').innerText = `${type} Client`;
        $('#Modal1').modal('show');
    }
    </script>

          @endsection
