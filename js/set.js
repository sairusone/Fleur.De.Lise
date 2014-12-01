$('#refreshSet').click(function() {
	var categories 	= '%';
	var coastSign 	= $('#coastSign').val();
	var coastPrice	= $('#coastPrice').val();

	$('input[type=checkbox]:checked.setCategory').each(function() {
		categories += $(this).attr('id') + '%';
	})


	$("#content").html('<center>Загрузка товаров. Пожалуйста, подождите...</center>');

	$.post('classes/products.class.php',
	{
		'command'		: 'getProductsList',
		'reqPagination'	: '0,10', 
		'reqCategories'	: categories,
		'reqCoastSign'	: coastSign,
		'reqCoastPrice'	: coastPrice
	}, function(data)
	{
		$("#content").html(data)
	})

	return false;
})

$('#pagination').on('click', '.pagination', function() {
	var categories 	= '%';
	var coastSign 	= $('#coastSign').val();
	var coastPrice	= $('#coastPrice').val();
	var pagination 	= $(this).attr('id');

	$('input[type=checkbox]:checked.setCategory').each(function() {
		categories += $(this).attr('id') + '%';
	})


	$("#content").html('<center>Загрузка товаров. Пожалуйста, подождите...</center>');

	$.post('classes/products.class.php',
	{
		'command'		: 'getProductsList',
		'reqPagination'	: pagination, 
		'reqCategories'	: categories,
		'reqCoastSign'	: coastSign,
		'reqCoastPrice'	: coastPrice
	}, function(data)
	{
		$("#content").html(data)
	})

	return false;
})