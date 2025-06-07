@extends('component.header')
@section('title', 'Site Management')
<!-- Add modal  -->
@section('modal-content')
<h2 class="mt-2" id="form-title">Add Product</h2>
<form id="submit_form" action="" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="site_id" name="site_id">
    <div class="row">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="loaction">Location</label>
            <input type="text" id="loaction" name="location" class="form-control">
        </div>
        <div class="form-group">
            <label for="superviser">Superviser</label>
            <select id="superviser" name="superviser" class="form-control">
                <option value="" disabled selected>Select Superviser</option>
                @foreach ($supVis as $supdata)
                    <option value="{{($supdata->id)}}">{{($supdata->name)}}</option>
                @endforeach
            </select>
        </div>
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
            <input type="text" id="department" name="department" class="form-control">
        </div>
        <div class="form-group">
            <label for="client_name">Client</label>
            <select id="client_name" name="client_name" class="form-control" required>
                <option value="" disabled selected>Select Client name</option>
                @foreach ($clientList as $clientdata)
                    <option value="{{($clientdata->id)}}">{{($clientdata->c_name)}}</option>
                @endforeach
            </select>
        </div>

        <div class="d-flex justify-content-center">
            <button type="button" class="cancel-button btn btn-danger" data-bs-dismiss="modal"
                style='margin-right:8px;'>Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</form>
<script>
    document.getElementById('start_date').addEventListener('change', function () {
        var startDate = this.value;
        document.getElementById('end_date').setAttribute('min', startDate);
    });

    document.getElementById('end_date').addEventListener('change', function () {
        var endDate = this.value;
        document.getElementById('start_date').setAttribute('max', endDate);
    });
</script>
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
                                            <th>Site Name</th>
                                            <th>Location</th>
                                            <th>Department</th>
                                            <th>Start date</th>
                                            <th>End date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($data as $data)
                                            <tr>
                                                <td class="py-1">{{$i}}</td>
                                                <td>{{$data->site_name}}</td>
                                                <td>{{$data->location}}</td>
                                                <td>{{$data->department}}</td>
                                                <td>{{$data->start_date}}</td>
                                                <td>{{$data->end_date}}</td>
                                                <td>
                                                    <div class="action_btn">
                                                        <button class="editbtn btn btn-light">Edit</button>
                                                        <button class="editbtn btn btn-danger">Delete</button>
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
                url: '{{ route("add-site.save") }}',
                data: $(this).serialize(),
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
    });

    function openModal(type) {
        document.getElementById('form-title').innerText = `${type} Site`;
        $('#Modal1').modal('show');
    }
</script>

@endsection
