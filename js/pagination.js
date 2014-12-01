$('#refreshSet').on('click',function() {
	var categories 	= '%';
	var coastSign 	= $('#coastSign').val();
	var coastPrice	= $('#coastPrice').val();


	$('input[type=checkbox]:checked.setCategory').each(function(e) {
		categories += $(this).attr('id') + '%';
	})

	$.post('classes/pagination.class.php',
	{
		'command'		: 'getPagination',
		'pagination'	: '0,10', 
		'categoriesIDs'	: categories,
		'priceSign'		: coastSign,
		'priceCost'		: coastPrice
	}, function(data)
	{
		$("#pagination").html(data)
	})

	return false;
})

$('#pagination').on('click','.pagination', function() {

	var categories 	= '%';
	var coastSign 	= $('#coastSign').val();
	var coastPrice	= $('#coastPrice').val();
	var pagination 	= $(this).attr('id');

	$('input[type=checkbox]:checked.setCategory').each(function() {
		categories += $(this).attr('id') + '%';
	})

	$.post('classes/pagination.class.php',
	{
		'command'		: 'getPagination',
		'pagination'	: pagination, 
		'categoriesIDs'	: categories,
		'priceSign'		: coastSign,
		'priceCost'		: coastPrice
	}, function(data)
	{
		$("#pagination").html(data)
	})
	return false;
})


$(document).ready(function() {
	$("#refreshSet").click();
})