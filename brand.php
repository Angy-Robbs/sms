<?php
session_start();
require_once 'dashboard.php';
include 'connection.php';
?>

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="dashboard.php">Home</a></li>
            <li class="active">Brand</li>
        </ol>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Manage Brand</div>
            </div>
            <div class="panel-body">
                <div class="remove-messages"></div>

                <div class="div-action pull pull-right" style="padding-bottom:20px;">
                    <button class="btn btn-default button1" data-toggle="modal" data-target="#addBrandModel">
                        <i class="glyphicon glyphicon-plus-sign"></i> Add Brand 
                    </button>
                </div>

                <div id="manageBrandTable">
                    <table class="table" id="brands">
                        <thead>
                            <tr>
                                <th>Brand Name</th>
                                <th>Status</th>
                                <th style="width:15%;">Options</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Brand Name</th>
                                <th>Status</th>
                                <th style="width:15%;">Options</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM brands WHERE brand_status = 1";
                            $statement = $conn->prepare($sql);
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                            if ($result) {
                                foreach ($result as $row) {
                                    $brand = htmlspecialchars($row['brand_name']);
                            ?>
                            <tr>
                                <td><?= $brand ?></td>
                                <td style="width:15%;">
                                    <?php
                                    if ($row['brand_status'] == 1) {
                                        echo "<label class='label label-success'>Available</label>";
                                    } else {
                                        echo "<label class='label label-danger'>Not Available</label>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a type="button" data-toggle="modal" data-target="#editBrandModel" onclick="editBrands(<?= $row['brand_id'] ?>)">
                                                <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
                                            <li><a type="button" data-toggle="modal" data-target="#removeMemberModal" onclick="removeBrands(<?= $row['brand_id'] ?>)">
                                                <i class="glyphicon glyphicon-trash"></i> Remove</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Brand Modal -->
<div class="modal fade" id="addBrandModel" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" id="submitBrandForm" action="createBrand.php" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Add Brand</h4>
                </div>
                <div class="modal-body">
                    <div id="add-brand-messages"></div>

                    <div class="form-group">
                        <label for="brandName" class="col-sm-3 control-label">Brand Name: </label>
                        <label class="col-sm-1 control-label"></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="brandName" placeholder="Brand Name" name="brandName" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="brandStatus" class="col-sm-3 control-label">Status: </label>
                        <label class="col-sm-1 control-label"></label>
                        <div class="col-sm-8">
                            <select class="form-control" id="brandStatus" name="brandStatus">
                                <option value="">~~SELECT~~</option>
                                <option value="1">Available</option>
                                <option value="0">Not Available</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="createBrandBtn" data-loading-text="Loading..." autocomplete="off">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Brand Modal -->
<div class="modal fade" id="editBrandModel" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" id="editBrandForm" action="editBrand.php" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Brand</h4>
                </div>
                <div class="modal-body">
                    <div id="edit-brand-messages"></div>
                    <div class="form-group">
                        <label for="editBrandName" class="col-sm-3 control-label">Brand Name: </label>
                        <label class="col-sm-1 control-label"></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="editBrandName" value="<?php echo $row["brand_name"]?>" name="editBrandName" placeholder="Brand Name" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editBrandStatus" class="col-sm-3 control-label">Status: </label>
                        <label class="col-sm-1 control-label"></label>
                        <div class="col-sm-8">
                            <select class="form-control" id="editBrandStatus" name="editBrandStatus">
                                <option value="">~~SELECT~~</option>
                                <option value="1" <?php echo ($row['brand_status'] == 1) ? 'selected' : ''; ?>>Available</option>
                                <option value="0" <?php echo ($row['brand_status'] == 0) ? 'selected' : ''; ?>>Not Available</option>
                       </select>
                        </div>
                    </div>
                    <input type="hidden" name="editBrandId" id="editBrandId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="editBrandBtn" data-loading-text="Loading..." autocomplete="off">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Remove Brand Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeMemberModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Brand</h4>
            </div>
            <div class="modal-body">
                <p>Do you really want to remove this brand?</p>
            </div>
            <div class="modal-footer removeBrandFooter">
                <form id="removeBrandForm" action="removeBrand.php" method="POST">
                    <input type="hidden" name="brand_id" id="removeBrandId">
                    <button type="submit" class="btn btn-primary" id="removeBrandBtn" data-loading-text="Loading...">
                        <i class="glyphicon glyphicon-ok-sign"></i> Yes
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="glyphicon glyphicon-remove-sign"></i> Close
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="custom/js/brand.js"></script>
