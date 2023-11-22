
<!DOCTYPE html>
<html>
<head>
 <title></title>

 <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

 <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
   <script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>

</head>
<body>

 <div class="container">
 <div class="col-lg-12">
 <br><br>
 <h1 class="text-warning text-center" > PRODUCTS </h1>
 <br>
 <table  id="tabledata" class=" table table-striped table-hover table-bordered">
 
 <tr class="bg-dark text-white text-center">
 <th> Productid </th>
 <th> Products </th>
 <th> Description </th>
 <th> handle </th>
 <th> updated_at </th>
 <th> Price </th>
 <th colspan = "2"> Action </th>

 </tr >

 <?php
// Shopify Store Credentials
$shopify_store_url = 'https://mmfunctions.myshopify.com';
$access_token = 'shpat_9e6fc30f9b17569c126bc97dde18';

// Create a cURL session to fetch products
$ch = curl_init($shopify_store_url . '/admin/api/2023-07/products.json');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-Shopify-Access-Token: ' . $access_token,
]);

$result = curl_exec($ch);
$products = json_decode($result, true);

if (isset($products['products'])) {
    $products = $products['products'];

    // Sort products by ID in descending order
    usort($products, function($a, $b) {
        return $b['id'] - $a['id'];
    });

    foreach ($products as $product) {
        $title = $product['title'];
        $body = $product['body_html'];
        $Productid = $product['id'];
        $handle = $product['handle'];
        $updated_at = $product['updated_at'];
        ?>
        <tr class="text-center">
            <td> <?php echo $Productid; ?> </td>
            <td> <?php echo $title; ?> </td>
            <td> <?php echo $body; ?> </td>
            <td> <?php echo $handle; ?> </td>
            <td> <?php echo $updated_at; ?> </td>
            <td> <?php echo $product['variants'][0]['price']; ?> </td>
            <td> <button class="btn-danger btn"> <a href="delete.php?id=<?php echo $Productid; ?>" class="text-white"> Delete </a> </button> </td>
            <td> <button class="btn-primary btn"> <a href="edits.php?id=<?php echo $Productid; ?>" class="text-white"> Edit </a> </button> </td>
        </tr>
        <?php
    }
    curl_close($ch);
}
?>

 
 </table>  

 </div>
 </div>
</body>
</html>
