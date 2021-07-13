<div class="masonry-wrapper" data-col-md="4" data-col-sm="2" data-col-xs="1" data-gap="30" data-radio="100%">
    <div class="ps-masonry">
        <div class="grid-sizer"></div>
        @foreach ($products as $product)
        <div class="grid-item kids">
            <div class="grid-item__content-wrapper">
                <x-product-item :product="$product" />
            </div>
        </div>
        @endforeach
    </div>
</div>