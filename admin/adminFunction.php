<?php
include 'database.php';
//admin login function
function adminLogin($userName, $password)
{
    $login = [];
    $conn = connect();
    $sql = "SELECT * FROM staff WHERE userName = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param("s", $userName);
    $stm->execute();
    $result = $stm->get_result();
    $stm->close();
    //check if username is valid:
    if ($result->num_rows === 1) {
        while ($rows = $result->fetch_assoc()) {
            //if username is valid, then check the password:
            if (password_verify($password, $rows['password']) === TRUE) {
                $login['userID'] = $rows['staffID'];
                $login['userName'] = $rows['userName'];
                $login['userRole'] = $rows['roleID'];
                $login['userEmail'] = $rows['email'];
            } else {
                $login['error'] = "Sai tên đăng nhập hoặc mật khẩu";
            }
            //if the password is correct, check the user status:
            if ($rows['status'] === 0) {
                $login['error'] = "Tài khoản của bạn đã bị quản trị viên tạm ngưng.";
            }
        }
    } else {
        $login['error'] = "Sai tên đăng nhập hoặc mật khẩu";
    }
    return $login;
}

function admin_AddProduct($name, $price, $detail, $categoryID, $imgURL)
{
    $conn = connect();

    //Check if product name exist:
    $sql = "SELECT productName FROM product WHERE productName = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param("s", $name);
    $stm->execute();
    $checkPName = $stm->get_result();
    $stm->close();
    if ($checkPName->num_rows > 0) {
        $error = "Tên sản phẩm đã tồn tại trong cơ sở dữ liệu.";
        return $error;
    } else {
        //insert product:
        $sql = "INSERT INTO product (productName, unitPrice, productDetail, categoryID, imgURL) VALUES (?,?,?,?,?)";
        $stm = $conn->prepare($sql);
        $stm->bind_param("sssis", $name, $price, $detail, $categoryID, $imgURL);
        if ($stm->execute()) {
            return TRUE;
        } else {
            $error = "Không thể thêm sản phẩm do lỗi cơ sở dữ liệu.";
            return $error;
        }
    }
    $conn->close();
}

function admin_findImg($id)
{
    $conn = connect();
    $id = $conn->real_escape_string($id);
    $result = $conn->query("SELECT imgURL FROM product WHERE productID = '$id'");
    if ($result->num_rows > 0) {
        while ($r = $result->fetch_assoc()) {
            $img = $r['imgURL'];
        }
        return $img;
    } else return false;
    $conn->close();
}

// function admin_removeProduct($pid)
// {
//     $conn = connect();
//     $sql = "DELETE FROM product WHERE productID = '$pid'";
//     $conn->query($sql);
//     $conn->close();
// }

function admin_displayProduct($search, $order)
{
    $conn = connect();
    $search = $conn->real_escape_string($search);
    $sql = "SELECT pd.imgURL, pd.productID, pd.productName, ct.categoryName, pd.productDetail, pd.unitPrice, pd.status, ct.unit
    FROM product as pd 
    INNER JOIN category as ct ON pd.categoryID = ct.categoryID 
    WHERE pd.productName LIKE CONCAT('%', '$search', '%') OR ct.categoryName LIKE CONCAT('%', '$search', '%')
    " . $order;
    $list = $conn->query($sql);
    if ($list->num_rows > 0) {
        echo "<table style='table-layout:fixed' class='tbl table table-striped table-hover'>
                <tr class='head'>
                    <th style='width:2%; vertical-align: middle;'>STT.</th>
                    <th style='width:15%'>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th style='width:40%;'>Chi tiết sản phẩm</th>
                    <th>Giá</th>
                    <th>Tình Trạng</th>
                    <th style='width:15%'>Quản Lý</th>
                </tr>
            ";
        $i=1;
        while ($item = $list->fetch_assoc()) {?>
            
            <tr>
                <td><?=$i?></td>
                <td>
                    <p><img src="..\\<?= $item['imgURL'] ?>" alt="image" style="width:50%; height:50%"></p>
                    <p><b><?= $item['productName'] ?></b></p>
                </td>
                <td style=''><?= $item['categoryName'] ?></td>
                <td style='text-align:justify; padding-left:20px;font-size:16px'><?= $item['productDetail'] ?></td>
                <td style='font-size:15px'>$<?= $item['unitPrice'] ?>/<?= $item['unit'] ?></td>
                <td><?php if ($item['status'] == 1) {
                        echo "Đang bán";
                    } else {
                        echo "Ngừng sản xuất";
                    } ?></td>
                <td class="edit"><button class="item-list btn btn-success edit-product" data-bs-toggle="modal" data-id="<?= $item['productID'] ?>" data-bs-target="#editPanel">Cập nhập</button></td>
            </tr>

        <?php $i++;  }
        echo "</table>";
    } else {
        echo "<table class='table'><tr><td><b>Không tìm thấy sản phẩm.</b></td></tr></table>";
    }
}

