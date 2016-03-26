<?php
include '../../../config/config.php';
$product_title = '';
$product_status = '';
$product_details = '';
$product_image = '';
$product_created_on = date('Y-m-d H:i:s');
$product_created_by = getSession('admin_id');
if (isset($_POST['product_title'])) {
    extract($_POST);

    $product_title = validateInput($product_title);
    $product_details = validateInput($product_details);
    $product_status = validateInput($product_status);

    // check product exists
    $sql_check = "SELECT * FROM product WHERE product_title = '$product_title'";
    $result_check = mysqli_query($con, $sql_check);
    $count = mysqli_num_rows($result_check);
    if ($count > 0) {
        $error = "Product already exists in record";
    } else {
        if ($_FILES["product_image"]["tmp_name"] != '') {

            $product_image = basename($_FILES['product_image']['name']);
            $infoPath = pathinfo($product_image, PATHINFO_EXTENSION);
            $rename_image = 'PIMG_' . date("YmdHis") . '.' . $infoPath;

            if (!is_dir($config['IMAGE_UPLOAD_PATH'] . '/product_image/')) {
                mkdir($config['IMAGE_UPLOAD_PATH'] . '/product_image/', 0777, TRUE);
            }
            $image_target_path = $config['IMAGE_UPLOAD_PATH'] . '/product_image/' . $rename_image;

            $zebra = new Zebra_Image();
            $zebra->source_path = $_FILES["product_image"]["tmp_name"];
            $zebra->target_path = $config['IMAGE_UPLOAD_PATH'] . '/product_image/' . $rename_image;

            if (!$zebra->resize(400)) {
                zebraImageErrorHandaling($zebra->error);
            }
        }
        $insert_array = '';
        $insert_array .= 'product_title = "' . $product_title . '"';
        $insert_array .= ',product_image = "' . $rename_image . '"';
        $insert_array .= ',product_details = "' . $product_details . '"';
        $insert_array .= ',product_status = "' . $product_status . '"';
        $insert_array .= ',product_created_on = "' . $product_created_on . '"';
        $insert_array .= ',product_created_by = "' . $product_created_by . '"';

        $sql = "INSERT INTO product SET $insert_array";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $success = 'Product information saved successfully';
            $link = "product_list.php?success=" . base64_encode($success);
            redirect($link);
        } else {
            if (DEBUG) {
                $error = 'result query failed for ' . mysqli_error($con);
            } else {
                $error = 'Something went wrong';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include basePath('admin/header_script.php'); ?>
        <style>
            .example-modal .modal {
                position: relative;
                top: auto;
                bottom: auto;
                right: auto;
                left: auto;
                display: block;
                z-index: 1;
            }
            .example-modal .modal {
                background: transparent!important;
            }
        </style>
    </head>
    <body class="skin-blue">
        <div class="wrapper">
            <?php include basePath('admin/header.php'); ?>

            <aside class="main-sidebar">
                <?php include basePath('admin/site_menu.php'); ?>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>Add Product</h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-laptop"></i>&nbsp;Product Settings</li>
                        <li class="active">Add Product</li>
                    </ol>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="example-modal">
                                    <div class="modal">
                                        <div class="modal-dialog">
                                            <?php include basePath('admin/message.php'); ?>
                                            <div class="modal-content">
                                                <form method="POST" id="productForm" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="product_title">Product Title &nbsp;&nbsp;<span style="color:red;">*</span></label>
                                                            <input type="text" class="form-control" id="product_title" name="product_title" value="<?php echo $product_title; ?>" required="required" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="product_image">Product Image&nbsp;&nbsp;<span style="color:red;">*</span></label>
                                                            <input type="file" name="product_image" id="product_image" />
                                                        </div>
                                                        <div>
                                                            <img src="../../../upload/default.png" id="show_image" style="height: 70px; width: 80px;" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="product_details">Product Details</label>
                                                            <textarea rows="3" cols="30" class="form-control" id="product_details" name="product_details"><?php echo html_entity_decode($product_details, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="product_status">Product Status&nbsp;&nbsp;<span style="color:red;">*</label>
                                                            <select id="product_status" name="product_status" class="form-control" required="required" />
                                                            <option value="0">Select Status</option>
                                                            <option value="Active"
                                                            <?php
                                                            if ($product_status == 'Active') {
                                                                echo "selected";
                                                            }
                                                            ?>>Active
                                                            </option>
                                                            <option value="Inactive"<?php
                                                            if ($product_status == 'Inactive') {
                                                                echo "selected";
                                                            }
                                                            ?>>Inactive
                                                            </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <p id="errorShow" style="display: none;background-color: #ea2e49;color: white; padding: 4px 4px 2px 4px;font-size: 12px;position: relative;">
                                                                Please fill up required (*) fields
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" id="btnSave" name="btnSave" class="btn btn-primary"><i class="fa fa-check-circle"></i> Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php include basePath('admin/footer.php'); ?>
        </div>
        <script type="text/javascript">
            $("#productActive").addClass("active");
            $("#productActive").parent().parent().addClass("treeview active");
            $("#productActive").parent().addClass("in");
        </script>
        <script>
            $(document).ready(function () {
                $("#product_details").kendoEditor({
                    tools: [
                        "bold", "italic", "underline", "strikethrough", "justifyLeft", "justifyCenter", "justifyRight", "justifyFull",
                        "insertUnorderedList", "insertOrderedList", "indent", "outdent", "createLink", "unlink", "insertImage",
                        "insertFile", "subscript", "superscript", "createTable", "addRowAbove", "addRowBelow", "addColumnLeft",
                        "addColumnRight", "deleteRow", "deleteColumn", "viewHtml", "formatting", "cleanFormatting",
                        "fontName", "fontSize", "foreColor", "backColor"
                    ]
                });
            });
        </script>
        <?php include basePath('admin/footer_script.php'); ?>
        <script>
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#show_image').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#product_image").change(function () {
                readURL(this);
            });
        </script>
        <script>
            $(document).ready(function () {
                $("#btnSave").click(function () {

                    var product_title = $("#product_title").val();
                    var product_image = $('input[type="file"]').val();
                    var product_status = $("#product_status option:selected").val();
                    var status = 0;
                    if (product_title == '') {
                        status++;
                        $("#errorShow").show();
                        $("#product_title").css({
                            "border": "1px solid red"
                        });
                    }
                    if (product_image == '') {
                        status++;
                        $("#errorShow").show();
                        $("#product_image").css({
                            "border": "1px solid red"
                        });
                    }
                    if (product_status == '0') {
                        status++;
                        $("#errorShow").show();
                        $("#product_status").css({
                            "border": "1px solid red"
                        });
                    }
                    if (status == 0) {
                        $("#errorShow").hide();
                        $("#productForm").submit();
                    }
                });
            });
        </script>
    </body>
</html>