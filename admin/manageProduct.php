<?php
session_start();
require 'adminFunction.php';
if (isset($_GET['id'])) {
    $pid = $_GET['id'];
    $conn = connect();
    $sql = "SELECT img.imgURL, pd.productID, pd.productName, ct.categoryName, pd.productDetail, pd.unitPrice, pd.stock 
            FROM product as pd 
            INNER JOIN category as ct ON pd.categoryID = ct.categoryID 
            INNER JOIN image as img ON pd.productID = img.productID
            WHERE pd.productID = '$pid'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pname = $row['productName'];
            $category = $row['categoryName'];
            $price = $row['unitPrice'];
            $stock = $row['stock'];
            $detail = $row['productDetail'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <scrip src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
</head>

<body>
    <div class="warper" style="margin:0 auto; width:50%;">
        <div class="container">
            <h3>Edit Product</h3>
            <form id="mng-product" action="" method="post" enctype="multipart/form-data">
                <div class="input-group mb-1">
                    <span class="input-group-text">Tên sản phẩm:</span>
                    <input type="text" id="pname" class="form-control" name="pname" placeholder="" aria-label="pname" value="<?= isset($pname) ? $pname : '' ?>" required>
                    <span class="input-group-text">Danh mục:</span>
                    <select class="form-select" name="category" id="ctg">
                        <option value="value=" <?= isset($category) ? $category : '' ?>""><?= isset($category) ? $category : '' ?></option>
                        <?php
                        $conn = connect();
                        $list = $conn->query("SELECT categoryName FROM category WHERE categoryName NOT LIKE '$category'");
                        if ($list->num_rows > 0) {
                            while ($item = $list->fetch_assoc()) {
                                echo "<option value=\"{$item['categoryName']}\">{$item['categoryName']}</option>";
                            }
                        }
                        $conn->close();
                        ?>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Giá:</span>
                    <span class="input-group-text">$</span>
                    <input type="text" id="price" class="form-control" name="price" placeholder="" aria-label="price" value="<?=isset($price) ? $price : '' ?>" required>
                    <span class="input-group-text">Trong kho:</span>
                    <input id="stock" type="text" class="form-control" name="stock" placeholder="" aria-label="stock" disabled value="<?= isset($stock) ? $stock : '' ?>">
                    <span class="input-group-text">Nhập khẩu:</span>
                    <input id="import" type="text" class="form-control" name="import" placeholder="" aria-label="import" required>
                </div>
                <div class="form-floating mb-3">
                    <!-- <span class="input-group-text">Description:</span> -->
                    <textarea id="detail" style="height: 100px" class="form-control" name="detail" aria-label="detail" required><?= isset($detail) ? $detail : '' ?></textarea>
                    <label for="detail">Chi tiết</label>
                </div>
                <!-- image upload -->
                <h6>Cập nhập ảnh (chỉ nhận file JPG, PNG và GIF):</h6>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" id="customFile" name="avatar" />
                </div>
                <!-- submit -->
                <div class="submit input-group mb3">
                    <input style="width:100px;" class="btn-add btn btn-primary" type="submit" value="Thêm" name="add" id="add">
                    <button style="width:100px;" class="btn-add btn btn-danger" type="reset" id="reset">Cập nhập</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>