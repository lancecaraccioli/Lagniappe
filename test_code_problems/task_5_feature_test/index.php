<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<link rel="stylesheet" href="store.css" type="text/css">
	<script language="JavaScript" type="text/javascript" src="mootools.js"></script>
	<script language="JavaScript" type="text/javascript" src="store.js"></script>
</head>
<body>
<div id="content-wrapper">
	<h1 id="title">Elance Store</h1>
	<div id="content">
		
			<div id="left-column">
				<label id="category-label">Select a Category:</label>
				<select id="category" name="catid">
				</select>
				<label id="item-label">Select an Item:</label>
				<select id="item" name="item_id">
				</select>
				<label id="shopping-cart-label">Shopping Cart</label>
				<div id="empty-shopping-cart">Your shopping cart is empty.</div>
				<form action="#" id = "purchase_cart">
					<table id="shopping-cart" cellpadding="0" cellspacing="0">
						<col width="50%" />
						<col width="25%" />
						<col width="25%" />
						<thead>
							<tr>
								<th>Item</th>
								<th>Price</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
						<tfoot>
							<tr>
								<td>Total</td>
								<td class="cart-total"></td>
								<td></td>
							</tr>
						</tfoot>
					</table>
					<button id="checkout">Checkout</button>
				</form>
			</div>			
			<div id = "right-column">
				<div id="product-image" >
					<img src="" />
					<div id="name-footer">
					</div>
					<div id = "product-name">
					</div>
				</div>
				<div id="description">
				</div>
				<button id="add-to-cart">Add To Cart</button>
			</div>
		
	</div>
</div>
</body>
</html>