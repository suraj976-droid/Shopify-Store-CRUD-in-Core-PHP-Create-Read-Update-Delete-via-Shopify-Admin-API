<?php
// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Define these variables before using them
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
    $product_name = $_POST['product_name'];
    $product_body = $_POST['product_body'];
    $product_price = $_POST['product_price'];
    $product_sku = $_POST['product_sku'];
    $l = $_POST['size'];
    $m = $_POST['color'];
    $n = $_POST['material'];
    $compare_at_price = isset($_POST['compare_at_price']) ? $_POST['compare_at_price'] : null;

    // Check if the product ID is provided
    if ($product_id === null) {
        echo 'Product ID not provided.';
        // You might want to handle this error case differently.
        exit();
    }

    // Set up the cURL request to fetch the product's details
    $shopify_store_url = 'https://mmfunctions.myshopify.com';
    $access_token = 'shpat_9fc430fb17569c1726bc97dded18';
    $ch = curl_init($shopify_store_url . '/admin/api/2023-07/products/' . $product_id . '.json');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'X-Shopify-Access-Token: ' . $access_token,
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the cURL request to fetch the product's details
    $result = curl_exec($ch);

    if ($result === false) {
        echo 'cURL Error: ' . curl_error($ch);
    } else {
        // Check if there were any errors reported by the Shopify API
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_status >= 400) {
            // Handle Shopify API errors
            $response = json_decode($result, true);
            echo 'Shopify API Errors: ' . json_encode($response['errors']);
        } else {
            // Parse the product details to get the correct variant ID
            $product_details = json_decode($result, true);
            $variant_id_to_update = null;

            if (isset($product_details['product']['variants'])) {
                foreach ($product_details['product']['variants'] as $variant) {
                    if ($variant['sku'] === $product_sku) {
                        $variant_id_to_update = $variant['id'];
                        break;
                    }
                }
            }

            if ($variant_id_to_update === null) {
                echo 'Variant with SKU ' . $product_sku . ' not found.';
            } else {
                // Construct the data for updating the product with the correct variant ID
                $data = [
                    'product' => [
                        'title' => $product_name,
                        'body_html' => $product_body,
                        'variants' => [
                            [
                                'id' => $variant_id_to_update, // Use the correct variant ID
                                'price' => $product_price,
                                'compare_at_price' => $compare_at_price,
                                'sku' => $product_sku,
                            ],
                        ],
                        'options' => [
                            [
                                'name' => 'Size',
                                'values' => [$l],
                            ],
                            [
                                'name' => 'Color',
                                'values' => [$m],
                            ],
                            [
                                'name' => 'Material',
                                'values' => [$n],
                            ],
                        ],
                    ],
                ];

                // Set up the cURL request to update the product
                $ch = curl_init($shopify_store_url . '/admin/api/2023-07/products/' . $product_id . '.json');
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'X-Shopify-Access-Token: ' . $access_token,
                ]);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                // Execute the cURL request to update the product
                $result = curl_exec($ch);

                if ($result === false) {
                    echo 'cURL Error: ' . curl_error($ch);
                } else {
                    // Check if there were any errors reported by the Shopify API
                    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    if ($http_status >= 400) {
                        // Handle Shopify API errors
                        $response = json_decode($result, true);
                        echo 'Shopify API Errors: ' . json_encode($response['errors']);
                    } else {
                        echo 'Product Updated Successfully!';
                        // Redirect to a different page or display a success message.
                        header('Location: view.php');
                        exit();
                    }
                }
            }
        }
    }

    curl_close($ch);
}
?>
