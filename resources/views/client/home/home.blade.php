@extends('client.master')

@section('title', 'Trang chủ')

@section('content')
    @include('client.layouts.slide')
    @include('client.layouts.banner')
    @include('client.products.product')
    @include('client.layouts.modal')
@endsection
