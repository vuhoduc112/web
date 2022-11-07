<?php
session_start();
include "adminFunction.php";
$conn = connect();
$roleName = 'admin';
$rolelist = [];
$result = $conn->query("SELECT roleID FROM staffrole");
while ($role = $result->fetch_assoc()) {
    $roleList[] = $role['roleID'];
}

echo "<br>";
print_r($roleList);
echo "<br><hr>";
$test = 2;
if (in_array($test, $roleList)) {
    echo "TRUE";
} else echo "FALSE";

// unset($_SESSION['cart1']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <hr>
    <h3>Test update Cart</h3>
    <br>
    <form action="" method="post" id='cart'>
        <table id='in-cart'>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>SubTotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Product1</td>
                    <td><input type="text" data-id='1' class='price' value='100'></td>
                    <td><input type="number" class='qtt' data-id='1' min='0' value='0'></td>
                    <td><input type="hidden" data-id='1' class='subtotal'><span data-id='1' class='visible-subtotal'></span></td>
                </tr>
                <tr>
                    <td>Product2</td>
                    <td><input type="text" data-id='2' class='price' value='123'></td>
                    <td><input type="number" data-id='2' class='qtt' min='0' value='0'></td>
                    <td><input type="hidden" data-id='2' class='subtotal'><span data-id='2' class='visible-subtotal'></span></td>
                </tr>
                <tr>
                    <td>Product3</td>
                    <td><input type="text" data-id='3' class='price' value='99'></td>
                    <td><input type="number" data-id='3' class='qtt' min='0' value='0'></td>
                    <td><input type="hidden" data-id='3' class='subtotal'><span data-id='3' class='visible-subtotal'></span></td>
                </tr>
            </tbody>
            <tr>
                <td colspan='2'>TOTAL:</td>
                <td colspan='2'><span class='total' id='sum'></span></td>
            </tr>
        </table>
        <div id='cart-return'></div>
    </form>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        updateCart();
        $('.qtt').on('input', function() {
            updateCart();
            $.get(
                url = "testCart.php",
                data = {
                id: $(this).attr('data-id'),
                qtt: $(this).val(),
            },
                success = function(data){
                    $('#cart-return').html(data)
                }
            )
        })

        function updateCart() {
            var sum = 0;
            var quantity;
            $('#in-cart > tbody > tr').each(function() { //Lặp qua các thẻ tr của tbody
                quantity = $(this).find('.qtt').val(); //Tìm giá trị của phần tử có class='qtt'
                var price = parseFloat($(this).find('.price').val()); //Tìm giá trị của phần tử có class='price'
                var subtotal = quantity * price;
                if (!isNaN(subtotal)) {
                    sum += subtotal;
                }
                $(this).find('.subtotal').val(subtotal);
                $(this).find('.visible-subtotal').text(subtotal);
            })
            $('#sum').text('$' + sum)
        }
    });
</script>

</html>
