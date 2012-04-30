//Javascript file for question #5
//MooTools documentation can be found at www.mootools.net
var products = [];
function getCategories(callback){
	var categoryRequest = new Request({
		url:'processAHR.php?action=load',
		format:'json',
		onSuccess:function(responseText){
			var categoryJson = JSON.decode(responseText);
			setupCategories(categoryJson.categories);
		}
	});
	categoryRequest.send();
}

function getProducts(catid, callback){
	var productRequest = new Request({
		url:'processAHR.php?action=loadProducts&catid='+catid,
		format:'json',
		onSuccess:function(responseText){
			productData = JSON.decode(responseText);
			Array.each(productData.storeData, function (item,index,object){
				setProduct(item.item_id,item);
			});
			setupProducts(productData.storeData);
		}
	});
	productRequest.send();
}

function setupProducts(products){
	$('item').getElements('option').destroy();
	Array.each(products, function(item,index,object){
		var option = new Element('option', {value:item.item_id});
		option.appendText(item.name + ' - $' + item.price);
		$('item').appendChild(option);
	});
	$('item').fireEvent('change');
}

function getProduct(productId){
	return products[productId];
}

function setProduct(productId, product){
	products[productId] = product;
}

function setupProduct(product){
	$('description').set('html',product.description);
	$('product-image').getElement('img').set('src', product.image);
	$('product-name').set('html', product.name+": $"+product.price);
}

function setupCategories(categories){
	$('category').getElements('option').destroy();
	Array.each(categories, function(item,index,object){
		var option = new Element('option', {value:index});
		option.appendText(item);
		$('category').appendChild(option);
	});
	$('category').fireEvent('change');
}

function init(){
	$('category').addEvent('change', function(){
		var catid = $('category').get('value');
		getProducts(catid);
	});
	$('item').addEvent('change', function(){
		var itemId = $('item').get('value');
		setupProduct(getProduct(itemId));
	});
	$('add-to-cart').addEvent('click', function(){
		var itemId = $('item').get('value');
		var cartItemEntry = new Element('tr');
		var itemNameData  = new Element('td');
		itemNameData.appendText(products[itemId].name);
		var itemPriceData = new Element('td');
		itemPriceData.appendText('$'+products[itemId].price);
		var removeLinkColumn = new Element('td');
		var removeButton = new Element('a');
		removeButton.appendText('Remove');
		removeButton.set('href','#');
		removeButton.addEvent('click', function(){
			//remove the parent tr
			removeButton.getParent().getParent().destroy();
			redrawCart();
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
		redrawCart();
	});
	$('checkout').addEvent('click',function(){
		alert('TODO: checkout');
		return false;
	});
	getCategories();
	
};

function redrawCart(){
	if ($('shopping-cart').getElement('tbody').getElements('tr').length <= 0){
		$('shopping-cart').setStyle('display','none');
		$('empty-shopping-cart').setStyle('display', 'block');
	}
	else {
		$('shopping-cart').setStyle('display','table');
		$('empty-shopping-cart').setStyle('display', 'none');		
	}
	recalculateCartTotal();
}

function recalculateCartTotal(){
	var total = 0;
	Array.each($('shopping-cart').getElements('input'), function(item,index,object){
		var productId = item.get('value');
		total += productData[productId-1].price;
	});
	$('shopping-cart').getElement('.cart-total').set('html','$'+total);
}
window.addEvent('domready',init);
window.addEvent('domready',redrawCart);