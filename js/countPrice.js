$(document).ready(function() {
    /* get the input element */
    var money =  $('#money').text();
    $('#product-quantity').on('change', function() {
        var productQuantity = $("#product-quantity").val();
        
        if(isNaN(productQuantity) || productQuantity <= 0) {
            productQuantity =1;
            $("#product-quantity").val(1);
        }
        /* update price */
        var totalPrice = money * productQuantity;
        /* round number */
        $('#money').text(totalPrice.toFixed(2));

    })
})