function admin_updateProduct($pid, $pname, $price, $category, $detail, $imgURL, $status)
{
    $conn = connect();
    $error = [];

    //validate name:
    if (empty($pname)) {
        $error['name'] = "Bạn phải nhập tên sản phẩm.";
    } else {
        $sql_checkName = "SELECT productName FROM product WHERE productName = ? AND productID != ?";
        $stm = $conn->prepare($sql_checkName);
        $stm->bind_param("si", $pname, $pid);
        $stm->execute();
        $result = $stm->get_result();
        $stm->close();
        if ($result->num_rows > 0) {
            $error['name'] = 'Tên sản phẩm bạn nhập đã tồn tại trong database.';
        }
    }
    //validate price:
    if (empty($price)) {
        $error['price'] = 'You must enter unit price.';
    } elseif (preg_match('/^[+]?[0-9]*\.?[0-9]+$/', $price) == 0) {
        $error['price'] = 'Đơn giá phải là số thập phân dương.';
    }
    //validate detail:
    if (empty($detail)) {
        $error['detail'] = 'Bạn phải nhập chi tiết sản phẩm.';
    }

    //validation result:
    if (count($error) > 0) {
        return $error;
    } else {
        //if no image change:
        if (empty($imgURL)) {
            $sql = "UPDATE product SET productName = ?, unitPrice = ?, categoryID = ?, productDetail = ?, `status` = ? WHERE productID = ?";
            $stm = $conn->prepare($sql);
            $stm->bind_param("sdisii", $pname, $price, $category, $detail, $status, $pid);
            $stm->execute();
            $stm->close();
        } else { //if change image:
            //unlink old image before insert new URL:
            $img = $conn->query("SELECT imgURL FROM product WHERE productID = '$pid'");
            while ($row = $img->fetch_assoc()) {
                $oldimgURL = $row['imgURL'];
            }
            unlink('../' . $oldimgURL);

            //update record:
            $sql = "UPDATE product SET productName = ?, unitPrice = ?, categoryID = ?, productDetail = ?, imgURL = ?, `status` = ? WHERE productID = ?";
            $stm = $conn->prepare($sql);
            $stm->bind_param("sdissii", $pname, $price, $category, $detail, $imgURL, $status, $pid);
            $stm->execute();
            $stm->close();
        }
        return true;
    }
    $conn->close();
}

function admin_displayUser($search)
{
    $conn = connect();
    $search = $conn->real_escape_string($search);
    $sql = "SELECT s.staffID, s.userName, s.status, sr.roleName, s.email, SUM(CASE WHEN o.orderStatus = 'success' THEN o.orderValue ELSE 0 END) as totalSale, COUNT(o.orderStatus) as totalOrder, COUNT(CASE WHEN o.orderStatus = 'success' THEN o.orderStatus END) as successOrder
    FROM staff as s
    INNER JOIN staffrole as sr ON s.roleID = sr.roleID
    LEFT JOIN orders as o ON s.staffID = o.staffID
    GROUP BY s.staffID HAVING s.userName LIKE '%$search%' OR sr.roleName LIKE '%$search%'
    ORDER BY s.staffID";
    $list = $conn->query($sql);
    if ($list->num_rows > 0) {
        echo "<table class='tbl table table-striped table-hover'>
                <tr class='head'>
                    <th>ID</th>
                    <th>Tên người dùng</th>
                    <th>Tình trạng</th>
                    <th>Loại</th>
                    <th>Tỏng Hoá Đơn</th>
                    <th>Thành công</th>
                    <th>Đánh giá</th>
                    <th>Tổng sale</th>
                    <th>Quản lý</th>
                </tr>
            ";
        while ($item = $list->fetch_assoc()) { ?>
            <tr>
                <td><?= $item['staffID'] ?></td>
                <td><?= $item['userName'] ?></td>
                <td><?= $item['status'] == 1 ? 'Hoạt động' : 'Thôi việc' ?></td>
                <td><?= $item['roleName'] ?></td>
                <td><?= $item['totalOrder'] ?></td>
                <td><?= $item['successOrder'] ?></td>
                <td><?= $item['totalOrder'] > 0 ? number_format($item['successOrder'] / $item['totalOrder'] * 100, 0) : 0 ?>%</td>
                <td>$<?= number_format($item['totalSale'], 2) ?></td>
                <td class="edit"><button class="item-list btn btn-success edit-user" data-bs-toggle="modal" data-id="<?= $item['staffID'] ?>" data-bs-target="#editPanel">Sửa</button></td>
            </tr>

        <?php   }
        echo "</table>";
    } else {
        echo "<table class='table'><tr><td><b>Không tìm thấy sản phẩm.</b></td></tr></table>";
    }
    $conn->close();
}

