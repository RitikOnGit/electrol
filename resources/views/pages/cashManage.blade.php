@extends('component.header')
@section('title', 'Stock Management')
<!-- Add modal  -->
@section('modal-content')
<h2 class="mt-2" id="form-title">Add Cash management</h2>
<form id="submit_form" action="" method="POST">
    @csrf
    <input type="hidden" id="cm_id" name="cm_id">
    <div class="row">
        <div class="form-group">
            <label for="alloted_amt">Alloted amount</label>
            <input type="number" id="alloted_amt" name="alloted_amt" step="0.01" class="form-control">
        </div>
        <div class="form-group">
            <label for="emp_name">Emp Name</label>
            <select id="emp_name" name="emp_name" class="form-control" required>
                <option value="" disabled selected>Select an employee</option>
                @foreach ($emp_data as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="exp_amount">Expense Amount</label>
            <input type="number" id="exp_amount" name="exp_amount" step="0.01" class="form-control">
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
            <label for="remark">Remark</label>
            <input type="text" id="remark" name="remark" class="form-control">
        </div>
        <!-- <div class="form-group">
            <label for="siteName">Site Name</label>
            <select id="siteName" name="siteName" class="form-control">
                <option value="" disabled selected>Select a site</option>
                <option value="site1">Site 1</option>
                <option value="site2">Site 2</option>
                <option value="site3">Site 3</option>
            </select>
        </div> -->

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
                            <th>Emp name</th>
                            <th>Alloted amount</th>
                            <th>Expense Amount</th>
                            <th>Site name</th>
                            <th>Remark</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                       @foreach ($cashData as $data)
                        <tr>
                          <td class="py-1">{{$i}}</td>
                          <td>{{$data->emp_name ?? 'NA'}}</td>
                          <td>{{$data->alloted_amt}}</td>
                          <td>{{$data->expense_amt}}</td>
                          <td>{{ $data->site_name ?? 'NA' }}</td>
                          <td>{{$data->remark}}</td>
                          <td>
                            <div class="action_btn">
                                <button class="editbtn btn btn-light edit-product-btn" data-product-id="{{$data->id}}">Edit</button>
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
                    url: '{{ route("cash-manageme-add.save") }}',
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
            const url = `{{ url('/cash_manage_data') }}/${productId}`;
              fetch(url)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('form-title').innerText = 'Edit Cash';
                    document.getElementById('cm_id').value = data.id;
                    document.getElementById('alloted_amt').value = data.alloted_amt;
                    document.getElementById('emp_name').value = data.emp_name;
                    document.getElementById('exp_amount').value = data.expense_amt;
                    document.getElementById('siteName').value = data.site_name;
                    document.getElementById('remark').value = data.remark;
                    $('#Modal1').modal('show'); // Open the modal
                });
        });
    });


        });

        function openModal(type){
        document.getElementById('form-title').innerText = `${type} Cash`;
        $('#Modal1').modal('show');
    }
    </script>

          @endsection
