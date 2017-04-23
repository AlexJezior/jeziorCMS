
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
	el: '#app'
});


$(function(){
	if($('.alert-success').length > 0){
		setTimeout(function(){
			$('.alert-success').fadeOut(2000);
		},4000);
	}


	if($('#leftAdminMenu').length > 0){
		var leftMenu = $('#leftAdminMenu');
		var originalTop = parseInt(leftMenu.css("top"));
		if($(document).scrollTop() < 51){
			leftMenu.css("top", (originalTop - $(document).scrollTop()));
		}else if(originalTop >= 1){
			leftMenu.css("top", 0);
		}

		$(document).on('scroll',function(e){
			var newTop = parseInt(leftMenu.css("top"));
			if($(document).scrollTop() < 51){
				leftMenu.css("top", (originalTop - $(document).scrollTop()));
			}else if(newTop >= 1){
				leftMenu.css("top", 0);
			}
		});


		//"Collapse Menu" button has been pressed.
		$('#toggleLeftNavigation').on('click',function(e){
			e.preventDefault();

			$('span.glyphicon', this).toggleClass('glyphicon-chevron-left glyphicon-chevron-right');
			leftMenu.toggleClass('expanded compressed');
			var newValue = $('span.glyphicon', this).hasClass('glyphicon-chevron-left') ? '1' : '0';
			$.post('/jezior-cms/update-menu/'+newValue, {'_token': $('meta[name=csrf-token]').attr('content')});

			update_view();

		});

		//on ready, update the view css.
		update_view();

		function update_view(){
			if(leftMenu.hasClass('compressed')){
				$('#adminContent').css('width', $(document).width() - 46);
			}else{
				$('#adminContent').removeAttr('style');
			}
		}
	}

});

