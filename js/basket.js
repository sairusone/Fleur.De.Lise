// НАЖАТИЕ НА КНОПКУ "В КОРЗИНУ" У ТОВАРА
$('#content').on('click', '.buyButton', function() {
	// ЗАПОМИНАЕМ ID ТОВАРА
	var productID = $(this).attr('id');

	// ОТПРАВЛЯЕМ ЗАПРОС НА ДОБАВЛЕНИЕ ТОВАРА В КОРЗИНУ
	$.post('classes/basket.class.php', {
		'shopCommand'	: 'addProduct',
		'productID'		: productID
	}, function(data) {
		// РАЗДЕЛЯЕМ НА МАССИВ РЕЗУЛЬТАТ ЗАПРОСА
		var returnData = data.split(',');

		// ЕСЛИ ЗАПРОС УСПЕШНО ВЫПОЛНЕН...
		if (returnData[0] == 'True')
		{
			// ...ИЗМЕНЯЕМ ОБЩЕЕ КОЛИЧЕСТВО ТОВАРОВ В КОЗИНЕ И ИХ СТОИМОСТЬ
			$('#count').html(returnData[1]);
			$('#price').html(returnData[2]);
		}
		else
		{
			// ЕСЛИ ПРИ ДОБАВЛЕНИИ ВОЗНИКЛА ОШИБКА - СООБЩАЕМ ПОЛЬЗОВАТЕЛЮ
			alert('Невозможно добавить товар в корзину!\n\nТекст ошибки:\n' + data + '\n\nОбратитесь к администратору.')
		};
	})

	return false;
});

// ОТКРЫТИЕ ОКНА СО СПИСКОМ ТОВАРОВ В КОРЗИНЕ
$('#editBasket').click(function() {

	// ПОКАЗЫВАЕМ БЛОК ДЛЯ ВЫВОДА СПИСКА ТОВАРОВ В КОРЗИНЕ
	$("#basketEditList").css({'display':'block'});

	if ( $("#editBasketTable").parent().find('center').html() != undefined )
	{
		$("#editBasketTable").parent().find('center').remove();
	};


	$('#basketDIV').attr({'style':'display:block; z-index: 50; position: fixed; width: 220px; top: 75px;'});
	$('#basketDIV').find('u').attr({'style':'display:none;'});


	// ВЫВОДИМ ЗАГОЛОВОК ТАБЛИЦЫ И НАДПИСЬ О ЗАГРУЗКЕ СПИСКА ТОВАРОВ
	$('#editBasketTable').html('<tr style="background: #ff9401; color: white" id="tableHeader"><td style="width: 300px;">Название</td><td style="width: 100px;">Цена</td><td style="width: 100px;">Количество</td><td style="width: 150px;">Общая стоимость</td><td style="width: 50px;"></td></tr>')
	$("#tableHeader").after('<tr><td>Идет загрузка списка товаров...</td><td></td><td></td><td></td><td></td></tr>');

	// ОТПРАВЛЯЕМ ЗАПРОС НА СПИСОК ТОВАРОВ
	$.post('classes/basket.class.php',{
		'shopCommand':'listProduct'
	}, function(data) {
		var returnData = data.split('|');

		if ( returnData[0] == 'True' )
		{
			// ОЧИЩАЕМ ПРОСТРАНСТВО БЛОКА, ЗАНОВО ВЫВОДИМ ЗАГОЛОВОК ТАБЛИЦЫ И ЗАПОЛНЯЕМ ЕЕ РЕЗУЛЬТАТОМ
			$('#editBasketTable').html('<tr style="background: #ff9401; color: white" id="tableHeader"><td style="width: 300px;">Название</td><td style="width: 100px;">Цена</td><td style="width: 100px;">Количество</td><td style="width: 150px;">Общая стоимость</td><td style="width: 50px;"></td></tr>')
			$("#tableHeader").after( returnData[1] );
		}
		else
		{
			$('#editBasketTable').html('<tr style="background: #ff9401; color: white" id="tableHeader"><td style="width: 300px;">Название</td><td style="width: 100px;">Цена</td><td style="width: 100px;">Количество</td><td style="width: 150px;">Общая стоимость</td><td style="width: 50px;"></td></tr>')

			if ( $("#editBasketTable").parent().find('center').html() == undefined )
			{
				$("#editBasketTable").after( returnData[1] );
			};
		};
		

	})

	
	return false;
})

