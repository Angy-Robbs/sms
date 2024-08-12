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
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				<div class="remove-messages"></div>

				<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-default button1" data-toggle="modal" data-target="#addBrandModel"> <i class="glyphicon glyphicon-plus-sign"></i> Add Brand </button>
				</div> <!-- /div-action -->				
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
                    $result=$statement->fetchAll();


                    //$statement->setFetchMode(PDO::FETCH_BOTH);
                    //$result = $statement->fetch(PDO::FETCH_COLUMN); //PDO::FETCH_ASSOC


                    if($result)
                    {
                        $activeBrands = "";
                        $button = "createBrandBtn";
                        foreach($result as $row) {
                            $brand=$row[1];
						
				
                    ?>
                        <tr>
                            <td><?=$brand?></td>
                            <td style="width:15%;">
                                <?php
                                if($row[2] == 1) {
                                    // activate member
                                    echo $activeBrands = "<label class='label label-success'>Available</label>";
                                } else {
                                    // deactivate member
                                    echo $activeBrands = "<label class='label label-danger'>Not Available</label>";
                                }
                                ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a type="button" data-toggle="modal" data-target="#editBrandModel" onclick="editBrands(<?=$row[0]?>)"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
                                        <li><a type="button" data-toggle="modal" data-target="#removeMemberModal" onclick="removeBrands(<?=$row[0]?>)"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>
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
				<!-- /table -->

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->

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
	        </div> <!-- /form-group-->	         	        
	        <div class="form-group">
	        	<label for="brandStatus" class="col-sm-3 control-label">Status: </label>
	        	<label class="col-sm-1 control-label"> </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="brandStatus" name="brandStatus">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1">Available</option>
				      	<option value="2">Not Available</option>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	         	        

	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        
	        <button type="submit" class="btn btn-primary" id="createBrandBtn" data-loading-text="Loading..." autocomplete="off">Save Changes</button>
	      </div>
	      <!-- /modal-footer -->
     	</form>
	     <!-- /.form -->
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>
<!-- / add modal -->
 
<!-- edit brand ------------------------------------------------------------------------------------------------------- -->

<div class="modal fade" id="editBrandModel" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" id="editBrandBtn" action="editBrand.php" method="POST">

      <?php 
      include('connection.php');
      //include('fetchSelectedBrand.php');

      //if(mysqli_num_rows($query) > 0) {
       // while($row = mysqli_fetch_assoc($sql)){
  
       // }
      //}      
      ?>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><i class="fa fa-edit"></i> Edit</h4>
        </div>
        <div class="modal-body">
          <div id="edit-brand-messages"></div>
          <div class="form-group">
            <label for="editBrandName" class="col-sm-3 control-label">Brand Name: </label>
            <label class="col-sm-1 control-label"></label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="brand_name" value="<?php echo $row["brand_name"]?>" placeholder="Brand Name" name="brand_name" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
    <label for="editBrandStatus" class="col-sm-3 control-label">Status: </label>
    <label class="col-sm-1 control-label"></label>
    <div class="col-sm-8">
        <select class="form-control" id="brand_status" name="brand_status">
            <option value="">~~SELECT~~</option>
            <option value="1" <?php echo ($row['brand_status'] == 1) ? 'selected' : ''; ?>>Available</option>
            <option value="0" <?php echo ($row['brand_status'] == 0) ? 'selected' : ''; ?>>Not Available</option>
        </select>
    </div>
</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="editBrandBtn" class="btn btn-primary" id="editBrandBtn" data-loading-text="Loading..." autocomplete="off">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- remove brand -->
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
          <input type="hidden" name="brand_id" id="removeBrandId" value="">
          <button type="submit" class="btn btn-primary" id="removeBrandBtn" data-loading-text="Loading...">
            <i class="glyphicon glyphicon-ok-sign"></i> Yes
          </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Close
          </button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove brand -->

<script src="custom/js/brand.js"></script>