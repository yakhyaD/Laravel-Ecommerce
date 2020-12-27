@extends('layout')

@section('title', 'Product')

@section('extra-css')

@endsection

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <a href="/">Home</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <a href="{{ route('shop.index') }}"><span>Shop</span></a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>{{ $product->name }}</span>
        </div>
    </div> <!-- end breadcrumbs -->

    <div class="product-section container">
        <div>
            <div class="product-section-image">
                <img src="{{ productImage($product->image) }}" alt="product" class="active" id="currentImage">
            </div>
            <div class="product-section-images">
                <div class="product-section-thumbnail selected">
                    <img src="{{ productImage($product->image) }}" alt="product">
                </div>

                @if ($product->images)
                    @foreach (json_decode($product->images, true) as $image)
                        <div class="product-section-thumbnail">
                            <img src="{{ productImage($image) }}" alt="product">
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="product-section-information">
            <h1 class="product-section-title">{{ $product->name }}</h1>
            <div class="product-section-subtitle">{{ $product->details }}</div>
            <div class="product-section-price">{{ $product->presentPrice() }}</div>

            <p>
                {!! $product->description !!}
            </p>

            <p>&nbsp;</p>
            <form action="{{ route('cart.store', $product) }}" method="post">
                @csrf
                <button type="submit" class="button button-plain">Add to Cart</button>
            </form>
        </div>
    </div> <!-- end product-section -->

    @include('partials.might-like')

@endsection

@section('extra-js')
    <script>
        const currentImage = document.getElementById('currentImage')
        const images = document.querySelectorAll('.product-section-thumbnail')

        images.forEach((element) => element.addEventListener('click', thumbnailClick))

        function thumbnailClick(e) {
            currentImage.classList.remove('active')

            currentImage.addEventListener('transitionend', () => {
                currentImage.src = this.querySelector('img').src
                currentImage.classList.add('active')
            })

            images.forEach(element => element.classList.remove('selected'))
            this.classList.add('selected')
        }
    </script>
@endsection
