$('body').on('click', '.prop__button', function() {
	var container = $(this).parents('.product__right'),
		table = $('.product__technical'),
		article = container.find('.article').find('span');
		newValue = $(this).attr('data-value'),
		articleArray = [],
		newArticle = [],
		prop__block = $(this).parents('.prop__block'),
		index = prop__block.attr('data-index'),
		diameterIndex = container.find('.prop__block[data-input="diameter"]').find('.prop__button.active').attr('data-index'),
		weightOutput = $(this).attr('data-output');
	articleArray = article.text().split('.');
	articleArray[articleArray.length - index] = newValue;
	newArticle = articleArray.join('.');
	article.text(newArticle);
	prop__block.find('.prop__button').removeClass('active');
	$(this).addClass('active');
	diameterIndex = container.find('.prop__block[data-input="diameter"]').find('.prop__button.active').attr('data-index');
	table.find('.product__row').each(function() {
		if($(this).find('.product__value').attr('data-output') !== 'none') {
			if($(this).find('.product__value').attr('data-output') !== 'mass') {
				$(this).find('.product__value').text(updateTechnicalTable(container, $(this)));
			} else {
				$(this).find('.product__value').text(updateWeightRow(container, $(this), diameterIndex));
			}
		}
	})
})
function updateTechnicalTable(container, row) {
	var output;
	output = container.find('.prop__block[data-input="' + row.find('.product__value').attr('data-output') + '"]').find('.active').text();
	return output;
}
function updateWeightRow(container, row, diameterIndex) {
	var output,
		weightSelector = container.find('.prop__block[data-input="weight"]').find('.prop__button.active').attr('data-output');
	output = container.find('.prop__block[data-input="' + weightSelector + '"]').find('[data-index="' + diameterIndex + '"]').text();
	return output;
}
$(document).ready(function() {
	$('.owl-carousel').owlCarousel({
		loop: true,
		margin: 10,
		nav: true,
		items: 3,
		responsive: {
			0: {
				items: 2,
			},
			600: {
				items: 3,
			},
			1000: {
				items: 4,
			}
		}
	});
});