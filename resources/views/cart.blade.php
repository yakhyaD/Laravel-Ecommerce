@extends('layout')

@section('title', 'Shopping Cart')

@section('extra-css')

@endsection

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <a href="#">Home</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>Shopping Cart</span>
        </div>
    </div> <!-- end breadcrumbs -->

    <div class="cart-section container">
        <div>
            @if (session()->has('success_message'))
                <div class="alert alert-success">
                    {{ session()->get('success_message') }}
                </div>
            @endif

            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (Cart::count() > 0)
                <h2>{{ Cart::count() }} items in Shopping Cart</h2>

            <div class="cart-table">
                @foreach (Cart::content() as $item)
                <div class="cart-table-row">
                        <div class="cart-table-row-left">
                            <a href="#"><img src="{{ asset('img/products/'.$item->model->slug.'.jpg') }}" alt="item" class="cart-table-img"></a>
                            <div class="cart-item-details">
                                <div class="cart-table-item"><a href="#">{{ $item->model->name }}</a></div>
                                <div class="cart-table-description">{{ $item->model->details }}</div>
                            </div>
                        </div>
                        <div class="cart-table-row-right">
                            <div class="cart-table-actions">
                                <form action="{{ route('cart.destroy', $item->rowId) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cart-options">Remove</button>
                                </form>
                                <form action="{{ route('cart.switchToSaveForLater', $item->rowId) }}" method="post">
                                    @csrf
                                    <button type="submit" class="cart-options">Save for Later</button>
                                </form>
                            </div>
                            <div>
                                <select class="quantity" data-id="{{ $item->rowId }}">
                                @for ($i = 1; $i < 5 + 1; $i++)
                                    <option {{ $item->qty == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                                </select>
                            </div>
                            <div>{{ presentPrice($item->subtotal()) }}</div>
                        </div>
                </div> <!-- end cart-table-row -->
                @endforeach
            </div> <!-- end cart-table -->

            @else

            <h2>There is no items in Shopping Cart</h2>

            @endif

            <a href="#" class="have-code">Have a Code?</a>

            <div class="have-code-container">
                <form action="#">
                    <input type="text">
                    <button type="submit" class="button button-plain">Apply</button>
                </form>
            </div> <!-- end have-code-container -->

            <div class="cart-totals">
                <div class="cart-totals-left">
                    Shipping is free because we’re awesome like that. Also because that’s additional stuff I don’t feel like figuring out :).
                </div>

                <div class="cart-totals-right">
                    <div>
                        Subtotal <br>
                        Tax <br>
                        <span class="cart-totals-total">Total</span>
                    </div>
                    <div class="cart-totals-subtotal">
                        {{ presentPrice(Cart::subtotal()) }} <br>
                        {{ presentPrice(Cart::tax()) }} <br>
                        <span class="cart-totals-total">{{ presentPrice(Cart::total()) }}</span>
                    </div>
                </div>
            </div> <!-- end cart-totals -->

            <div class="cart-buttons">
                <a href="{{ route('shop.index') }}" class="button">Continue Shopping</a>
                <a href="{{ route('checkout.index') }}" class="button-primary">Proceed to Checkout</a>
            </div>

            @if (Cart::instance('SwitchToSaveForLater')->count() > 0)
            <h2>{{ Cart::instance('SwitchToSaveForLater')->count() }} items Saved For Later</h2>

            <div class="saved-for-later cart-table">
                @foreach (Cart::instance('SwitchToSaveForLater')->content() as $item)
                <div class="cart-table-row">
                    <div class="cart-table-row-left">
                        <a href="{{ route('shop.show', $item->model->slug) }}"><img src="/img/macbook-pro.png" alt="item" class="cart-table-img"></a>
                        <div class="cart-item-details">
                            <div class="cart-table-item"><a href="#">{{ $item->model->name }}</a></div>
                            <div class="cart-table-description">{{ $item->model->details }}</div>
                        </div>
                    </div>
                    <div class="cart-table-row-right">
                        <div class="cart-table-actions">
                            <form action="{{ route('saveForLater.destroy', $item->rowId) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cart-options">Remove</button>
                            </form>
                            <form action="{{ route('saveForLater.switchToCart', $item->rowId) }}" method="post">
                                @csrf
                                <button type="submit" class="cart-options">Add to Cart</button>
                            </form>
                        </div>
                        <div>{{ $item->model->presentPrice() }}</div>
                    </div>
                </div> <!-- end cart-table-row -->
                @endforeach
            </div> <!-- end saved-for-later -->
            @else

            <h2>There is no items in saved for later</h2>

            @endif
        </div>

    </div> <!-- end cart-section -->

    @include('partials.might-like')


@endsection

@section('extra-js')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        (function () {
            const className = document.querySelectorAll('.quantity')

            Array.from(className).forEach(function (element) {

                element.addEventListener('change', function() {
                    const id = element.getAttribute('data-id')

                    axios.patch(`/cart/${id}`, {
                        quantity: this.value
                    })
                    .then((response) => {
                        // console.log(response)
                        window.location.href = '{{ route('cart.index') }}'
                    })
                    .catch((error) => {
                        // console.log(error)
                        window.location.href = '{{ route('cart.index') }}'
                    })
                })
            })
        })()
    </script>
@endsection
