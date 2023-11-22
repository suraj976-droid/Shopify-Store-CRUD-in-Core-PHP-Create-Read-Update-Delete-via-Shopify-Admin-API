<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $l= $_REQUEST['size'];
    $m= $_REQUEST['color'];
    $n= $_REQUEST['material'];
    $product_compare_at_price= $_REQUEST['product_compare_at_price'];
    // Check if the form is submitted via POST
    if (isset($_POST['product_name'])) {
        $product_name = $_POST['product_name'];
        $product_body = $_POST['product_body'];
        $product_images = $_POST['product_images'];
        $product_price = $_POST['product_price'];
        $product_variants = $_POST['product_variants'];
        $product_sku = $_POST['product_sku'];

        // Retrieve other product details from the form

        // Here, you'll use Shopify API to add the product to your store
        // An example using cURL

        $shopify_store_url = 'https://mmlfunctions.myshopify.com';
        $access_token = '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';

        // Example of creating a product using Shopify API
        $variants = [
            [
                'option1' => $l,
                'option2' => $m,
                'option3' => $n,
                'price' => $product_price,
                'compare_at_price'=> $product_compare_at_price,
                'sku' => $product_sku,
            ],
            // Add more variants as needed
        ];

        $data = [
            'product' => [
                'title' => $product_name,
                'body_html' => $product_body,
                'variants' => $variants,
                'options' => [
                    [
                        'name' => 'Size',
                        'values' => $l, // Take the user input for Size from the form
                    ],
                    [
                        'name' => 'Color',
                        'values' => $m, // Take the user input for Color from the form
                    ],
                    [
                        'name' => 'Material',
                        'values' => $n, // Take the user input for Material from the form
                    ],
                ],

                'published' => true,
                // Add other product details as required by Shopify's API
            ]
        ];
        

        $ch = curl_init($shopify_store_url . '/admin/api/2023-07/products.json');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-Shopify-Access-Token: ' . $access_token,
        ]);

        $result = curl_exec($ch);

        if ($result === false) {
            echo 'Error: ' . curl_error($ch);
        } else {
            // Product added successfully, redirect to a different page
            header('Location: view.php');
            exit(); // Ensure no further processing in this script
        }
        curl_close($ch);

    } else {
        echo 'Product name is missing.';
    }
}
?>