function admin_addUser($uname, $email, $pass, $repass, $role)
{
    $conn = connect();
    $error = [];
    $result = '';
    //validate input data:
    //name:
    $uname = trim($uname);
    if (strlen($uname) < 2) { //first, a name must equal or longer than 2 characters.
        $error['name'] = 'Tên khách hàng phải có ít nhất 2 ký tự.';
    } elseif (preg_match('/^[A-Za-z0-9_- ]*$/', $uname) === 0) {
        $error['name'] = 'Tên người dùng chỉ có thể chứa các ký tự chữ và số, "-" và "_".';
    } else {
        $uname = $conn->real_escape_string($uname);
        $checkName = $conn->query("SELECT * FROM staff WHERE userName = '$uname'");
        if ($checkName->num_rows > 0) {
            $error['name'] = 'Tên người dùng bạn nhập đã được sử dụng.';
        }
    }
    //email:
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = 'Địa chỉ email bạn nhập không hợp lệ.';
    } else {
        $checkMail = $conn->query("SELECT * FROM staff WHERE email = '$email'");
        if ($checkMail->num_rows > 0) {
            $error['mail'] = 'Email bạn nhập đã được sử dụng.';
        }
    }
    //pass:
    if (strlen($pass) < 6) {
        $error['pass'] = 'Mật khẩu phải chứa ít nhất 6 ký tự.';
    }
    if (strcmp($pass, $repass) != 0) {
        $error['pass'] = 'Mật khẩu thứ hai bạn nhập lại không khớp với mật khẩu đầu tiên.';
    }
    //role
    $checkRole = $conn->query("SELECT roleID FROM staffrole");
    while ($row = $checkRole->fetch_assoc()) {
        $roleList[] = $row['roleID'];
    }
    if (!in_array($role, $roleList)) {
        $error['role'] = "Bạn phải chọn một loại tài khoản.";
    }

    //after validate:
    if (count($error) == 0) {
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO staff (userName, email, password, roleID) VALUES (?, ?, ?, ?)";
        $stm = $conn->prepare($sql);
        $stm->bind_param("sssi", $uname, $email, $pass, $role);
        if ($stm->execute()) {
            $result = TRUE;
        } else {
            $result = FALSE;
        }
        return $result;
    } else {
        return $error;
    }
    $conn->close();
}

