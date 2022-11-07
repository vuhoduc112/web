<?php
require "adminFunction.php";
$conn = connect();
if (isset($_GET['order'])) {
    $orderID = $conn->real_escape_string($_GET['order']);
    $sql = "SELECT * FROM orders as o
        INNER JOIN customers as c ON o.customerID = c.customerID
        LEFT JOIN staff as s on o.staffID = s.staffID
        LEFT JOIN orderdetail as od ON o.orderID = od.orderID
        INNER JOIN product as p ON od.productID = p.productID
        INNER JOIN category as ct ON p.categoryID = ct.categoryID
        WHERE od.orderID = '$orderID'
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
                <td>{$row['productName']}</td>
                <td>\${$row['orderDetailPrice']}</td>
                <td>{$row['quantity']}</td>
                <td>{$row['unit']}</td>
                <td>\${$subtotal}</td>
            </tr>
        ";
    }
    $data .= "
        <tr style='background-color:black; color:white; font-weight:bold'>
            <td colspan='4'>TỔNG TIỀN</td>
            <td>\${$order['orderValue']}</td>
        </tr>
    </tbody>
    </table>
    <div class='input-group'>
        <span class='input-group-text'>Tinh trạng:</span>
        <button style='width: 120px' type='submit' name='cancel' class='btn btn-warning'>
            <i class='fa fa-ban' aria-hidden='true'></i> Cancel
        </button>
        <button style='width: 120px' type='submit' name='success' class='btn btn-success'>
            <i class='fa fa-check' aria-hidden='true'></i> Success
        </button>
    </div>
    ";
    
    echo $data;
}
