@extends('layouts.app')

@section('title', 'Dashboard')


@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
@endpush


@section('content')

    <div class="content">
        <div class="container-fluid">
            <a href="{{route('room.create')}}" class="btn btn-success">Add New</a>

            <div class="row">
                    @foreach ($rooms as $room)

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats" style="background-color: green;">
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons"></i>
                            </div>
                        </div>

                  <h3 class="card-title"><a href="{{route('room.show', $room->id)}}" style="color: white">{{$room->name}}</a>
                        </h3>
                        <div class="card-footer">
                            <div class="stats">
                    <a style="color: white;">Places - {{$room->places->count()}}</a>
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