function admin_updateUser($uid, $uname, $email, $pass, $repass, $role, $status)
{
    $conn = connect();
    $error = [];
    $result = '';
    //validate input data:
    //name:
    $uname = trim($uname);
    if (strlen($uname) < 2) { //first, a name must equal or longer than 2 characters.
        $error['name'] = 'Tên người dùng phải chứa ít nhất 2 ký tự.';
    } elseif (preg_match('/^[A-Za-z0-9_-]*$/', $uname) === 0) {
        $error['name'] = 'Tên người dùng chỉ có thể chứa các ký tự chữ và số, "-" và "_".';
    } else {
        $uname = $conn->real_escape_string($uname);
        $checkName = $conn->query("SELECT * FROM staff WHERE userName = '$uname' AND staffID != '$uid'");
        if ($checkName->num_rows > 0) {
            $error['name'] = 'Tên người dùng bạn nhập đã được sử dụng.';
        }
    }
    //email:
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = 'Địa chỉ email bạn nhập không hợp lệ.';
    } else {
        $checkMail = $conn->query("SELECT * FROM staff WHERE email = '$email' AND staffID != '$uid'");
        if ($checkMail->num_rows > 0) {
            $error['mail'] = 'Email bạn nhập đã được sử dụng.';
        }
    }
    //pass:
    if (!empty($pass) && strlen($pass) < 6) {
        $error['pass'] = 'Mật khẩu phải chứa ít nhất 6 ký tự.';
    }
    if (!empty($pass) && !empty($repass) && strcmp($pass, $repass) != 0) {
        $error['pass'] = 'Mật khẩu thứ hai bạn nhập lại không khớp với mật khẩu đầu tiên.';
    }
    //role
    $checkRole = $conn->query("SELECT roleID FROM staffrole");
    while ($row = $checkRole->fetch_assoc()) {
        $roleList[] = $row['roleID'];
    }
    if (!in_array($role, $roleList)) {
        $error['role'] = "Bạn phải chọn một loại tài khoản.";
    }
    //after validation:
    if (count($error) === 0) {
        if (!empty($pass)) {
            $pass = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "UPDATE staff SET userName = ?, email = ?, password = ?, roleID = ?, status = ? WHERE staffID = ?";
            $stm = $conn->prepare($sql);
            $stm->bind_param("sssiii", $uname, $email, $pass, $role, $status, $uid);
            $stm->execute();
            $query = $stm->get_result();
            $stm->close();
        } else {
            $sql = "UPDATE staff SET userName = ?, email = ?, roleID = ?, status = ? WHERE staffID = ?";
            $stm = $conn->prepare($sql);
            $stm->bind_param("ssiii", $uname, $email, $role, $status, $uid);
            $stm->execute();
            $query = $stm->get_result();
            $stm->close();
        }

        return TRUE;
    } else {
        return $error;
    }
    $conn->close();
}

function user_updateEmail($id, $email)
{
    $conn = connect();
    $error = '';
    //check email:
    if (empty($email)) {
        $error = "Email không thể để trống";
    } else {
        //validate email string if not empty:
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Địa chỉ email không hợp lệ.";
        } else {
            //check if email already taken by other user:
            if (is_numeric($id)) {
                $checkEmail = $conn->query("SELECT * FROM staff WHERE staffID != '$id' AND email = '$email'");
                if ($checkEmail->num_rows > 0) {
                    $error = "Email đã được người dùng khác sử dụng.";
                }
            } else {
                $error = 'id không hợp lệ.';
            }
        }
    }
    if ($error != '') {
        return $error;
    } else {
        $sql = "UPDATE staff SET email = '$email' WHERE staffID = '$id'";
        if ($conn->query($sql)) {
            return TRUE;
        } else {
            $error = "Không thể thay đổi email do lỗi cơ sở dữ liệu.";
            return $error;
        }
    }
    $conn->close();
}

function user_changePass($id, $oldPass, $newPass, $rePass)
{
    $conn = connect();
    $error = '';
    //validate old pass
    if (is_numeric($id)) {
        $query = $conn->query("SELECT * FROM staff WHERE staffID = '$id'");
        $userInfo = $query->fetch_object();
        if (!password_verify($oldPass, $userInfo->password)) {
            $error = 'Mật khẩu cũ không chính xác';
        } else {
            if (strcmp($newPass, $rePass) != 0) {
                $error = 'Mật khẩu bạn đã nhập lại không khớp';
            }
        }
    } else {
        $error = 'ID người dùng không hợp lệ.';
    }

    if ($error != '') {
        return $error;
    } else {
        $newPass = password_hash($newPass, PASSWORD_DEFAULT);
        $sql = "UPDATE staff SET password = '$newPass' WHERE staffID = '$id'";
        if ($conn->query($sql)) {
            return TRUE;
        } else {
            $error = "Không thể cập nhật mật khẩu do lỗi cơ sở dữ liệu.";
        }
    }

    $conn->close();
}

