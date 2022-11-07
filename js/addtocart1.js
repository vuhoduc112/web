$(document).ready(function () {
    countCart(); //đếm số lượng sản phẩm trong giỏ hàng mỗi khi tài liệu được tải để hiển thị biểu tượng huy hiệu

    /*Sự kiện thúc đẩy bằng cách nhấp vào mỗi nút "thêm vào giỏ hàng" trên trang sản phẩm,
     Khi người dùng nhấp vào nút, một yêu cầu sẽ được gửi đến máy chủ*/
    $(document).on('click', '.2cart',  function(e) {
        e.preventDefault();
        var productID = $(this).attr('data-id'); //Thuộc tính data-id của nút chứa #id của sản phẩm
        var productName = $(this).attr('data-name'); //thuộc tính data-name của nút chứa # tên của sản phẩm

        //Kiểm tra xem sản phẩm đã được thêm vào chưa:
        //Chọn tất cả phần tử có tên hạng mục '
        //Lặp lại lựa chọn ở trên (các mục), với mỗi mục, hãy so sánh văn bản bên trong của nó với tên sản phẩm hiện tại
        //nếu khớp, hãy thông báo cho người dùng và dừng sự kiện bằng cách quay lại.
        items = document.querySelectorAll('.item-name'); 
        for (item of items) {
            if (item.innerText == productName) {
                alert('Mặt hàng này đã có trong giỏ hàng của bạn!');
                return;
            }
        }
        //Gửi yêu cầu bằng phương thức ajax
        $.ajax({
            url: "cart1.php", //tệp tiếp tục yêu cầu
            method: "get", //phương pháp của yêu cầu
            data: {
                id: productID, //dữ liệu được gửi
                name: productName,
            },
            success: function (data) { //chức năng gọi lại khi yêu cầu thành công
                $('.cart-items').append(data); //nối dữ liệu html được tạo bởi cart1.php vào phần tử chứa mục giỏ hàng
                updateCart(); //gọi hàm để tính toán giá trị của giỏ hàng
                countCart(); //gọi hàm để tính sản phẩm trong giỏ hàng
            }
        });

    });

    /*change item quantity in the cart array: 
    This function triggers on the event when user change the quantity input of each product in cart
    It should be triggered on document scale, since the 'cart-item' element which contain the 'quantity-input' is dymanically added after the page is loaded.
    */
    $(document).on('input', '.quantity-input', function () {
        updateCart(); //Call function to calculate value of the cart each time user change the quantity
        var productID = $(this).attr('data-id'); //The data-id attribute of the button contain the #id of the product
        var qtt = $(this).val(); //the new quantity of the product
        if(qtt <=0 ) {
            qtt = 1;
            $(this).val(1);
        }
        var sum = parseInt($('#sum').text()); //the new total value in cart

        //Send all the above data to server
        $.ajax({
            url: 'changeCart.php', //the file that will update the cart array in a session[] variable
            method: 'get',
            data: {
                id: productID,
                qtt: qtt,
                sum: sum
            }, //no callback function needed, we only need to update the cart session array
        })
    })

    /*remove item from cart array*/
    $('.cart-items').on('click', '.remove', function () {
        var removeID = $(this).attr('data-id'); //get the id of the product to be removed from cart
        //send request
        $.ajax({
            url: 'changeCart.php', //this file will proceed the remove function
            method: 'get',
            data: {
                removeID: removeID
            },
            success: function () { //callback function: update cart value and count item
                updateCart();  
                countCart();
            }
        })
        $(this).closest('tr').remove();  //remove the element from the page
    })

    //function to update value in cart, include: subtotal of each product, total value
    function updateCart() {
        var sum = 0;
        var quantity;
        $('#cart-product > tbody > tr').each(function () {
            quantity = $(this).find('.quantity-input').val();
            var price = parseInt($(this).find('.price').val());
            if(quantity<=0) {
                quantity = 1;
            }
            var subtotal = quantity * price;
            if (!isNaN(subtotal)) {
                sum += subtotal;
            }
            $(this).find('.subtotal').val(Number(subtotal).toFixed(0));
            $(this).find('.visible-subtotal').text(Number(subtotal).toFixed(0));
        })
        $('#sum').text(Number(sum).toFixed(0));
    }

    /*Prevent 'go to cart' if nothing in cart
    On event 'click', check the length of the collection 'cartItem', 
    if equal to zero then preven the default function of the button
    */
    $('.gocart').on('click', function (e) {
        var cartItem = document.querySelectorAll('.cart-row'); 
        if (cartItem.length == 0) {
            e.preventDefault(); 
            alert('Please add something to your cart first.');
            return;
        }
    })
    //Prevent 'check out' if nothing in cart
    $('#checkout').on('click', function (e) {
        var cartItem = document.querySelectorAll('.cart-row');
        if (cartItem.length == 0) {
            e.preventDefault();
            alert('Please add something to your cart first.');
            return;
        }
    })
    
    //count item currently in cart:
    function countCart(){
        var cartItem = document.querySelectorAll('.cart-row');
        var count = cartItem.length;
        $('#badge').text(count); //update the inner text of the badge to show the number of product in cart
        if(count == 0) { //if the count equal to zero then don't display the badge icon
            $('#badge').text('');
        }
    }
});