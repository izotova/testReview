define(['jquery'], function ($) {
    return function (config, element) {
        var action = 'rest/V1/addNewReview';
        var requestType = 'POST';
        // set if user voted before
        console.log(config);
        if (config.review && config.review.rating) {
            $("#custom-rating").val(config.review.rating);
            action = 'rest/V1/updateReview/' + config.review.id;
            requestType = 'PUT';
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
                type: requestType,
                url: action,
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
