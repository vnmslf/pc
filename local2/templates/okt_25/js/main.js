$(document).ready(function() {
})

$(document).on('click', '.catalog-button', function() {
	var body = $('body'),
		header = $('header');
	if(header.hasClass('menu-open')) {
		header.removeClass('menu-open');
		body.removeClass('no-scroll');
	} else {
		header.addClass('menu-open');
		body.addClass('no-scroll');
	}
})

$(window).scroll(function() {
	var header = $(document).find('header'),
		headerTopH = header.find('.header__top-bar').height(),
		headerMiddleH = header.find('.header__middle').height(),
		headerManagement = header.find('.management');
	if($(window).scrollTop() >= headerTopH + headerMiddleH) {
		headerManagement.addClass('fixed');
	} else {
		headerManagement.removeClass('fixed');
	}
});