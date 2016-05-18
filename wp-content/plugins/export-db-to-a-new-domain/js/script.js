jQuery(document).ready(function($) {
	$('.edbfnd').on('submit', '#edbfnd-search-in-db-form', function(e) {
		e.preventDefault();
		form = $(this);
		var data = {
			action: 'edbfnd',
			search_in_db: form.find('input[name="search_in_db"]').val(),
			search_in_db_nonce: form.attr('data-nonce')
		};
		$.post(ajaxurl, data, function(response) {
			form.parent().find('.search-results').html(response);
		});
		
	});
	
	$('.edbfnd').on('submit', '#edbfnd-search-in-db-table-form', function(e) {
		e.preventDefault();
		form = $(this);
		var data = {
			action: 'edbfnd',
			search_in_db_table: form.find('select[name="search_in_db_table"]').val(),
			search_in_db_table_for: form.find('input[name="search_in_db_table_for"]').val(),
			search_in_db_table_nonce: form.attr('data-nonce')
		};
		$.post(ajaxurl, data, function(response) {
			form.parent().find('.search-results').html(response);
		});
		
	});
	
	
	$('.edbfnd').on('click', '.browse-db-table', function(e) {
		e.preventDefault();
		var val = $(this).attr('data-value');
		var table = $(this).attr('data-table');
		$('#edbfnd-search-in-db-table-form').find('select[name="search_in_db_table"] option[value="'+table+'"]').attr("selected","selected");
		$('#edbfnd-search-in-db-table-form').find('input[name="search_in_db_table_for"]').val(val);
		$('#edbfnd-search-in-db-table-form').submit();
	});
});