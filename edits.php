<?php
// Display the form to edit the product
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Retrieve the product information from Shopify using its ID
    $shopify_store_url = 'https://mmfunctions.myshopify.com';
    $access_token = 'shpat_9efc430f9b7569c1e726b97dded18';

    $product_url = $shopify_store_url . '/admin/api/2023-07/products/' . $product_id . '.json';

    $ch = curl_init($product_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'X-Shopify-Access-Token: ' . $access_token,
    ]);
    $product_data = curl_exec($ch);
    curl_close($ch);

    // if ($http_status == 200) {
        $product = json_decode($product_data, true)['product'];
        $product_name = $product['title'];
        $product_body = $product['body_html'];
        $product_price = $product['variants'][0]['price'];
        $product_compare_at_price = $product['variants'][0]['compare_at_price'];
        $product_sku = $product['variants'][0]['sku'];
        $l = $product['options'][0]['values'][0];
        $m = $product['options'][1]['values'][0];
        $n = $product['options'][2]['values'][0];
    // }
} else {
    // Handle the case when 'id' is not provided
    $product_name = null;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <?php if (isset($product_name)) { ?>
        <h1>Edit Product</h1>
        <form method="post" action="edit.php">
            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" id="product_name" value="<?php echo $product_name; ?>"><br><br>
            
            <label for="product_body">Product Description:</label>
            <textarea name="product_body" id="product_body"><?php echo $product_body; ?></textarea><br><br>
            
            <label for="product_price">Price:</label>
            <input type="text" name="product_price" id="product_price" value="<?php echo $product_price; ?>"><br><br>
            
            <label for="product_compare_at_price">Compare:</label>
            <input type="text" name="product_compare_at_price" id="product_compare_at_price" value="<?php echo $product_compare_at_price; ?>"><br><br>
            
            <label for="product_sku">SKU:</label>
            <input type="text" name="product_sku" id="product_sku" value="<?php echo $product_sku; ?>"><br><br>
            
            <label for="product_variants">Variants:</label><br>
            
            <label for="size">Size:</label>
         <select name="size">
           <option value="S" <?php if ($product['options'][0]['values'][0] === 'S') echo 'selected'; ?>>S</option>
           <option value="M" <?php if ($product['options'][0]['values'][0] === 'M') echo 'selected'; ?>>M</option>
          <option value="L" <?php if ($product['options'][0]['values'][0] === 'L') echo 'selected'; ?>>L</option>
          <option value="XL" <?php if ($product['options'][0]['values'][0] === 'XL') echo 'selected'; ?>>XL</option>
          <option value="2XL" <?php if ($product['options'][0]['values'][0] === '2XL') echo 'selected'; ?>>2XL</option>
          <option value="3XL" <?php if ($product['options'][0]['values'][0] === '3XL') echo 'selected'; ?>>3XL</option>
          <option value="4XL" <?php if ($product['options'][0]['values'][0] === '4XL') echo 'selected'; ?>>4XL</option>
         </select><br><br>


         <label for="color">Color:</label>
<input type="text" name="color" id="color" value="<?php echo $product['options'][1]['values'][0]; ?>"><br><br>

            
<label for="material">Material:</label>
<input type="text" name="material" id="material" value="<?php echo $product['options'][2]['values'][0]; ?>"><br><br>

            <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id; ?>"><br><br>

            <input type="submit" value="Edit Product"><br><br>
        </form>
    <?php } else { ?>
        <p>Product not found or Product ID not provided.</p>
    <?php } ?>
</body>
</html>
