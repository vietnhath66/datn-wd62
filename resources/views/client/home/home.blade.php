
@extends('client.master')

@section('title', 'Trang Chủ')

@section('content')
    @include('client.layouts.slide')
    @include('client.layouts.banner')
    @include('client.products.product')
    @include('client.products.modal')
@endsection
