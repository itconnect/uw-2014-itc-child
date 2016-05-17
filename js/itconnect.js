(function(){
	ITConnect = {
		search: {
        	switchDefault: function(){
        		// Swaps UW to Current Site as the default for searches
        		$('#search-labels input[type="radio"]').each(function(){
        			$this = $(this);
					if ($this.val() == 'site') {
						$this.parent().addClass('checked');
						$this.closest('#search-labels').prepend($this.parent());
						$this.prop('checked', true);
						$this.trigger('click');
					} else if ($this.val() == 'uw') {
						$this.parent().removeClass('checked');
		                $this.prop('checked', false);
					}
				});
        	}
		},
		init: function(){
			this.search.switchDefault();
		}
	}


	$(window).load(function() {
		ITConnect.init();
	});
})();