if (document.readyState == 'loading') {
    document.addEventListener('DOMContentLoaded', ready)
} else {
    ready()
}

function ready() {
    /* add event listenner for remove buttons */
    var removeCartItemButtons = document.getElementsByClassName('del');
    for(var i=0; i<removeCartItemButtons.length; i++) {
        var removeButton = removeCartItemButtons[i];
        removeButton.addEventListener("click", removeCartItem);
    }
    /* add change event for quantity input */
    var quantityInputs = document.getElementsByClassName('quantity-input');
    for(var i=0; i< quantityInputs.length; i++) {
        var input =quantityInputs[i];
        input.addEventListener('change', quantityChanged)
    }

    /* purchase button clicked */
    document.getElementsByClassName('purchase-btn')[0].addEventListener('click', purchaseButtonClicked)
}

/* remove cart item */
function removeCartItem(event) {
    var removeButtonClicked = event.target;
    removeButtonClicked.parentElement.parentElement.remove();
    updateTotal();
}

/* when change input value */
function quantityChanged(event) {
    var quantityInputChanged = event.target;
    /* input dont accept negative number */
    if(isNaN(quantityInputChanged.value) || quantityInputChanged.value <=0) {
        quantityInputChanged.value =1 ;
    }
    updateTotal();
}

/* purchase button clicked */
function purchaseButtonClicked(e) {
    var cartItem = document.getElementsByClassName('cart-items')[0];
    var inCartItem = cartItem.getElementsByClassName('cart-row');
    var numberProductInCart = inCartItem.length;
    console.log(numberProductInCart);
    if (numberProductInCart == 0) {
        e.preventDefault();
        alert('KHÔNG THỂ MUA ĐƯỢC !!! Bạn không có bất kỳ sản phẩm nào trong giỏ hàng, hãy thêm sản phẩm vào giỏ hàng của bạn trước !!!');
    } else {
    alert('làm theo 2 bước nữa để mua đơn đặt hàng của bạn!');
    }
}
/* update toltal */
function updateTotal() {
    var cartProductTable = document.getElementById("cart-product");
    var cartRows = document.getElementsByClassName("cart-row");
    var total = 0;
    for(var i = 0; i < cartRows.length; i++) {
        var cartRow = cartRows[i];
        var priceEl = cartRow.getElementsByClassName("item-price")[0];
        var price = parseInt( priceEl.innerText.replace('$', '') );
        var quantityEl = cartRow.getElementsByClassName("quantity-input")[0];
        var quantity = quantityEl.value;
        /* calculate the total price */
        total += price * quantity;

    }
    /* round the value */
    total = Math.round(total * 100) / 100;
    /* update total value in html page*/
    document.getElementsByClassName("toltal-price")[0].innerText = "TOTAL: "+"$ " + total;
}