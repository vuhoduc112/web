//prevent resubmission when reload page:
if (window.history.replaceState) {
    window.history.replaceState(null, null, location.href);
}
/* Product page */
document.addEventListener('DOMContentLoaded', () => {

    //Refocus on the 1st input box after reset the form
    document.querySelector('#reset').onclick = () => {
        document.querySelector('input').focus();
    }
    //Validate category, a provided category must be selected before submitting new product
    var ctg = document.querySelector('#ctg');
    document.querySelector('#addproduct').onsubmit = (event) => {
        if (ctg.value === '0') {
            event.preventDefault();
            alert('Bạn phải chỉ định một danh mục.');
            ctg.focus();
        }
    }
    //Validate price (decimal number, greater than zero) before submitting new product
    var price = document.querySelector('#price');
    var priceCheck = /^[-+]?[0-9]*\.?[0-9]+$/;
    price.onblur = () => {
        if (price.value.length > 0) {
            if (priceCheck.test(price.value) === false || price.value < 0) {
                alert('Bạn phải nhập số thập phân dương cho đơn giá.');
                price.value = '';
                price.focus();
            }
        }
    }
    //Validate quantity (integer number, greate than zero) before submitting new product
    var quantity = document.querySelector('#quantity');
    var quantityCheck = /^[0-9]*$/;
    quantity.onblur = () => {
        if (quantity.value.length > 0) {
            if (quantityCheck.test(quantity.value) === false) {
                alert('Bạn phải nhập số nguyên dương cho số lượng ban đầu.');
                quantity.value = '';
                quantity.focus();
            }
        }
    }
});

/* jquery */
$(document).ready(function () {

    //get order detail for edit:
    $('.order-detail').click(function(){
        var orderID = $(this).attr("data-id");
        $.ajax({
            type: "get",
            url: "orderDetail.php",
            data: {order:orderID},
            success: function (data) {
                $('#order-detail').html(data);
            }
        });
    });
    //get product detail for edit:
    $('.edit-product').click(function() {
        var productID = $(this).attr("data-id"); //get the value of the attribute 'data-id' from the button when click
        $.ajax({
            url: "queryProduct.php",
            method: "post",
            data: {
                product: productID
            }, //the request name is 'product' and the value to be sent is the variable 'productID'
            success: function(data) { //with the data responsed from server, insert into the div id 'product-detail' and show the modal
                $('#product-detail').html(data);
            }
        });
    });
    //get user detail:
    $('.edit-user').click(function() {
        var userID = $(this).attr("data-id");
        $.ajax({
            url: "queryUser.php",
            method: "post",
            data: {
                user: userID
            },
            success: function(data) {
                $('#user-detail').html(data);
            }
        });
    });
    //get category detail:
    $('.edit-ctg').click(function () {
        var cID = $(this).attr("data-id");
        $.ajax ({
            url: "queryCategory.php",
            method: "post",
            data: {
                ctg: cID
            },
            success: function(data){
                $('#ctg-detail').html(data)
            }
        })
    })
});