function admin_displayCategory()
{
    $conn = connect();
    $sql = "SELECT c.categoryID, c.categoryName, c.categoryDetail, c.unit, c.status, COUNT(p.categoryID) as 'Total product'
        FROM category as c LEFT JOIN product as p ON c.categoryID = p.categoryID
        GROUP BY c.categoryID
    ";
    $result = $conn->query($sql);
    echo "<table style='table-layout:fixed' class='tbl table table-striped table-hover'>
                <tr class='head'>
                    <th style='width:20px'>STT</th>
                    <th style='width:12%'>Danh mục</th>
                    <th style='width:53%'>Miêu Tả</th>
                    <th>Tổng sản phẩm</th>
                    <th style='width:7%'>Đơn vị</th>
                    <th>Tình trạng</th>
                    <th>Quản lý</th>
                </tr>
            ";
    while ($cat = $result->fetch_assoc()) : ?>
        <tr>
            <td><?= $cat['categoryID'] ?></td>
            <td><?= $cat['categoryName'] ?></td>
            <td style='text-align:justify'><?= $cat['categoryDetail'] ?></td>
            <td><?= $cat['Total product'] ?></td>
            <td><?= $cat['unit'] ?></td>
            <td><?= $cat['status'] == 1 ? 'Hoạt động' : 'Không hoạt động' ?></td>
            <td><button class='btn btn-success edit-ctg' data-bs-toggle='modal' data-bs-target='#editCtg' data-id='<?= $cat['categoryID'] ?>' style='width:80px'>Sửa</button></td>
        </tr>
        <?php endwhile;
    echo "</table>";
    $conn->close();
}

function admin_getCategoryName($id)
{
    $conn = connect();
    $sql = "SELECT categoryName FROM category WHERE categoryID = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param("s", $id);
    $stm->execute();
    $result = $stm->get_result();
    $stm->close();
    if ($result->num_rows > 0) {
        foreach ($result as $value) {
            $name = $value['categoryName'];
        }
        return $name;
    }
}

function admin_addCategory($cname, $cunit, $detail)
{
    $conn = connect();
    $error = [];
    $sql = "INSERT INTO category (categoryName, unit, categoryDetail) VALUES (?, ?, ?)";
    //Validate name:
    if (empty($cname)) {
        $error['name'] = 'Bạn phải nhập tên cho danh mục mới';
    }
    if (!preg_match('/^[a-zA-Z0-9-_ ]*$/', $cname)) {
        $error['name'] = 'Tên chỉ được chứa ký tự chữ và số.';
    }
    $check_sql = "SELECT * FROM category WHERE categoryName = ?";
    $stm = $conn->prepare($check_sql);
    $stm->bind_param("s", $cname);
    $stm->execute();
    $checkName = $stm->get_result();
    if ($checkName->num_rows > 0) {
        $error['name'] = "Tên danh mục đã tồn tại.";
    }
    //validate unit:
    if (empty($cunit)) {
        $error['unit'] = 'Bạn phải nhập số lượng đơn vị.';
    }
    if (!preg_match('/^[a-zA-Z0-9-_]*$/', $cunit)) {
        $error['unit'] = 'đơn vị chỉ được chứa ký tự chữ và số.';
    }
    if (empty($detail)) {
        $error['detail'] = 'Bạn phải nhập một số mô tả cho danh mục mới';
    }
    if (count($error) > 0) {
        return $error;
    } else {
        $stm = $conn->prepare($sql);
        $stm->bind_param("sss", $cname, $cunit, $detail);
        if ($stm->execute()) {
            return true;
        } else {
            $error['database'] = 'Không thể nối dữ liệu vào cơ sở dữ liệu, hãy thử lại.';
            return $error;
        }
    }
    $conn->close();
}

function admin_updateCategory($id, $name, $detail, $unit, $status)
{
    $conn = connect();
    $error = [];
    if (empty($name)) {
        $error['name'] = "Bạn phải nhập tên cho danh mục";
    }
    if (is_numeric($id)) {
        $name = $conn->real_escape_string($name);
        $findName = $conn->query("SELECT * FROM category WHERE categoryName = '$name' AND categoryID != '$id'");
        if ($findName->num_rows > 0) {
            $error['name'] = "Tên danh mục bạn vừa nhập đã tồn tại.";
        }
    } else {
        $error['id'] = 'Không tồn tại ID.';
    }

    if (!preg_match('/^([a-zA-Z0-9ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+)$/i', $name)) {
        $error['name'] = "Tên chỉ được chứa các ký tự chữ và số.";
    }
    if (empty($detail)) {
        $error['detail'] = "Bạn phải viết một cái gì đó cho chi tiết danh mục.";
    }
    if (empty($unit)) {
        $error['unit'] = "Bạn phải nhập số lượng đơn vị cho danh mục sản phẩm.";
    }
    if (count($error) > 0) {
        return $error;
    } else {
        $sql = "UPDATE category SET categoryName = ?, categoryDetail = ?, unit = ?, status = ? WHERE categoryID = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param("sssii", $name, $detail, $unit, $status, $id);
        if ($stm->execute()) {
            return TRUE;
        } else {
            $error['db'] = "Không thể cập nhật cơ sở dữ liệu.";
            return $error;
        }
    }

    $conn->close();
}

