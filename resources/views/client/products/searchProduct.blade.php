<section class="bg0 p-t-75 p-b-120">

    <div class="container">
        <h2 class="p-b-30">Kết quả tìm kiếm cho: "{{ $query }}"</h2>

        @if ($products->isEmpty())
            <p>Không tìm thấy sản phẩm nào.</p>
        @else
            <div class="row isotope-grid">
                @foreach ($products as $product)
                    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                        <!-- Block2 -->
                        <div class="block2">
                            <div class="block2-pic hov-img0">
                                {{-- <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}"> --}}
                                <img src="{{ $product->image ? Storage::url($product->image) : asset('client/images/no-image-available.png') }}"
                                    class="card-img-top" alt="{{ $product->name }}">

                            </div>

                            <div class="block2-txt flex-w flex-t p-t-14">
                                <div class="block2-txt-child1 flex-col-l">
                                    <a href="{{ Route('client.product.show', $product->id) }}"
                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                        {{ $product->name }}
                                    </a>

                                    <span class="stext-105 cl3"> {{ number_format($product->price, 0, ',', '.') }} VNĐ
                                    </span>
                                </div>

                                <div class="block2-txt-child2 flex-r p-t-3">
                                    <a href="#" data-product-id="{{ $product->id }}"
                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                        <img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
                                            alt="ICON" />
                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                            src="images/icons/icon-heart-02.png" alt="ICON" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ number_format($product->price, 0, ',', '.') }} VNĐ</p>
                            <a href="{{ route('client.viewShow', $product->id) }}" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div> --}}
        @endif
    </div>

</section>
