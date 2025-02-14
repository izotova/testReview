define(['jquery'], function ($) {
    return function (config, element) {
        // set if user voted before
        if (config.review && config.review.rating) {
            $("#custom-rating").val(config.review.rating);
        }

        $("#custom-rating").on('change', function () {
            var ratingValue = $(this).val();
            var review = config.review;
            var formData = {
                'review' : {
                    'product_id' : review.product_id,
                    'customer_id' : review.customer_id,
                    'rating': ratingValue
                }
            };
            $.ajax({
                type: "POST",
                url: 'rest/V1/addNewReview',
                data: JSON.stringify(formData),
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                success: function (response) {
                },
                error: function (response) {
                }
            });
        });
    }
});
