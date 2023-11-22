<?php
// $product_id='';
 $product_id = $_REQUEST['id'];
if (isset($_GET['id'])) {
    $shopify_store_url = 'https://mmlfunctions.myshopify.com';
    $access_token = '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';

    $delete_url = $shopify_store_url . '/admin/api/2023-07/products/' . $product_id . '.json';

    $ch = curl_init($delete_url);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'X-Shopify-Access-Token: ' . $access_token,
    ]);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($http_status == 200) {
        header('Location: view.php');
        echo 'Product with ID ' . $product_id . ' has been deleted.';
    } else {
        echo 'Error deleting the product: ' . $http_status;
    }

    curl_close($ch);
} 
?>
