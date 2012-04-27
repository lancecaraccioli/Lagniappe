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
							option.appendText(item.name);
							$('item').appendChild(option);
						}
						
					});
					$('item').fireEvent('change');
				});
				$('item').addEvent('change', function(){
					var itemId = $('item').get('value');
					var product = jsonResponse.storeData[itemId-1];
					$('description').set('html',product.description);
					$('product-image').setStyle('background-image', 'url('+product.image+')');
				});
			});
			$('category').fireEvent('change');
		}
	});
	myRequest.send();
};

window.addEvent('domready',init);
