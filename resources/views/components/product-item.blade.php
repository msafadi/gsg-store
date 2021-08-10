    <div class="ps-shoe mb-30">
        <div class="ps-shoe__thumbnail"><a class="ps-shoe__favorite" href="#"><i class="ps-icon-heart"></i></a><img src="{{ asset('assets/front/images/shoe/7.jpg') }}" alt=""><a class="ps-shoe__overlay" href="{{ route('product.details', $product->slug) }}"></a>
        </div>
        <div class="ps-shoe__content">
            <div class="ps-shoe__variants">
                <div class="ps-shoe__variant normal"><img src="{{ asset('assets/front/images/shoe/2.jpg') }}" alt=""><img src="{{ asset('assets/front/images/shoe/3.jpg') }}" alt=""><img src="{{ asset('assets/front/images/shoe/4.jpg') }}" alt=""><img src="{{ asset('assets/front/images/shoe/5.jpg') }}" alt=""></div>
                <select class="ps-rating ps-shoe__rating">
                    <option value="1">1</option>
                    <option value="1">2</option>
                    <option value="1">3</option>
                    <option value="1">4</option>
                    <option value="2">5</option>
                </select>
            </div>
            <div class="ps-shoe__detail"><a class="ps-shoe__name" href="{{ route('product.details', $product->slug) }}">{{ $product->name }}</a>
                <p class="ps-shoe__categories">{{ $product->category->name }}</p><span class="ps-shoe__price"> £ {{ $product->price }}</span>
            </div>
        </div>
    </div>