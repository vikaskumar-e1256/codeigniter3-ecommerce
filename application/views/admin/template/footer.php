<footer class="main-footer">
	<div class="pull-right hidden-xs">
		<b>Version</b> 2.4.13
	</div>
	<strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
	reserved.
</footer>

<script>
	const base_url = "<?= base_url() ?>";
	var csrf_token_max = '<?= $this->security->get_csrf_hash(); ?>';
</script>
<!-- jQuery 3 -->
<script src="<?= base_url(); ?>public/admin_assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery validate -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>

<!-- Sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
	$(document).ready(function() {
		$('.sidebar-menu').tree();
		//Initialize Select2 Elements
		$('#tags').select2();
	});
</script>
<!-- DataTables -->
<script src="<?= base_url(); ?>public/admin_assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>public/admin_assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url(); ?>public/admin_assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?= base_url(); ?>public/admin_assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url(); ?>public/admin_assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(); ?>public/admin_assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url(); ?>public/admin_assets/dist/js/demo.js"></script>
<!-- Select2 -->
<script src="<?= base_url(); ?>public/admin_assets/bower_components/select2/dist/js/select2.full.min.js"></script>

<script src="<?= base_url(); ?>public/admin_assets/js/category-datatable.js"></script>
<script src="<?= base_url(); ?>public/admin_assets/js/tag-datatable.js"></script>

</body>

</html>
