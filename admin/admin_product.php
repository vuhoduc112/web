<div class="content">
    <h2>Quản Lý Sản Phẩm</h2>
    <div class="product list">
        <div class="row" style="padding: 5px;">
            <div class="col">
                <form action="" method="post">
                    <div class="input-group">
                        <span class="input-group-text">Sắp xếp:</span>
                        <button type="submit" name="sortname" class="btn btn-outline-secondary">Tên</button>
                        <button type="submit" name="sortcat" class="btn btn-outline-secondary">Danh mục</button>
                        <button type="submit" name="sortnew" class="btn btn-outline-secondary">Mới nhất</button>
                    </div>
                </form>
            </div>
            <div class="col">
                <!-- <a class="btn btn-warning" data-bs-toggle="collapse" href="#addproduct" role="button" aria-expanded="false" aria-controls="addproduct"><i class="fa fa-plus" aria-hidden="true"></i> Add product</a> -->
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#productPanel"><i class="fa fa-plus" aria-hidden="true"></i> Thêm</button>
            </div>
            <div class="col">
                <form action="" method="post" id='search'>
                    <div class="input-group">
                        <input style="max-width:90%" type="search" class="form-control src" name="searchvalue" id="searchbar" placeholder="Search">
                        <button class="btn btn-outline-success" type="submit" name="search" id='src-submit'>
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="display">
            <!-- display product list from database -->
            <?php
            $search = '';
            if (isset($_POST['sortname'])) {
                $order = 'ORDER BY productName';
                admin_displayProduct($search, $order);
            } elseif (isset($_POST['sortcat'])) {
                $order = 'ORDER BY categoryName, productID DESC';
                admin_displayProduct($search, $order);
            } elseif (isset($_POST['sortnew'])) {
                $order = 'ORDER BY productID DESC';
                admin_displayProduct($search, $order);
            } else {
                if (isset($_POST['search'])) {
                    $search = $_POST['searchvalue'];
                    admin_displayProduct($search, 'ORDER BY categoryName, productID DESC');
                } else {
                    admin_displayProduct('', 'ORDER BY categoryName, productID DESC');
                }
            }
            ?>
        </div>
        <!-- Add product -->
        <form id="addproduct" action="addProduct.php" method="post" enctype="multipart/form-data">
            <div class="modal fade" id="productPanel" tabindex="-1" aria-labelledby="productPanelLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="productPanelLabel">
                                <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                Thêm sản phẩm
                            </h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="product-add">
                            <div class="input-group mb-1">
                                <span class="input-group-text" style="max-width:20%">Tên sản phẩm:</span>
                                <input type="text" id="pname" class="form-control" name="pname" placeholder="" aria-label="pname" required value="<?= isset($_GET['pname']) ? $_GET['pname'] : ''  ?>">
                                <!-- <input type="button" value="New Category" class="form-control btn btn-secondary"> -->
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" style="max-width:15%">Giá sản phẩm:</span>
                                <!-- <span class="input-group-text" style="max-width:5%"><i class="fa fa-usd" aria-hidden="true"></i></span> -->
                                <input type="text" id="price" class="form-control" name="price" placeholder="" aria-label="price" required value="<?= isset($_GET['price']) ? $_GET['price'] : ''  ?>">
                                <span class="input-group-text">Danh mục:</span>
                                <select class="form-select" name="category" id="ctg">
                                    <option value="0">chọn...</option>
                                    <?php
                                    $conn = connect();
                                    $list = $conn->query("SELECT categoryID, categoryName FROM category");
                                    if ($list->num_rows > 0) {
                                        while ($item = $list->fetch_assoc()) {
                                            echo "<option value=\"{$item['categoryID']}\">{$item['categoryName']}</option>";
                                        }
                                    }
                                    $conn->close();
                                    ?>
                                </select>
                                <?php if ($user['userRole'] == 1) { ?>
                                    <button type="button" class="form-control btn btn-outline-secondary" style="max-width: 12%" data-bs-toggle="modal" data-bs-target="#categoryPanel">
                                        <i class="fa fa-folder-open" aria-hidden="true"></i>
                                        <b>Mới</b>
                                    </button>
                                <?php } ?>

                            </div>
                            <div class="form-floating mb-3">
                                <!-- <span class="input-group-text">Description:</span> -->
                                <textarea id="detail" style="height: 120px" class="form-control" name="detail" aria-label="detail" required></textarea>
                                <script>
                                    CKEDITOR.replace('detail');
                                </script>
                                <!-- <label for="detail">Product detail</label> -->
                            </div>
                            <!-- image upload -->
                            <div class="mb-3">
                                <label for="customFile">
                                    <p>Ảnh:</p>
                                </label>
                                <input style="max-width:50%" type="file" class="form-control" id="customFile" name="avatar" accept=".png, .jpg, .jpeg, .gif" />
                                <small id="imgHelp" class="form-text text-muted">Chỉ chọn được files ảnh JPG, PNG và GIF 
                                   .</small>
                            </div>

                            <!-- submit -->

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <input type="submit" value="Thêm" name="add" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- Update product -->
        <form id='mng-product' action='updateproduct.php' method='post' enctype='multipart/form-data'>
            <div class="modal fade" id="editPanel" tabindex="-1" aria-labelledby="editPanelLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="editPanelLabel">
                                <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                Cập nhập sản phẩm
                            </h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="product-detail">
                            <!-- query.php fetchs data here -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <input type="submit" value="Thay đổi" name="save" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Add Category -->
        <form id='add-cat' action='AddCategory.php' method='post'>
            <div class="modal fade" id="categoryPanel" tabindex="-1" aria-labelledby="categoryPanelLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="categoryPanelLabel">
                                <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                Tạo Danh mục 
                            </h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="category-add">
                            <div class="input-group mb-3">
                                <span class='input-group-text'>Tên danh mục:</span>
                                <input type="text" name="cname" id="" class='form-control'>
                                <span class='input-group-text'>Giá:</span>
                                <input type="text" name="cunit" id="" class='form-control'>
                            </div>
                            <div class="input-group mb-3">
                                <span class='input-group-text'>Miêu Tả:</span>
                                <textarea type="text" name="detail" id="" class='form-control'></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <input type="submit" value="Tạo" name="create" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- display message -->
<?php
if (isset($_SESSION['error'])) {
    echo "<script>alert('{$_SESSION['error']}')</script>";
    unset($_SESSION['error']);
}

if (isset($_SESSION['errUpdate'])) {
    echo "<script>alert('Update FAILED! Please check the following error(s):\\n";
    foreach ($_SESSION['errUpdate'] as $value) {
        echo " - " . $value . "\\n";
    }
    echo "')</script>";
    unset($_SESSION['errUpdate']);
}

if (isset($_SESSION['success'])) {
    echo "<script>alert('{$_SESSION['success']}')</script>";
    unset($_SESSION['success']);
}
?>
</body>
<script>
    //Preview upload image file when update product:
    function loadFile2(e) {
        var img = document.querySelector('#preview-change');
        img.src = URL.createObjectURL(e.target.files[0]);
        img.onload = () => {
            URL.revokeObjectURL(img.src);
        }
    }
</script>

</html>