;(function($, undefined){

	/**
	 * PROJECT'S BREAKPOINT
	 * cf. _config.scss
	----------------------------------------------------------------------------- */
	/*
		mobile:   320px
	    tablet:   640px
	    desktop:  980px 
	    large:    1700px
    */

	var large 			= '106.25em', 	// 1700px
		until_large		= '106.24em', 	// 1699px

		desktop 		= '61.25em', 	// 980px
		until_desktop 	= '61.24em',  	// 979px

		tablet 			= '40em',		// 640px
		until_tablet	= '39.99em',	// 639px

		mobile 			= '20em', 		// 320px
		until_mobile	= '19.99em';	// 319px


	/**
	* Change the body's background-image
	* @author mguillaumet
	* @param node: node selector
	* @return void
	----------------------------------------------------------------------------- */
	$.rmChangeBackground = function(node)
	{

		var $node 		= $(node),
			$items		= $node.find('> li'),
			myTimeOut;

		function isActive(link){
			$items.removeClass('is-active');
			link.parent('li').addClass('is-active');
		}

		
		$items.each(function(){

			$(this).find('a').on('mouseenter.rmChangeBackground', function(){

				var $link = $(this);

				if ( !$(this).parent('li').hasClass('is-active'))
				{
					myTimeOut = setTimeout(function(){
						isActive( $link );
					}, 180);
				}

			});
		
		});

		$items.find('a').on('mouseleave.rmChangeBackground', function(){
			clearTimeout(myTimeOut);
		});

		$items.find('a').on('click.rmChangeBackground', function(){
			clearTimeout(myTimeOut);
		});
	}
	$.fn.rmChangeBackground = function(){
		return this.each(function(){
		    (new $.rmChangeBackground(this));
		});
	};


	/**
	 * MOBILE NAV
	 * @author mhguillaumet
	----------------------------------------------------------------------------- */
	$.rmMobileNav = function(node)
	{
		var $controler 			= $(node),
			$target 			= $($controler.attr('href')).length ? $($controler.attr('href')) : $('#' + $controler.attr('aria-owns')),
			$parent 			= $($controler.attr('data-toggle-parent')),
			activeClass 		= 'is-active';


		function _bindEvents()
		{
			if (Modernizr.mq('only screen and (max-width: '+ until_desktop +')')) 
    		{

    			// Display menu when clicking on the burger button

    			$controler.on('click.mobileNav', function(e){

					e.preventDefault();

					var $popinElements = $target.find('a, button, :input');

					if ($parent.hasClass(activeClass))
					{
						$target.hide();
						$parent.removeClass(activeClass);
						$parent.attr( {'aria-hidden': 'true', 'tabindex': '-1'} );
						$parent.removeAttr('role');

						// Give focus to the controler
						$(this).removeClass(activeClass).focus();

						// Reset tabindex from all other elements in the DOM
						$('[tabindex]').removeAttr('tabindex');
					}
					else 
					{
						$parent.addClass(activeClass);

						// Give focus to the target
						$target.fadeIn();
						//$target.addClass(activeClass).attr( {'aria-hidden': 'false', 'tabindex':'0', 'role': 'dialog'} ).focus();
						$target.addClass(activeClass).attr( {'aria-hidden': 'false', 'tabindex':'0', 'role': 'dialog'} );

						// Remove focus from the target to patch an ugly reflow bug on IE10 and IE11
						$target.removeAttr('tabindex');

						// Remove tabindex from all other elements in the DOM
						$('a, button, :input, iframe').not($popinElements).attr('tabindex', '-1');
					}

				});


				// Close overlay with the escape key

				$(document).on('keydown', function(e)
				{
					var key = e.keyCode;

					if ( key === 27 && $target.hasClass(activeClass))
					{
						$target.hide();
						$parent.removeClass(activeClass);
						$target.attr( {'aria-hidden': 'true', 'tabindex': '-1'} );
						$target.removeAttr('role');

						// Give focus to the controler
						$controler.focus();

						// Reset tabindex from all other elements in the DOM
						$('[tabindex]').removeAttr('tabindex');
					}
				});
    		}
		}

		function _unbindEvents()
		{
			if (Modernizr.mq('only screen and (max-width: '+ until_desktop +')')) 
    		{
				$controler.off('click.mobileNav');

				if (!$parent.hasClass(activeClass))
				{
					$target.hide().attr( {'aria-hidden': 'true', 'tabindex': '-1'} );
					$target.removeAttr('role');
				}
			}
			else 
			{
				$parent.removeClass(activeClass);
				$target.show().removeAttr('aria-hidden').removeAttr('tabindex').removeAttr('role');
			}
		}


		// Launch the function once.

		_bindEvents();



		/**
		* Window resizing
		* @return void
		*/
		var debounce;

		$(window).on('scroll', function() {

			if (!!debounce) { clearTimeout(debounce); }

			debounce = setTimeout(function()
			{
				_unbindEvents();
				_bindEvents();

			}, 250);

		});

		$(window).on('resize', function() {

			if (!!debounce) { clearTimeout(debounce); }

			debounce = setTimeout(function()
			{
				_unbindEvents();
				_bindEvents();

			}, 250);
		});

	}

	$.fn.rmMobileNav = function(){
		return this.each(function(){
			(new $.rmMobileNav(this));
		});
	};



	/**
	* CLICKABLE BLOCKS
	* @author mhguillaumet
	* @param node: node selector
	* @return void


	HTML sample:

	<div class="js-clickbox"> => the box to make entirely clickable
		<div class="entry-header">
			<h3 class="entry-title">
				<a href="http://example.com/" class="js-clickbox_target"> => the link to extend
					Titre de l'article
				</a>
			</h3>
		</div>
		<div class="entry-summary">
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer fringilla neque lectus, porta consequat quam fringilla ac. Nulla ut iaculis orci. Morbi cursus, augue sed imperdiet fringilla, dui dolor porta ipsum, vel gravida mi sapien quis arcu. Nullam convallis velit at risus condimentum porta ac id erat. Vivamus porttitor, nunc nec luctus vulputate, ante mi ultricies lacus, porttitor consectetur neque nunc vel lorem. Donec et dolor et justo convallis eleifend. Maecenas lacinia elit augue, et bibendum nibh dignissim quis. Curabitur ac libero vehicula, tristique urna sit amet, egestas dolor. Sed luctus ipsum id fringilla condimentum.</p>
		</div>
		<div className="js-clickbox_avoid"> => element which should keep its own click
			<p>Curabitur ac <a href="http://example.com">libero vehicula</a>, tristique urna sit amet, egestas dolor. Sed luctus ipsum id fringilla condimentum.</p>
		</div>
	</div>

	----------------------------------------------------------------------------- */
	$.RMclickBox = function(node)
	{
	
		var jBox			= $(node),
			jLink 			= jBox.find('.js-clickbox_target').length ? jBox.find('.js-clickbox_target') : jBox.find('a:first-of-type'),
			jAvoid			= jBox.find('.js-clickbox_avoid'),
			jHoverClass		= 'is-hover',
			jActiveClass	= 'is-active';


		if (jLink.length)
		{
			var jHref			= jLink.attr('href'),
				jTarget			= jLink.attr('target');

			jBox.on('click',function(e)
			{
				e.preventDefault();
				jBox.addClass(jActiveClass);
				
				/** Si c'est un clic + CMD (Mac) ou un clic + CTRL (PC) */
				if (jTarget !== undefined)  
				{
					window.open(jHref);
				}
				else
				{
					if(e.metaKey || e.ctrlKey) 
					{
						window.open(jHref);
					}
					else 
					{
						window.location = jHref;
					}
				}
			});
			
			jBox.on('mouseenter', function()
			{
				$(node).removeClass(jHoverClass);
				if (!jBox.hasClass(jHoverClass)) jBox.addClass(jHoverClass);
			});
			
			jBox.on('mouseleave', function()
			{
				jBox.removeClass(jHoverClass);
			});
			
			jAvoid.on('click',function(e)
			{
				e.stopPropagation();
				e.preventDefault();
		
				/** Si c'est un clic + CMD (Mac) ou un clic + CTRL (PC) */
				if(e.metaKey || e.ctrlKey) 
				{
					window.open($(this).attr('href'));
				}
				else 
				{
					window.location = $(this).attr('href');
				}
			});
			
			jAvoid.on('mouseleave', function()
			{
				$(node).removeClass(jHoverClass);
				if (!jBox.hasClass(jHoverClass)) jBox.addClass(jHoverClass);
			});
		
			jAvoid.on('mouseenter', function()
			{
				jBox.removeClass(jHoverClass);
			});
			
			
			
			/**
				Si jBox contient des éléments jAvoid, on rétablit le clic 
				sur les liens et les boutons que ce bloc contient, et on
				supprime la classe .hover de jBox.
			*/
			if (jAvoid.length)
			{
				jAvoid.find('a,button').on('click',function(e)
				{
					e.stopPropagation();
				});
			}
		}
	}
	$.fn.RMclickBox = function(){
		return this.each(function(){
		    (new $.RMclickBox(this));
		});
	};


	/**
	 * HOMEPAGE: EXTEND PROJECT LINK ON MOBILE
	 * @author mhguillaumet
	 * @param node: node selector
	 * @return void
	 */
	$.rmHomeclick = function(node)
	{
		var $node = $(node);

		function _bindEvents()
		{
			if (Modernizr.mq('only screen and (max-width: '+ until_desktop +')')) 
    		{
				$node.RMclickBox();
    		}
    	}

    	function _unbindEvents()
		{
			if (Modernizr.mq('only screen and (min-width: '+ desktop +')')) 
    		{
				$node.removeClass('is-hover').off('.rmClickBox');
			}
			
		}

		// Launch the function once.

		_bindEvents();



		/**
		* Window resizing
		* @return void
		*/
		var debounce;

		$(window).on('scroll', function() {

			if (!!debounce) { clearTimeout(debounce); }

			debounce = setTimeout(function()
			{
				_unbindEvents();
				_bindEvents();

			}, 250);

		});

		$(window).on('resize', function() {

			if (!!debounce) { clearTimeout(debounce); }

			debounce = setTimeout(function()
			{
				_unbindEvents();
				_bindEvents();

			}, 250);
		});

	}

	$.fn.rmHomeclick = function(){
		return this.each(function(){
		    (new $.rmHomeclick(this));
		});
	};


	/**
	 * POPIN
	 * @author mguillaumet
	 * @param node: node selector
	 * @return void
	----------------------------------------------------------------------------- */
	$.rmPopin = function(node)
	{
		var $popin 				= $(node),
			popin_cookie_value 	= null;


		//
		// Check if cookie exists
		//
		if (Modernizr.localstorage)
		{
			popin_cookie_value = localStorage.getItem('rmTOApopin');

		} else {

			popin_cookie_value = getCookie('rmTOApopin');
		}


		//
		// Read cookie
		//
		if (!popin_cookie_value)
		{
			if ( Modernizr.mq('(min-width: '+desktop+')') )
			{
				//
				// Show popin
				//

				$popin.fadeIn().on('click.rmPopin', function(e)
				{
					$(this).hide();

					// Set cookie
					if (!Modernizr.localstorage)
					{
						// Set cookie for 30 days
						setCookie('rmTOApopin', 'displayed', 30);

					} else {

						// If browser supports localStorage, use this instead.
						localStorage.setItem('rmTOApopin', 'displayed');
					}
				});


				//
				// Close popin with the escape key
				//

				$(document).on('keydown', function(e)
				{
					var key = e.keyCode;

					if ( key === 27 )
					{
						$popin.hide();

						// Set cookie
						if (!Modernizr.localstorage)
						{
							// Set cookie for 30 days
							setCookie('rmTOApopin', 'displayed', 30);

						} else {

							// If browser supports localStorage, use this instead.
							localStorage.setItem('rmTOApopin', 'displayed');
						}
					}
				});

			}
			else 
			{
				$popin.hide();
			}
		}
	}

	$.fn.rmPopin = function(){
		return this.each(function(){
			(new $.rmPopin(this));
		});
	};

	/**
	 * RM ADJUST IMAGE WIDTH
	 * @desc Stretch WYSIWYG images to the grid
	 * @author mguillaumet
	 * @param node: node selector
	 * @return void
	----------------------------------------------------------------------------- */
	$.RMadjustImgWidth = function(container)
	{
		var $container 	= $(container),
			$body 		= $('body'),
			$img 		= $container.find('.size-large, .size-full, .size-very-large-picture');

		$img.each(function(){

			var $this = $(this);

			if (Modernizr.mq('only screen and (min-width: '+ desktop +')')) 
			{
				$this.css('width', $body.outerWidth());
			}
			else 
			{
				$this.css('width', '');
			}
		});


	}

	$.fn.RMadjustImgWidth = function(){
		return this.each(function(){
			(new $.RMadjustImgWidth(this));
		});
	};


	/**
	 * INSTANCIATION
	----------------------------------------------------------------------------- */
	$('.js-change-background').rmChangeBackground();
	$('.js-toggle-target').rmMobileNav();
	$('.js-clickbox').RMclickBox();
	$('.js-mobile-extend-click').rmHomeclick();
	$('.js-popin').rmPopin();
	$('.js-stretch-img').RMadjustImgWidth();


	/**
	 * RESIZE
	----------------------------------------------------------------------------- */
	var debounce_resize;

	$(window).on('resize', function() {

		if (!!debounce_resize) { clearTimeout(debounce_resize); }

		// HARD RESIZE
		$('.js-stretch-img').RMadjustImgWidth();

		// SOFT RESIZE
		debounce_resize = setTimeout(function()
		{
			$('.js-popin').rmPopin();

		}, 250);
	});

})(jQuery);