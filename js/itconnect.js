(function(){
	ITConnect = {
		megamenu: {
			alignDropdowns: function(){
				$('.dawgdrops-item-itc').one('mouseenter', function(e){
					$(this).find('.mega-wrap').css({'height': ($(this).find('.mega-container').height() + 30) + 'px'});
				});
			},
			megalinks: [],
			place: 0,
			addLinks: function(container){
				$this = container;
				$this.find('a').each(function(){
					ITConnect.megamenu.megalinks.push($(this));
				});
			},
			clearLinks: function(){
				ITConnect.megamenu.megalinks = [];
				ITConnect.megamenu.place = 0;
			},
			closeMenus: function(){
				$('.mega-wrap').each(function(){
					$(this).css({'display':''});
				});
			},
			cycle: function(direction){
				if (direction == 'next') {
					ITConnect.megamenu.place++;
					if (ITConnect.megamenu.place >= ITConnect.megamenu.megalinks.length) {
						ITConnect.megamenu.place = 0;
					}
					return ITConnect.megamenu.megalinks[ITConnect.megamenu.place];
				} else if (direction == 'prev') {
					ITConnect.megamenu.place--;
					if (ITConnect.megamenu.place < 0) {
						ITConnect.megamenu.place = ITConnect.megamenu.megalinks.length - 1;
					}
					return ITConnect.megamenu.megalinks[ITConnect.megamenu.place];
				}
				//code to change to count locatoin
			},
			accessibility: function(){
				// Aria for mouse events
				$('.dropdown-toggle').hover(
					function(){
						$(this).attr('aria-expanded', 'true');
					}, function(){
						$(this).attr('aria-expanded', 'false');
					}
				);

				// Keyboard controls expand dropdowns
				$('.dawgdrops-item-itc > a').keydown(function(e) {
					$this = $(this);
					$mega = $this.siblings('.mega-wrap');
					switch (e.which){
						case 40: //down
						case 13: //enter
							ITConnect.megamenu.closeMenus(); // Close any other open menus
							$(e.currentTarget).attr('aria-expanded', 'true');
							$mega.css({'display':'block'});
							$mega.find('> ul').attr('aria-expanded','true');
							$mega.find('ul.mega-container > li').first().children('a').focus();
							ITConnect.megamenu.addLinks($mega);
						 	return false;
							break;
						
						case 37: //left
							$(e.currentTarget).parent().prev().children('a').first().focus()
							return false;
							break;


						case 39: //right
							$(e.currentTarget).parent().next().children('a').first().focus()
							return false;
							break;

						case 32: //spacebar
							window.location.href = $(e.currentTarget).attr('href')
							return false;
							break;
					}
				});

				// Keyboard controls navigate submenus
				$('.mega-container a').keydown(function(e) {
					$this = $(this);
					$mega = $this.closest('.mega-wrap');

					switch ( e.which ) {
						case 9: //tab
							$mega.css({'display':''});
							$this.closest('.mega-container').attr('aria-expanded', 'false');
							$this.closest('.dawgdrops-item-itc').children('a.dropdown-toggle').attr('aria-expanded', 'false');
							ITConnect.megamenu.clearLinks();
							break;

						case 39: //right
							$mega.css({'display':''});
							$this.closest('.dawgdrops-item-itc').children('a.dropdown-toggle').attr('aria-expanded', 'false');
							$this.closest('.mega-container').attr('aria-expanded', 'false');
							$this.closest('.dawgdrops-item-itc').next().children('a').focus();
							ITConnect.megamenu.clearLinks();
							return false;
							break;

						case 37: //left
							$mega.css({'display':''});
							$this.closest('.dawgdrops-item-itc').children('a.dropdown-toggle').attr('aria-expanded', 'false');
							$this.closest('.mega-container').attr('aria-expanded', 'false');
							$this.closest('.dawgdrops-item-itc').prev().children('a').focus();
							ITConnect.megamenu.clearLinks();
							return false;
							break;

						case 40: //down
							$nextLink = ITConnect.megamenu.cycle('next'); 
							$nextLink.focus();
							return false
							break;

						case 38: //up
							$nextLink = ITConnect.megamenu.cycle('prev'); 
							$nextLink.focus();
							return false
							break;

						case 32: //spacebar
						case 13: //enter
							window.location.href = $(e.currentTarget).attr('href')
							return false;

						case 27: //esc
							$mega.css({'display':''});
							$this.closest('.dawgdrops-item-itc').children('a.dropdown-toggle').attr('aria-expanded', 'false');
							$this.closest('.mega-container').attr('aria-expanded', 'false');
							$this.closest('.dawgdrops-item-itc').children('a').focus();
							return false;
							break;
					}
				});
			}
		},
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
			},
			checkboxes: function(){
				// Retains the state of the checkboxes when the page is reloaded
				var checkboxValues = JSON.parse(localStorage.getItem('checkboxValues')) || {},
					$checkboxes = $('#searchbox :checkbox'),
					time_now  = (new Date()).getTime();

				// Delete checkbox state if it was set more than an hour ago
				if (localStorage.getItem('checkboxTime') && time_now > (localStorage.getItem('checkboxTime') + 3600000)) {
					localStorage.removeItem('checkboxValues');
				}

				// Set local storage  item when checkboxes are changed, and load storage on back load
				$checkboxes.on('change', function(){
					$checkboxes.each(function(){
						checkboxValues[this.id] = this.checked;
					});
					localStorage.setItem('checkboxValues', JSON.stringify(checkboxValues));
				});
				$.each(checkboxValues, function(key, value) {
					$('#' + key).prop('checked', value);
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
					var $img = $(this);
					var imgID = $img.attr('id');
					var imgClass = $img.attr('class');
					var imgURL = $img.attr('src');

					$.get(imgURL, function(data) {
						// Get the SVG tag, ignore the rest
						var $svg = $(data).find('svg');

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
			}
		},
		report: {
			show: function(){
				$('.report-link').each(function(){
					$(this).click(function(event){
						$('#report-form').slideToggle();
					})
				});	
			}
		},
		init: function(){
			this.megamenu.alignDropdowns();
			this.megamenu.accessibility();
			this.popup.create();
			this.search.switchDefault();
			this.search.checkboxes();
			this.sitemap.makeInteractive();
			this.svg.makeInline();
			this.report.show();
		}
	}


	$(window).load(function() {
		ITConnect.init();
	});
})();
