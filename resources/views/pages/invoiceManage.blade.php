@extends('component.header')
@section('title', 'Invoice Management')

@section('content')
<div>
          @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
          </div>
          <div class="content-wrapper">
            <div class="row">
              <div class="col-sm-12">
                  <div class="d-sm-flex align-items-center justify-content-between border-bottom">

                        <div class="btn-wrapper">
                          <a id="" href="{{route('invoice-add')}}" class="btn btn-primary text-white me-0 mb-2"><i class="fa fa-plus"></i> Add</a>
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
                            <th>Invoice Number</th>
                            <th>Customer Name</th>
                            <th>Invoice Date</th>
                            <th>P.O. Number</th>
                            <th>P.O. Date</th>
                            <th>Against</th>
                            <!-- <th>Description</th> -->
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                        <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data as $item)
                            <tr>
                                <td class="py-1">{{$i}}</td>
                                <td>{{$item->invoice_number}}</td>
                                <td>{{$item->customer_name}}</td>
                                <td>{{$item->invoice_date}}</td>
                                <td>{{$item->pono}}</td>
                                <td>{{$item->po_date}}</td>
                                <td>{{$item->Against}}</td>
                                <!-- <td>{{$item->description}}</td> -->
                                <td>{{$item->amount}}</td>
                                <td>
                                    <div class="action_btn">
                                        <a href="{{ route('invoice-pdf', ['invId' => $item->id]) }}" target="_blank" class="btn btn-success">
                                        <i class="mdi mdi-printer" title="Print"></i>
                                        </a>
                                        <!-- <button class="editbtn btn btn-light">Edit</button> -->
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

                document.querySelectorAll('.edit-product-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        const productId = this.dataset.productId;
                        const url = `{{ url('/invoice_list') }}/${productId}`;
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
                })
            });
    </script>

          @endsection
