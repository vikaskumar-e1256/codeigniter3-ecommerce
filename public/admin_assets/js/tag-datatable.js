$(document).ready(function ()
{
	var table = $('#tag-list').DataTable({
		'columnDefs': [{
			"targets": 'no-sort',
			"orderable": false,
		}],
		'processing': true,
		'serverSide': true,
		'paging': true,
		'lengthChange': true,
		'searching': true,
		'ordering': true,
		'info': true,
		'autoWidth': false,

		"ajax": {
			url: base_url + "admin/tag/getTags",
			type: 'POST',
			data: {
				'csrf_token_max': csrf_token_max
			},
		},

		"aoColumns": [
			{
				"data": "id"
			},
			{
				"data": "name"
			},
			{
				"data": "slug"
			},
			{
				"data": "action",
				"orderable": false
			}
		]
	});

});
