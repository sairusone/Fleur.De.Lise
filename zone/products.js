$('.left').on('change', 'select[name="productID"]', function() {
	var productID = $("select[name='productID']").val();
	

	$.post('service.products.class.php',{
		'command'	: 'getCategoriesList',
		'productID'	: productID
	}, function(data) {

		$('section.left').find('i').html('Товар находится в категориях:<br>' + data)

	});

	$.post('service.products.class.php',{
		'command'	: 'getProductImage',
		'productID'	: productID
	}, function(data) {

		$('section.left').find('img').attr({'src':'../content/' + data});
		$('section.left').find('input[name="prodSelectImage"]').val(data);

	})
})


$('.right').on('click', 'select[name="prodCatsList"]', function() {
	var categoriesIDs = $("select[name='prodCatsList']").val();
	
	$('input[name="prodCats"]').val(categoriesIDs);
	
})