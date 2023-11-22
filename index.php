
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>

<body>


    <form method="post" action="product.php">
        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" id="product_name"><br><br>
        
        <label for="product_body">Product Description:</label>
        <textarea name="product_body" id="product_body"></textarea><br><br>
        
        <label for="product_price">Price:</label>
        <input type="text" name="product_price" id="product_price"><br><br>
        <label for="product_compare_at_price">Compare:</label>
        <input type="text" name="product_compare_at_price" id="product_compare_at_price"><br><br>
        
        <label for="product_sku">SKU:</label>
        <input type="text" name="product_sku" id="product_sku"><br><br>
        
        <label for="product_variants">Variants:</label><br>
       
      
        <label for="size">size:</label>
        <select name="size">
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
            <option value="2XL">2XL</option>
            <option value="3XL">3XL</option>
            <option value="4XL">4XL</option>
        </select><br><br> 

        <label for="color">Color:</label>
        <input type="text" name="color" id="color"><br><br>
        
        
        <label for="material">Material:</label>
        <input type="text" name="material" id="material"><br><br>
        <input type="submit" value="Add Product"><br><br>

    </form>

</body>
</html>
