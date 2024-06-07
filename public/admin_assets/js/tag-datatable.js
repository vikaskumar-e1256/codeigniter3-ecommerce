$(document).ready(function ()
{
	var table = $('#tag-list').DataTable({
		'columnDefs': [{
			"targets": 'no-sort',
			"orderable": false,

		}],
		'aaSorting': [[1, 'asc']],
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
				"data": "id",
				"render": function (data, type, row)
				{
					return '<input type="checkbox" class="row-checkbox" data-id="' + data + '">';
				},
				"orderable": false

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

	$('#select-all').on('click', function ()
	{
		var rows = table.rows({ 'search': 'applied' }).nodes();
		$('input[type="checkbox"]', rows).prop('checked', this.checked);
	});

	$('#delete-selected').on('click', function ()
	{
		var selectedIds = [];
		$('.row-checkbox:checked').each(function ()
		{
			selectedIds.push($(this).data('id'));
		});

		if (selectedIds.length === 0)
		{
			Swal.fire({
				icon: 'warning',
				title: 'No tags selected',
				text: 'Please select at least one tag to delete.'
			});
			return;
		}
		
		Swal.fire({
			title: "Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, delete it!"
		}).then((result) =>
		{
			if (result.isConfirmed)
			{
				$.ajax({
					url: base_url + 'admin/tag/deleteMultiple/',
					type: 'post',
					data: {
						'ids': selectedIds,
						'csrf_token_max': csrf_token_max
					},
					success: function (response)
					{
						Swal.fire({
							title: "Deleted!",
							text: "Selected tags have been deleted.",
							icon: "success"
						});
						$('#select-all').prop('checked', false);

						table.ajax.reload(null, false);

					},
					error: function (xhr, status, error)
					{
						Swal.fire({
							position: "top-end",
							icon: "error",
							title: "An error occurred: " + error,
							showConfirmButton: false,
							timer: 2500,
						});
					}
				});
			}
		});
	});

	// Validation and AJAX submission
	$('#tag-form').validate({
		rules: {
			name: {
				required: true,
				maxlength: 20,
				remote: {
					url: base_url + "admin/tag/validateTag",
					type: 'post',
					data: {
						'csrf_token_max': csrf_token_max,
						name: function ()
						{
							return $('#name').val();
						}
					}
				}
			}
		},
		messages: {
			name: {
				required: "Please enter a name",
				remote: "This tag name already exists"
			}
		},
		submitHandler: function (form)
		{
			var formData = $(form).serialize();
			// Append the CSRF token to the form data
			formData += '&csrf_token_max=' + csrf_token_max;

			$.ajax({
				url: base_url + "admin/tag/store",
				type: 'post',
				data: formData,
				success: function (response)
				{
					$('#modal-default').modal('hide');
					table.ajax.reload(null, false);
					Swal.fire({
						position: "top-end",
						icon: "success",
						title: "Tag created successfully",
						showConfirmButton: false,
						timer: 2500,
					});
				},
				error: function (xhr, status, error)
				{
					Swal.fire({
						position: "top-end",
						icon: "error",
						title: "An error occurred: " + error,
						showConfirmButton: false,
						timer: 2500,
					});
				}
			});
			return false;
		}
	});

	$('#tag-list').on('click', '.delete-tag-btn', function ()
	{
		var tagId = $(this).data('id');
		var csrfToken = csrf_token_max;

		Swal.fire({
			title: "Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, delete it!"
		}).then((result) =>
		{
			if (result.isConfirmed)
			{
				$.ajax({
					url: base_url + 'admin/tag/delete',
					type: 'post',
					data: {
						'id': tagId,
						'csrf_token_max': csrfToken
					},
					success: function (response)
					{
						Swal.fire({
							title: "Deleted!",
							text: "Your file has been deleted.",
							icon: "success"
						});
						table.ajax.reload(null, false);
					},
					error: function (xhr, status, error)
					{
						Swal.fire({
							position: "top-end",
							icon: "error",
							title: "An error occurred: " + error,
							showConfirmButton: false,
							timer: 2500,
						});
					}
				});
			}
		});
	});

});

$('#submitBtn').on('click', function (e)
{
	e.preventDefault();
	$('#tag-form').submit();
});
