if (document.readyState == 'loading') {
    document.addEventListener('DOMContentLoaded', ready)
} else {
    ready()
}

function ready() {
    var removeCartItemButtons = document.getElementsByClassName('remove');
    for(var i=0; i<removeCartItemButtons.length; i++) {
        var removeButton = removeCartItemButtons[i];
        removeButton.addEventListener("click", removeCartItem);
    }

    var quantityInputs = document.getElementsByClassName('quantity-input');
    for(var i=0; i< quantityInputs.length; i++) {
        var input =quantityInputs[i];
        input.addEventListener('change', quantityChanged)
    }
    /* add to cart */
    // var addToCartButtons = document.getElementsByClassName('AddToCart');

    // for (var i =0; i < addToCartButtons.length; i++) {
    //     var cartButton = addToCartButtons[i];
    //     cartButton.addEventListener('click', addToCart)
    // }
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
/* add to cart */
function addToCart(event) {
    var addToCartButttonClicked = event.target;
    var productCardEl = addToCartButttonClicked.parentElement.parentElement;
    /* take the title, imgSrc, price of the product*/
    var id = productCardEl.getElementsByClassName('pid')[0].innerText;
    var title = productCardEl.getElementsByClassName('product-name')[0].innerText;
    var imgSrc = productCardEl.getElementsByClassName('img')[0].src;
    var price = productCardEl.getElementsByClassName('product-price')[0].innerText;

    addProductToCart(id, title, imgSrc, price);
    cartButtonAnimate();
    updateTotal();
}

/* add product to cart */
function addProductToCart(id, title, imgSrc, price) {
    var cartRow = document.createElement("tr");
    cartRow.classList.add("cart-row");
    /* check if the product item is already in the cart ? */
    var cartItem = document.getElementsByClassName('cart-items')[0];

    var itemNames = cartItem.getElementsByClassName('item-name');
    for (var i = 0; i < itemNames.length; i++) {
        if (itemNames[i].innerText == title) {
            alert('This item is already added to the cart');
            return;
        }
    }
    /* draw cart row to cart table */
    var cartRowContent = `<tr>
        <td class="item-img">
            <img src="${imgSrc}" alt="">
            <span class="item-name">${title}</span>
            <input type="hidden" name='itemName[]' value="${title}">
            <input type="hidden" name='itemId[]' value="${id}">
            
        </td>
        <td class="price-col">
            <span class="item-price">${price}</span>
            <input type="hidden" name='itemPrice[]' value="${price}">
        </td>
        <td class="quantity-col"> 
            <input name='itemQuantity[]' type="number" min ="0" step="1" value="1" class="quantity-input">
            <a class="remove btn btn-danger">REMOVE</a>
        </td>
        </tr>`;
    cartRow.innerHTML = cartRowContent;
    /* append child onclick */
    document.getElementsByClassName('cart-items')[0].append(cartRow);
    /* add event on remove button and input */
    // cartRow.getElementsByClassName("remove")[0].addEventListener('click', removeCartItem);
    // cartRow.getElementsByClassName("quantity-input")[0].addEventListener('change', quantityChanged);
}
function cartButtonAnimate() {
    var cartButton = document.getElementsByClassName('scrollToCart')[0];
    var pos = 0;
    var id = setInterval(frame, 20);
    function frame() {
        pos++;
        cartButton.style.right = pos + 'px';
        if (pos>10) {
            clearInterval(id);
        }
    }
}
/* purchase button clicked */
function purchaseButtonClicked(event) {
    var cartItemsEl = document.getElementsByClassName('cart-items')[0];
    var numberItemIncart = cartItemsEl.getElementsByClassName('cart-row').length;
    if(numberItemIncart == 0) {
        event.preventDefault();
        alert('Bạn cần thêm một số sản phẩm vào giỏ hàng của mình trước!');
    } 
    // else {
    //     alert('We\' glad you choose our products. Please complete 2 steps more to place your order.');
    // }
}
/* update toltal */
function updateTotal() {
    var cartProductTable = document.getElementById("cart-product");
    var cartRows = document.getElementsByClassName("cart-row");
    var total = 0;
    for(var i = 0; i < cartRows.length; i++) {
        var cartRow = cartRows[i];
        var priceEl = cartRow.getElementsByClassName("item-price")[0];
        var price = parseInt( priceEl.innerText.replace('VND', '') );

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