(function(){
	ITConnect = {
		popup: {
			create: function(){
				$('.itc-popup').each(function(){
					$(this).click(function(event){
						var href = $(this).attr('data-href') || 'http://www.uw.edu',
						    title = $(this).attr('data-title') || 'IT Connect Popup',
						    width = $(this).attr('data-width') || '500',
						    height = $(this).attr('data-height') || '300',
						    menubar = $(this).attr('data-menubar') || 'no',
						    location = $(this).attr('data-location') || 'no',
						    resizable = $(this).attr('data-resizable') || 'yes',
						    scrollbars = $(this).attr('data-scrollbar') || 'no',
						    status = $(this).attr('data-status') || 'yes';

						var popupVariables = 'width=' + width + ',height=' + height + ',menubar=' + menubar + ',location=' + location + ',resizable=' + resizable + ',scrollbars=' + scrollbars + ',status=' + status;
						window.open(href, title, popupVariables);
					})
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
		svg: {
			makeInline: function() { 
			    /*
			     * Replace all SVG images with inline SVG
			     */
		        $('img.svg').each(function(){
		        	console.log($(this);
		            var $img = jQuery(this);
		            var imgID = $img.attr('id');
		            var imgClass = $img.attr('class');
		            var imgURL = $img.attr('src');

		            jQuery.get(imgURL, function(data) {
		                // Get the SVG tag, ignore the rest
		                var $svg = jQuery(data).find('svg');

		                // Add replaced image's ID to the new SVG
		                if(typeof imgID !== 'undefined') {
		                    $svg = $svg.attr('id', imgID);
		                }
		                // Add replaced image's classes to the new SVG
		                if(typeof imgClass !== 'undefined') {
		                    $svg = $svg.attr('class', imgClass+' replaced-svg');
		                }

		                // Remove any invalid XML tags as per http://validator.w3.org
		                $svg = $svg.removeAttr('xmlns:a');

		                // Replace image with new SVG
		                $img.replaceWith($svg);

		            }, 'xml');

		        });
				console.log('hey');
			}
		},
		init: function(){
			this.popup.create();
			this.search.switchDefault();
			this.sitemap.makeInteractive();
			this.svg.makeInline();
		}
	}


	$(window).load(function() {
		ITConnect.init();
	});
})();
