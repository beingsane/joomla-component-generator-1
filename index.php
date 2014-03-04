<?php
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Joomla! Component Generator</title>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
	<div class="row">
		<div class="col-md-12">
			<h1 class="page-header">Joomla! Component Generator</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">&nbsp;</div>
		<div class="col-md-6">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#basic" data-toggle="tab">Basic Info</a></li>
				<li><a href="#finish" data-toggle="tab">Finish</a></li>
			</ul>

			<form id="generate-component">
				<div class="tab-content">
					<div class="tab-pane active" id="basic">
						<div class="input-group">
						  	<span class="input-group-addon">Name</span>
						  	<input type="text" class="form-control" placeholder="Component Name" name="name" />
						</div>
						<div class="input-group">
						  	<span class="input-group-addon">Author</span>
						  	<input type="text" class="form-control" placeholder="Author Name" name="author" />
						</div>
						<div class="input-group">
						  	<span class="input-group-addon">E-mail</span>
						  	<input type="text" class="form-control" placeholder="Author E-mail" name="author_email" />
						</div>
						<div class="input-group">
						  	<span class="input-group-addon">URL</span>
						  	<input type="text" class="form-control" placeholder="Author URL" name="author_url" />
						</div>
						<div class="input-group">
						  	<span class="input-group-addon">Date</span>
						  	<input type="text" class="form-control" placeholder="Creation Date (dd/mm/yyyy)" name="creation_date" />
						</div>
						<div class="input-group">
						  	<span class="input-group-addon">Copyright</span>
						  	<input type="text" class="form-control" placeholder="Copyright Information" name="copyright" />
						</div>
						<div class="input-group">
						  	<span class="input-group-addon">License</span>
						  	<input type="text" class="form-control" placeholder="License Information" name="license" />
						</div>
						<div class="input-group">
						  	<span class="input-group-addon">Version</span>
						  	<input type="text" class="form-control" placeholder="License Number" name="version" />
						</div>
						<div class="input-group">
						  	<span class="input-group-addon">Description</span>
						  	<textarea class="form-control" placeholder="Description Text" name="description"></textarea> 
						</div>
						<div class="input-group">
							<button type="button" class="next btn btn-primary">
								Next &nbsp;&rarr;
							</button>
						</div>
					</div>
					<div class="tab-pane" id="finish">
						<div class="input-group">
							<button type="button" class="prev btn btn-primary">
								&larr;&nbsp; Previous
							</button>
							<button data-loading-text="Loading..." type="submit" class="btn btn-success">
								Generate Component
							</button>
						</div>
					</div>
				</div>
			</form>

			<div class="clearfix"></div>

			<!-- Alerts -->
			<div id="messages-container"></div>
		</div>
		<div class="col-md-3">&nbsp;</div>
	</div>

	<div id="footer">
		<div class="container">
			<p class="text-muted">
				Author: Flávio Escobar - <a href="http://flavioescobar.com.br" target="_blank">flavioescobar.com.br</a>
			</p>
		</div>
    </div>

	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.mask.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
</body>
</html>