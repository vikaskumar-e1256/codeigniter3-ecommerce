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
<script>
	$(document).ready(function() {
		$('.sidebar-menu').tree();
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


<script src="<?= base_url(); ?>public/admin_assets/js/category-datatable.js"></script>
<script src="<?= base_url(); ?>public/admin_assets/js/tag-datatable.js"></script>

</body>

</html>
