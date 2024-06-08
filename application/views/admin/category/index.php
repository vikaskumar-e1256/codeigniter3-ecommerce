<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Category
			<small>Control panel</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Categories</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Category Table</h3>
						<button type="button" data-toggle="modal" data-target="#modal-category" class="btn btn-info box-title" style="display: flex; float: right; cursor: pointer;">
							<i class="fa fa-fw fa-plus-circle"></i>
						</button>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="category-list" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th class="no-sort">Slug</th>
									<th class="no-sort">Image</th>
									<th>Status</th>
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

<div class="modal fade in" id="modal-category" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Create New Category</h4>
			</div>
			<div class="modal-body">
				<form id="category-form" method="post">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" class="form-control" id="name" placeholder="Enter name">
					</div>
					<div class="form-group">
						<label for="description">Description</label>
						<textarea row="3" cols="5" name="description" class="form-control" id="description">

						</textarea>
					</div>
					<div class="form-group">
						<label for="image">Image</label>
						<input type="file" name="image" accept="image/*" class="form-control" id="image" placeholder="Enter name">
					</div>
					<div class="form-group">
						<label for="tags">Tags</label>
						<select class="form-control select2" data-placeholder="Select multiple tags" style="width: 100%;" multiple name="tags[]" id="tags">
							<?php foreach ($tags as $tag) { ?>
								<option value="<?= $tag['id'] ?>"><?= $tag['name'] ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label for="meta_title">Meta title</label>
						<input type="text" name="meta_title" class="form-control" id="meta_title" placeholder="Enter name">
					</div>
					<div class="form-group">
						<label for="meta_description">Meta description</label>
						<textarea row="3" cols="5" name="meta_description" class="form-control" id="meta_description">

						</textarea>
					</div>
					<div class="form-group">
						<label for="meta_keywords">Meta keywords</label>
						<input type="text" name="meta_keywords" class="form-control" id="meta_keywords" placeholder="Enter name">
					</div>
					<div class="form-group">
						<label for="tags">Status</label>
						<select class="form-control" name="status" id="status">
							<option value="1">active</option>
							<option value="0">inactive</option>
						</select>
					</div>
					<button type="submit" class="btn btn-primary" id="submitBtn">Save changes</button>
				</form>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
