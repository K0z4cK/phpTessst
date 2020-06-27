@extends('base')

@section('main')

    @include("products.show-style")

    <div class="wrapper con">

        <main>
            <div id="shopify-section-product-template" class="shopify-section">
                <div class="single-product-area mt-80 mb-80">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="container">
                                    <section id="default" class="padding-top0">
                                        <div class="row">

                                            <hr>
                                            <div class="large-5 column">
                                                <div class="xzoom-container">

                                                    <img class="xzoom" id="xzoom-default"
                                                         xoriginal={{'/images/840_'.$product->productImages[0]->name}} src={{'/images/840_'.$product->productImages[0]->name}}  />
                                                    <div class="xzoom-thumbs">
                                                        @foreach ($product->productImages as $image)
                                                            <a href={{'/images/840_'.$image->name}} >
                                                                <img class="xzoom-gallery" style=" object-fit: contain;" width="80" height="80" src={{'/images/420_'.$image->name}} >
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="large-7 column"></div>
                                        </div>
                                    </section>
                                    <!-- default end -->
                                </div>
                            </div>
                            <div class="col-md-7">


                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="single-product-content" style="margin-top:35px;">

                                            <input type="hidden" name="form_type" value="product"><input type="hidden" name="utf8" value="✓">
                                            <div class="product-details">

                                                <h1 class="single-product-name">
                                                    {{$product->name}}

                                                </h1>


                                                <div class="single-product-price">
                                                    <div class="product-discount">
                                                    <span class="price" id="ProductPrice">
                                                        <span class="money">
                                                            {{$product->price}}
                                                        </span>
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="product-info">{!! $product->description !!}</div>

                                                <div class="single-product-action">
                                                    <div class="product-variant-option">
                                                        <select name="id" id="productSelect" class="product-single__variants" style="display:none;">
                                                            <option selected="selected" data-sku="YQT71020193" value="19506517377094">Default Title - $20.66 USD</option>

                                                        </select>

                                                    </div>
                                                    <style>
                                                        .product-variant-option .selector-wrapper {
                                                            display: none;
                                                        }
                                                    </style>
                                                    <div class="product-add-to-cart">
                                                        <span class="control-label">Quantity</span>
                                                        <div class="cart-plus-minus">
                                                            <input class="cart-plus-minus-box" type="text" name="quantity" value="1">
                                                        </div>
                                                        <div>
                                                            <a asp-controller="Product" asp-action="AddToCart" asp-route-id="@Model.Product.Id" style="text-decoration: inherit;color:inherit; position: inherit; ">
                                                                <button class="btn btn-primary">Order</button>
                                                            </a>
                                                            <div class="flex-row mt-3" style="display:flex; align-self:center; align-items:center;">



                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <style type="text/css">
                    .product-details .countdown-timer-wrapper {
                        display: none !important;
                    }
                </style>

            </div>
        </main>
    </div>

@endsection

@section('scripts')
    @include("products.show-js")
@endsection
