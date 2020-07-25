@extends('adminlte::page')

@section('content')
	@yield('content_body')
@endsection

@section('footer')
  <div class="float-right d-none d-sm-block">
     Indeks<b>KAMI</b> v1.0.0
  </div>
  <strong>Copyright © 2020 <a href="{{ env('APP_URL') }}">BSSN</a></strong>
@endsection

@push('css')
  <style>
    .nav-pills .nav-link.active {
      color: #6c757d;;
      background-color: #ffc107;
    }
    
  </style>
@endpush

@push('js')
  <script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
  </script>
@endpush