function totalCustomer()
{
    $conn = connect();
    $sql = "SELECT * FROM customers";
    $result = $conn->query($sql);
    $count = $result->num_rows;
    return $count;
    $conn->close();
}

function admin_DisplayCustomer($search)
{
    $conn = connect();
    $sql = "SELECT c.customerName, c.customerEmail, c.customerPhone, SUM(CASE WHEN o.orderStatus = 'success' THEN o.orderValue END) as 'total', COUNT(CASE WHEN o.orderStatus = 'success' THEN o.customerID END) as 'count', c.joinDate
            FROM `customers` as c LEFT JOIN orders as o ON c.customerID = o.customerID 
            GROUP BY c.customerID HAVING customerName LIKE CONCAT('%',?,'%')";
    $stm = $conn->prepare($sql);
    $stm->bind_param("s", $search);
    $stm->execute();
    $result = $stm->get_result();
    if ($result->num_rows > 0) {
        echo "<table class='tbl table table-striped table-hover'>
                <tr class='head'>
                    <th>Tên người dùng</th>
                    <th>Email</th>
                    <th>SĐT</th>
                    <th>Tổng đơn hàng</th>
                    <th>Tổng số tiền</th>
                    <th>Ngày tham gia</th>
                </tr>
            ";
        foreach ($result as $value) : ?>
            <tr>
                <td><?= $value['customerName'] ?></td>
                <td><?= $value['customerEmail'] ?></td>
                <td><?= $value['customerPhone'] ?></td>
                <td><?= $value['count'] ?></td>
                <td>$<?= number_format($value['total'], 2) ?></td>
                <td><?= date('d/m/Y', strtotime($value['joinDate'])) ?></td>
            </tr>
<?php endforeach;
        echo "</table>";
    }
    $conn->close();
}

function admin_contact()
{
    $conn = connect();
    $sql = "SELECT * FROM contact_us ORDER BY datetime DESC";
    $result = $conn->query($sql);
    $html = '';
    if ($result->num_rows >= 0) {
        $html .= "<table class='tbl table table-striped table-hover'>
                <tr class='head'>
                    <th>Tên khách hàng</th>
                    <th>Email</th>
                    <th>SĐT</th>
                    <th>Tin nhắn</th>
                    <th>Ngày</th>
                    <th>Phản hồi</th>
                </tr>
        ";
        foreach ($result as $value) {
            $date = date('d/m/Y - H:s:i', strtotime($value['datetime']));
            $html .= "
            <tr>
                <td>{$value['first_name']} {$value['last_name']}</td>
                <td>{$value['email']}</td>
                <td>{$value['phone']}</td>
                <td>{$value['message']}</td>
                <td>{$date}</td>
                <td><a class='btn btn-primary' href='mailto:{$value['email']}'>Email</a></td>
            </tr>
            ";
        }
        $html .= "</table>";
    }
    $conn->close();
    echo $html;
}

function admin_countOrder()
{
    $conn = connect();
    $orderCount = 0;
    // $sql = "SELECT * FROM orders WHERE orderTime BETWEEN CONCAT('$date',' 00:00:00') AND CONCAT('$date',' 23:59:59')";
    $sql = "SELECT * FROM orders WHERE week(orderTime) = week(now())";
    $result = $conn->query($sql);
    if ($result->num_rows >= 0) {
        $orderCount = $result->num_rows;
    }
    return $orderCount;
    $conn->close();
}

function admin_saleValue($date)
{
    $conn = connect();
    $saleValue = 0;
    $sql = "SELECT SUM(orderValue) as 'sum' FROM orders WHERE orderStatus = 'success'";
    if (!empty($date)) {
        $sql = "SELECT SUM(orderValue) as 'sum' FROM orders WHERE orderStatus = 'success' AND orderTime BETWEEN CONCAT('$date',' 00:00:00') AND CONCAT('$date',' 23:59:59')";
    }
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $saleValue = $row['sum'];
    }
    return $saleValue;
    $conn->close();
}

