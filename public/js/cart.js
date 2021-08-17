(function($) {

    $('#add-to-cart').on('submit', function(e) {
        e.preventDefault();
        $.post($(this).attr('action') , $(this).serialize(), function(items) {
            $('.ps-cart__content').empty();
            for(i in items) {
                data = items[i];
                $('.ps-cart__content').append(`<div class="ps-cart-item"><a class="ps-cart-item__close" href="#"></a>
                    <div class="ps-cart-item__thumbnail"><a href="${data.product.permalink}"></a><img src="${data.product.image_url}" alt=""></div>
                    <div class="ps-cart-item__content"><a class="ps-cart-item__title" href="${data.product.permalink}">${data.product.name}</a>
                        <p><span>Quantity:<i>${data.quantity}</i></span><span>Total:<i>£${data.quantity * data.product.price}</i></span></p>
                    </div>
                </div>`);
            }
        });
    });

})(jQuery);