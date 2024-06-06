<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Tag
			<small>Control panel</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Tags</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Tag Table</h3>
						<button type="button" data-toggle="modal" data-target="#modal-default" class="btn btn-info box-title" style="display: flex; float: right; cursor: pointer;">
							<i class="fa fa-fw fa-plus-circle"></i>
						</button>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="tag-list" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th class="no-sort">Slug</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>

<div class="modal fade in" id="modal-default" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Create New Tag</h4>
			</div>
			<div class="modal-body">
				<form id="tag-form" method="post">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" class="form-control" id="name" placeholder="Enter name">
					</div>
					<button type="submit" class="btn btn-primary" id="submitBtn">Save changes</button>
				</form>
			</div>

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