function admin_displayOrder($search, $date)
{
    $conn = connect();
    $search = $conn->real_escape_string($search);
    if (!empty($date)) {
        if(preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date)) {
            $sql = "SELECT * FROM orders as o
            INNER JOIN customers as c ON o.customerID = c.customerID
            LEFT JOIN staff as s on o.staffID = s.staffID
            LEFT JOIN orderdetail as od ON o.orderID = od.orderID
            INNER JOIN product as p ON od.productID = p.productID
            GROUP BY o.orderID HAVING orderTime BETWEEN CONCAT('$date',' 00:00:00') AND CONCAT('$date',' 23:59:59') 
            AND (o.orderStatus LIKE '%$search%'OR s.userName LIKE '%$search%' OR c.customerName LIKE '%$search%') ORDER BY o.orderTime DESC
            ";
        } else {
            die('Bạn đã thay đổi yếu tố đầu vào để nhập dữ liệu không hợp lệ, bạn đang muốn tấn công tôi?');
        }
        
    } else {
        $sql = "SELECT * FROM orders as o
        INNER JOIN customers as c ON o.customerID = c.customerID
        LEFT JOIN staff as s on o.staffID = s.staffID
        LEFT JOIN orderdetail as od ON o.orderID = od.orderID
        INNER JOIN product as p ON od.productID = p.productID
        GROUP BY o.orderID HAVING o.orderStatus LIKE '%$search%'OR s.userName LIKE '%$search%' OR c.customerName LIKE '%$search%' ORDER BY o.orderTime DESC
        ";
    }

    $result = $conn->query($sql);
    if ($result->num_rows >= 0) {
        echo "<table class='tbl table table-striped table-hover'>
                <tr class='head'>
                    <th>Thời gian</th>
                    <th>Khách hàng</th>
                    <th class='total'>Tổng giá trị</th>
                    <th>Trạng thái</th>
                    <th>Nhân viên phân công</th>
                    <th>Chi tiết</th>
                </tr>
            ";
        while ($order = $result->fetch_assoc()) {
            $date = date("d/m/Y H:i:s", strtotime($order['orderTime']));?>
                <tr>
                    <td><?= $date ?></td>
                    <td><?= $order['customerName']?></td>
                    <td class='sum'><?= $order['orderValue']?></td>
                    <td><?php  
                    if($order['orderStatus']=='pending'){
                        echo"Chưa giải quyết";
                    }else if($order['orderStatus']=='success'){
                        echo'Hoàn thành';
                    }
                    else{
                        echo'Huỷ';
                    }?></td>
                    <td><?= $order['userName']?></td>
                    <td><buton class='btn btn-success order-detail' data-bs-toggle='modal' data-id="<?= $order['orderID']?>" data-bs-target='#process'>Quản Lý</buton></td>
                </tr>

                <?php }
        echo "</table>";
    }else {
        echo "<table class='table'><tr><td><b>Không tìm thấy sản phẩm.</b></td></tr></table>";
    }
    $conn->close();

}

function admin_updateGallery($img, $category)
{
    $conn = connect();
    $error = [];
    $cat = $conn->query("SELECT category FROM gallerycat");
    foreach ($cat as $value) {
        $catList[] = $value['category'];
    }

    if (!in_array($category, $catList)) {
        $error['cat'] = "Thư viện đầu vào không hợp lệ.";
    }
    if (empty($img)) {
        $error['img'] = "Bạn phải chọn một tệp hình ảnh.";
    }
    $checkIMG = $conn->query("SELECT * FROM gallery WHERE imgURL = '$img'");
    if ($checkIMG->num_rows > 0) {
        $error['img'] = "Tệp hình ảnh đã tồn tại trong thư viện, hãy kiểm tra ảnh của bạn hoặc thay đổi tên tệp và tải lên lại.";
    }
    if (count($error) > 0) {
        return $error;
    } else {
        $sql = "INSERT INTO gallery (imgURL, category) VALUES ('$img', '$category')";
        if ($conn->query($sql)) {
            return true;
        } else {
            $error['query'] = 'Không thể thực hiện truy vấn.';
            return $error;
        }
    }
    $conn->close();
}

function admin_displayGallery($category)
{
    $conn = connect();
    if ($category == '') {
        $sql = "SELECT * FROM gallery";
    } else {
        $category = $conn->real_escape_string($category);
        $sql = "SELECT * FROM gallery WHERE category = '$category' ORDER BY category";
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else return FALSE;
    $conn->close();
}
?>