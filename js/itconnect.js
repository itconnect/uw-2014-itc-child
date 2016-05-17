(function(){
    // NAMESPACE THIS STUFF

	$(window).load(function() {
		$('#search-labels input[type="radio"]').each(function(){
			if ($(this).val() == 'site') {
				$(this).parent().addClass('checked');
				$(this).closest('#search-labels').prepend($(this).parent());
				$(this).prop('checked', true);
			} else if ($(this).val() == 'uw') {
				$(this).parent().removeClass('checked');
                $(this).prop('checked', false);
			}
		});
	});
})();