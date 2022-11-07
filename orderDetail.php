<?php
require "admin/adminFunction.php";
$conn = connect();
if (isset($_GET['order'])) {
    $orderID = $conn->real_escape_string($_GET['order']);
    $sql = "SELECT * FROM orders as o
        INNER JOIN customers as c ON o.customerID = c.customerID
        LEFT JOIN orderdetail as od ON o.orderID = od.orderID
        INNER JOIN product as p ON od.productID = p.productID
        INNER JOIN category as ct ON p.categoryID = ct.categoryID
        WHERE od.orderID = '$orderID' ORDER BY o.orderTime DESC
    ";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()){
        $order = $row;
    }
    
    $orderNo = '#'.sprintf('%05d', $orderID);
    $date = date("d/m/Y h:m-A", strtotime($order['orderTime']));

    $data = "
        Số hóa đơn.: {$orderNo} ------ Ngày: {$date} <br>
        <input type='hidden' name='orderID' value='{$orderID}'>
        Tên khách: {$order['customerName']}  ----- SĐT: {$order['phone']} <br>
        Địa chỉ giao hàng: {$order['dAdd']} <br>
        Tình trạng đơn hàng: {$order['orderStatus']} <br>
        <input type='hidden' name='orderStatus' value='{$order['orderStatus']}'>
        <table class='table table-hover'>
        <thead style='background-color: black; color:white'>
            <tr>
                <th style='text-align:center;'>Sản Phẩm</th>
                <th style='text-align:center;'>Giá</th>
                <th style='text-align:center;'>Số Lượng</th>
                <th style='text-align:center;'>Đơn vị</th>
                <th style='text-align:center;'>Tổng</th>
            </tr>
        </thead>
    ";

    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        $subtotal = $row['unitPrice']*$row['quantity'];
        $data .= "
        <tbody>
            <tr>
                <td style='text-align:center;'>{$row['productName']}</td>
                <td style='text-align:center;'>\${$row['orderDetailPrice']}</td>
                <td style='text-align:center;'>{$row['quantity']}</td>
                <td style='text-align:center;'>{$row['unit']}</td>
                <td style='text-align:center;'>\${$subtotal}</td>
            </tr>
        ";
    }
    $data .= "
        <tr style='background-color:black; color:white; font-weight:bold'>
            <td style='text-align:center;' colspan='4'>TỔNG TIỀN</td>
            <td>\${$order['orderValue']}</td>
        </tr>
    </tbody>
    </table>
    
    ";
    
    echo $data;
}
