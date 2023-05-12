@extends('layouts.app')

@section('title', 'Dashboard')


@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
@endpush


@section('content')
    <div class="content">
        <h1>Places</h1>
        <form action="{{ route('place.store') }}" method="POST">
            @csrf
            <input type="hidden" value="{{$room->id}}" name="room_id">
            <button type="submit"> <a class="btn btn-success">Add New</a>
            </button>
        </form>
        <div class="container-fluid">
            <div class="row">
                @php
                    $x = 1;
                @endphp
                @foreach ($room->places as $place)

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats" style="background-color: green;">
                            <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons"></i>
                                </div>
                            </div>

                            <h3 class="card-title"><a href="{{ route('place.show', $place->id) }}"
                                    style="color: white">{{$x++}}</a>
                            </h3>
                            <div class="card-footer">
                                <div class="stats">
                                    <a style="color: white;"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


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
@endpush
