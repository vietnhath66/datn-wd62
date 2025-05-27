<div class="sec-banner bg-light p-t-80 p-b-50">
    <div class="container">
        <div class="row">
            @foreach($banners as $banner)
            <div class="col-md-6 col-xl-4 p-b-30">
                <div class="block1 shadow-sm">
                    <img src="{{ asset('client/images/' . $banner->image) }}" alt="IMG-BANNER" class="block1-img" />
                    <div class="block1-content">
                        <h3 class="block1-title">{{ $banner->title }}</h3>
                        <p class="block1-desc">{{ $banner->description ?? '' }}</p>
                        <a href="{{ $banner->link }}" class="block1-btn">Shop Now</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
.sec-banner {
    background-color: #f9f9f9;
}

.block1 {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.3s ease;
    box-shadow: 0 4px 15px rgb(0 0 0 / 0.1);
}

.block1:hover {
    transform: scale(1.03);
    box-shadow: 0 8px 25px rgb(0 0 0 / 0.15);
}

.block1-img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    display: block;
    filter: brightness(0.9);
    transition: filter 0.3s ease;
}

.block1:hover .block1-img {
    filter: brightness(1);
}

.block1-content {
    position: absolute;
    bottom: 20px;
    left: 20px;
    color: #222;
    background: rgba(255 255 255 / 0.8);
    padding: 20px 25px;
    border-radius: 10px;
    max-width: 90%;
    box-shadow: 0 4px 15px rgb(0 0 0 / 0.1);
}

.block1-title {
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0 0 8px 0;
}

.block1-desc {
    font-size: 1rem;
    margin-bottom: 15px;
    color: #555;
    line-height: 1.3;
}

.block1-btn {
    display: inline-block;
    background-color: #ff6f61;
    color: #fff;
    font-weight: 600;
    padding: 10px 25px;
    border-radius: 50px;
    text-decoration: none;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

.block1-btn:hover {
    background-color: #e6554a;
}

@media (max-width: 767px) {
    .block1-img {
        height: 220px;
    }
    .block1-content {
        bottom: 15px;
        left: 15px;
        padding: 15px 20px;
    }
    .block1-title {
        font-size: 1.4rem;
    }
    .block1-btn {
        padding: 8px 20px;
        font-size: 0.9rem;
    }
}
</style>