// ЗАКРЫТИЕ ОКНА РЕДАКТИРОВАНИЯ СПИСКА ПОКУПОК
$('#closeBasket').click(function() {
	$("#basketEditList").css({'display':'none'});
	$('#basketDIV').attr({'style':''});
	$('#basketDIV').find('u').attr({'style':'display:inline-table;'});
	return false;
})

// ПРИ ЩЕЛЧКЕ МЫШИ НА ПОЛЕ "КОЛИЧЕСТВО" - ПОКАЗЫВАЕМ ПОЛЕ ДЛЯ ИЗМЕНЕНИЯ КОЛИЧЕСТВА ТОВАРОВ
$('#editBasketTable').on('click', '.basketCount', function(e) {

	// ЗАПОМИНАЕМ ПРЕЖНЕЕ КОЛИЧЕСТВО ТОВАРА
	var basketCount = $(this).html();

	// ПРОВЕРЯЕМ НА ОТСУТСТВИЕ ЭЛЕМЕНТА INPUT В НУЖНОМ ПОЛЕ
	if ( $(this).find('input').val() == undefined )
	{
		// ЕСЛИ ЭЛЕМЕНТА НЕ СУЩЕСТВУЕТ - ДОБАВЛЯЕМ ЕГО
		$(this).html('<input type="text" value="' + basketCount + '" class="basketCountInput" />' +
					 '<input type="hidden" value="' + basketCount + '" id="oldCountValue"');
	};

	// УСТАНАВЛИВАЕМ ФОКУС НА ПОЛЕ ИЗМЕНЕНИЯ КОЛИЧЕСТВА ТОВАРА
	$(this).find('input').focus();
	
})

// ИЗМЕНЕНИЕ ЗНАЧЕНИЯ В ПОЛЕ "КОЛИЧЕСТВО" ПОСЛЕ ВВОДА
$('#editBasketTable').on('keyup', '.basketCount', function(e) {

	var newValue 			= $(this).find('input').val();
	var productID 			= $(this).parent().attr('id');
	var productTotalPrice 	= $(this).parent().find('.basketTotalPrice')
	
	if (newValue != '')
	{

			$.post('classes/basket.class.php',{
				'shopCommand'	: 'changeCount',
				'productID'		: productID,
				'countValue'	: newValue
			}, function(data) {
				var returnData = data.split(',');

				if (returnData[0] == 'True')
				{
					$(this).html( newValue );
					productTotalPrice.html( returnData[1] );

					$("#count").html( returnData[2] );
					$("#price").html( returnData[3] );
				}
				else
				{
					alert( returnData[1] )
				};
			})

	};

	
})

// ЕСЛИ НАЖАТА КЛАВИША ENTER - ВВОД ЗАВЕРШЕН
$('#editBasketTable').on('keypress', '.basketCount', function(e) {

	if ( e.which == 13 )
	{
		$(this).focusout();
	}
	
})


$('#editBasketTable').on('focusout', '.basketCount', function(e) {

	var newValue = $(this).find('input').val();
	$(this).html( newValue );
	
})





$('#editBasketTable').on('click', '.basketDelete', function(e) {
	var parentNode = $(this).parent();

	var productID = parentNode.attr('id');
	
	$.post('classes/basket.class.php', {
		'shopCommand'	: 'removeProduct',
		'productID'		: productID
	}, function(data) {
		var returnData = data.split(',');

		if (returnData[0] == 'True')
		{
			$("#count").html(returnData[1]);
			$("#price").html(returnData[2]);
			parentNode.remove();

			if ( $('.basketCount').html() == undefined )
			{
				$('#editBasketTable').after('<center>Корзина пуста</center>')
			};
		};
	})
	
})


//////////////////////////////////////////////////////////////////////////////////////////////////////
$('#payment').on('click', function() {
	$('input[name="WMI_PAYMENT_AMOUNT"]').val( $("#price").html() );

	$('#waytopay').click();
})