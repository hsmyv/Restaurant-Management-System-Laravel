@extends('layouts.app')

@section('title', 'Dashboard')


@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
@endpush


@section('content')

    <div class="content">
        <a class="btn btn-success" data-toggle="modal" data-target="#addItemModal">Add Guests</a>
        <a class="btn btn-success" data-toggle="modal" data-target="#calculate">Calculate</a>
        <a href="{{route('receipt.show', $place->id)}}" class="btn btn-success">Receipts</a>

        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats" style="background-color: green;">
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons"></i>
                            </div>
                        </div>

                        <h3 class="card-title"><a href="" style="color: white"></a>
                        </h3>
                        <div class="card-footer">
                            <div class="stats">
                                <a style="color: white;">Order Price - {{$total_price}}</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

            <div class="col-md-12">
 <div class="row">
        <div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">

            <div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                            <td class="col-md-9">{{$order->name ?? ''}}</td>
                            <td class="col-md-3"><i class="fa fa-inr"></i> {{$order->price ?? ''}}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td class="text-right">
                            <p>
                                <strong>Total Price: </strong>
                            </p>
                            <p>
                                <strong>Received Price: </strong>
                            </p>
							<p>
                                <strong>Change Amount: </strong>
                            </p>
							</td>

                        </tr>

                    </tbody>
                </table>
            </div>

        </div>
	</div>

</div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Guests</h5>

                    <button id="addItem" class="ml-5 btn btn-info">Add Guest</button>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addQna">
                    @csrf
                    <div class="modal-body addModalItems">
                        <input type="hidden" name="placeId" value="{{$place->id}}">
                    </div>
                    <div class="modal-footer">
                        <span class="error" style="color:red;"></span>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="calculate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Calculate</h5>
                </div>
                <h3> Total - {{$total_price}}</h3>
                 <form action="{{route('calculatePrice')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="place_id" value="{{$place->id}}">
                        <input type="hidden" value="{{$total_price}}" name="totalPrice">
                        <input type="number" min="1" name="price" class="w-100">
                        <br><br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Calculate</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@push('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>



    <script>
        $(document).ready(function() {
            $("#addQna").submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{route('addOrder')}}",
                    type: "POST",
                    data:formData,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        }else{
                            alert(data.msg);
                        }

                    }
                });
            });

            $("#addItem").click(function(){
                 var html = '';
                                html = `
                                    <div class="row mt-1">
                                           <h4>Guest</h4>
                                        <div class="col">
                                             <select name="items[]" id="items" required class="form-control" multiple='mutliple'>
                                                    @foreach ($categories as $category) {
                                                        <optgroup label="{{$category->name}}">
                                                            @foreach ($category->items as $item )
                                                                <option value="{{$item->id}}" name="">{{ $item->name}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button class="btn btn-danger removeButton">Remove</button>
                                    </div>
                                `;

                            $(".addModalItems").append(html);
                        });
              $(document).on("click", ".removeButton", function() {
                $(this).parent().remove();
            });

        });
    </script>
@endpush
