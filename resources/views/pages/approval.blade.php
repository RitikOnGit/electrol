@extends('component.header')
@section('title', 'Approval request')
<!-- Add modal  -->
@section('modal-content')
<h2 class="mt-2">Add Product</h2>
<form id="submit_form" action="">
<div class="form-group">
            <label for="input1">Input 1</label>
            <input type="text" id="input1" name="input1" class="form-control">
        </div>
        <div class="form-group">
            <label for="input2">Input 2</label>
            <input type="text" id="input2" name="input2" class="form-control">
        </div>
        <div class="form-group">
            <label for="input3">Input 3</label>
            <input type="text" id="input3" name="input3" class="form-control">
        </div>
        <div class="form-group">
            <label for="input4">Input 4</label>
            <input type="text" id="input4" name="input4" class="form-control">
        </div>
        <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">Save</button>
        </div>
</form>

@endsection
@include('component.modal_body')


@section('content')

          <div class="content-wrapper">
            <div class="row">
              <div class="col-sm-12">
                  <div class="d-sm-flex align-items-center justify-content-between border-bottom">

                        <div class="btn-wrapper">
                          <a id="openModalBtn" class="btn btn-primary text-white me-0 mb-2"><i class="fa fa-plus"></i> Add</a>
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
                            <th>Approval Request</th>
                            <th>Request Status</th>
                            <th>Approval Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data as $data)
                        <tr>
                          <td class="py-1">{{$i}}</td>
                          <td>{{$data->request}}</td>
                          <td>{{$data->req_status}}</td>
                          <td>
                            <div class="action_btn">
                                <button class="editbtn btn btn-success">Approve</button>
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
                    url: '{{-- route("ajaxFormSubmit") --}}',
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
        });
    </script>

          @endsection
