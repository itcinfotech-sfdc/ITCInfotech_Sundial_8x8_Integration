<?php include('header.php'); ?>


<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">Search Customer</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2>Search Customer</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
			<div class="well col-md-5 center login-box">
                <form class="form-horizontal" action="customerlist.php" method="post">
					<fieldset>
						<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="glyphicon glyphicon-hand-right red"></i></span>
							<input type="text" class="form-control" placeholder="Phone Number">
						</div>

						<p class="center col-md-5">
							<button type="submit" class="btn btn-primary">Search</button>
						</p>
					</fieldset>
				</form>
			</div>	
            </div>
        </div>
    </div>
</div><!--/row-->


<?php include('footer.php'); ?>
