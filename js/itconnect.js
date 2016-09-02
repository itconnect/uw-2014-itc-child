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
		sitemap: {
			makeInteractive: function() {
				if ($('.page-list')) {
				    var page_title = $('#main_content').find('h1').first().text();
					if (page_title.indexOf('Sitemap') >= 0) {
						// Only manipulate if JS is turned on
						$('.page-list').addClass('interactive');

						// Find the list items
						$('.page_item').each(function(){
							//create span for list items
							$('<span/>', {
								'class':'toggle',
								'aria-hidden':'true',
							}).prependTo($(this));
						});

						// Add event listeners for clicks
						$('.page_item_has_children .toggle').each(function(){
							$(this).on('click', function(){
								$(this).closest('.page_item').toggleClass('collapsed');
							});
						});

						// Collapse / Expand all buttons
						$('<div/>', {
							'class':'sitemap-controls',
							'aria-hidden':'true',
						}).append(
							$('<a/>', {
								'class':'control exp',
								'text':'Expand all'
							}).on('click', function(){
								$('.page_item.collapsed').each(function(){
									$(this).removeClass('collapsed');
								});
							})
						).append(
							$('<a/>', {
								'class':'control col',
								'text':'Collapse all'
							}).on('click', function(){
								$('.page_item_has_children').each(function(){
									$(this).addClass('collapsed');
								});
							})
						).insertBefore('.page-list');
					}
				}
			}
		},
		init: function(){
			this.search.switchDefault();
			this.sitemap.makeInteractive();
		}
	}


	$(window).load(function() {
		ITConnect.init();
	});
})();
