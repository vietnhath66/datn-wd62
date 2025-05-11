@extends('client.master')

@section('title', 'Trang Chủ')

@section('content')
    @include('client.layouts.slide', ['bannerslide' => $bannerslide])
    @include('client.layouts.banner', ['banners' => $banners])
    @include('client.products.product')
    @include('client.productss.modal')
@endsection
