<?php


$inventoryData = Inventory::with('product.assetCategory')->findOrFail($inventoryID);


?>