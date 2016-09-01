(function(){
	ITConnect = {
		behaviors: {
			slideScroll: function() {
				$('a[href*="#"]:not([href="#"])').click(function() {
				    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
						var target = $(this.hash),
						    hash = this.hash.substr(1);

						target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
						if (target.length) {
							$('html, body').animate({
							  scrollTop: target.offset().top
							}, 1000);
							window.location.hash = hash;
							return false;
						}
				    }
				});
			}
		},
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
			this.behaviors.slideScroll();
		}
	}


	$(window).load(function() {
		ITConnect.init();
	});
})();
