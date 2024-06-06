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

});

$('#submitBtn').on('click', function (e)
{
	e.preventDefault();
	$('#tag-form').submit();
});
