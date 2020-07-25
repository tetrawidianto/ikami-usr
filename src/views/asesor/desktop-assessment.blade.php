@extends('ikami-usr::layouts.master')

@section('content_body')
	@livewire('rik-asesmen', ['asesmen' => $asesmen])
@endsection