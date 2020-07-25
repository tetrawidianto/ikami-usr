@extends('ikami-usr::layouts.master')

@section('content_body')
	@livewire('lak-asesmen', ['asesmen' => $asesmen])
@endsection