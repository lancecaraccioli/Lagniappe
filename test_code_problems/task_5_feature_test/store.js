//Javascript file for question #5
//MooTools documentation can be found at www.mootools.net
function init(){
	var myRequest = new Request({
		url:'processAHR.php?action=load',
		format:'json',
		onSuccess:function(responseText){
			var jsonResponse = JSON.decode(responseText);
			Array.each(jsonResponse.categories, function(item,index,object){
				var option = new Element('option', {value:index});
				option.appendText(item);
				$('category').appendChild(option);
				$('category').addEvent('change', function(){
					$('item').getElements('option').destroy();
					var catid = $('category').get('value');
					Array.each(jsonResponse.storeData, function(item,index,object){
						if (catid == item.catid){
							var option = new Element('option', {value:item.item_id});
							option.appendText(item.name + ' - $' + item.price);
							$('item').appendChild(option);
						}
					});
					$('item').fireEvent('change');
				});
				$('item').addEvent('change', function(){
					var itemId = $('item').get('value');
					var product = jsonResponse.storeData[itemId-1];
					$('description').set('html',product.description + ' -  $' + product.price);
					$('product-image').set('html', '<img src="'+product.image+'" />');
				});
			});
			$('add-to-cart').addEvent('click', function(){
				var itemId = $('item').get('value');
				var cartItemEntry = new Element('tr');
				var itemNameData  = new Element('td');
				itemNameData.appendText(jsonResponse.storeData[itemId -1].name);
				var itemPriceData = new Element('td');
				itemPriceData.appendText('$'+jsonResponse.storeData[itemId -1].price);
				var removeLinkColumn = new Element('td');
				var removeButton = new Element('a');
				removeButton.appendText('Remove');
				removeButton.set('href','#');
				removeButton.addEvent('click', function(){
					//remove the parent tr
					removeButton.getParent().getParent().destroy();
					showHideCart();
				});
				var hiddenProductInput = new Element('input');
				hiddenProductInput.set('type', 'hidden');
				hiddenProductInput.set('name', 'products[]');
				hiddenProductInput.set('value', itemId);
				removeLinkColumn.appendChild(removeButton);
				removeLinkColumn.appendChild(hiddenProductInput);
				cartItemEntry.appendChild(itemNameData);
				cartItemEntry.appendChild(itemPriceData);
				cartItemEntry.appendChild(removeLinkColumn);
				$('shopping-cart').getElement('tbody').appendChild(cartItemEntry);
				showHideCart();
			});
			$('category').fireEvent('change');
			
		}
	});
	myRequest.send();
};
function showHideCart(){
	if ($('shopping-cart').getElements('tr').length <= 1){
		$('shopping-cart').setStyle('display','none');
		$('empty-shopping-cart').setStyle('display', 'block');
	}
	else {
		$('shopping-cart').setStyle('display','table');
		$('empty-shopping-cart').setStyle('display', 'none');		
	}
}
window.addEvent('domready',init);
window.addEvent('domready',showHideCart);