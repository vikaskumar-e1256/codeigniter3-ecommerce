$(document).ready(function ()
{
	var table = $('#category-list').DataTable({
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
			url: base_url + "admin/category/getCategories",
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
				"data": "image"
			},
			{
				"data": "is_active"
			},
			{
				"data": "action",
				"orderable": false
			}
		]
	});

	window.updateCategoryStatus = function (id)
	{
		$.ajax({
			url: base_url + "/admin/category/updateCategoryStatus",
			type: 'POST',
			data: {
				'id': id,
				'csrf_token_max': csrf_token_max
			},
			success: function (response)
			{
				var res = JSON.parse(response);
				if (res.success)
				{
					table.ajax.reload(null, false);
				} else
				{
					alert(res.error);
				}
			},
			error: function ()
			{
				console.error('Error while updating category status');
			}
		});
	};

});
