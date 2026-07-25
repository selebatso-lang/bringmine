<?php
$productId = isset($_GET['p']) ? $_GET['p'] : null;

if (!$productId) {
    header('Location: /');
    exit;
}

// Fetch product from Supabase
$supabase_url = 'https://fieijyaodnlaziqezkum.supabase.co/rest/v1/products?id=eq.' . urlencode($productId) . '&select=data';
$supabase_key = 'sb_publishable_X5p_Eu3LpQ8oCccZ6IFQww_9BQuWgBi';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $supabase_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: ' . $supabase_key,
    'Authorization: Bearer ' . $supabase_key,
    'Content-Type: application/json'
]);
$response = curl_exec($ch);
curl_close($ch);

$products = json_decode($response, true);
$product = null;

if ($products && count($products) > 0 && isset($products[0]['data'])) {
    $product = $products[0]['data'];
}

if (!$product) {
    header('Location: /');
    exit;
}

$productName = htmlspecialchars($product['name'] ?? 'Product');
$productPrice = $product['price'] ?? 0;
$productDesc = htmlspecialchars(substr($product['description'] ?? '', 0, 200));
$productUnit = htmlspecialchars($product['unit'] ?? 'item');
$productImage = 'https://fieijyaodnlaziqezkum.supabase.co/functions/v1/product-image?p=' . urlencode($productId);
$siteUrl = 'https://bringmine.shop';
$productUrl = $siteUrl . '?p=' . urlencode($productId);

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta property="og:title" content="<?php echo $productName; ?> - P<?php echo $productPrice; ?> on BRINGMINE">
  <meta property="og:description" content="<?php echo $productDesc; ?> | P<?php echo $productPrice; ?> BWP per <?php echo $productUnit; ?>">
  <meta property="og:image" content="<?php echo $productImage; ?>">
  <meta property="og:url" content="<?php echo $productUrl; ?>">
  <meta property="og:type" content="product">
  <meta property="og:site_name" content="BRINGMINE.SHOP">
  <meta property="product:price:amount" content="<?php echo $productPrice; ?>">
  <meta property="product:price:currency" content="BWP">
  <meta name="twitter:card" content="summary_large_image">
  <title><?php echo $productName; ?> - P<?php echo $productPrice; ?> on BRINGMINE</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #fdf2f8, #fce7f3); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
    .card { background: white; border-radius: 20px; padding: 24px; max-width: 400px; width: 90%; box-shadow: 0 4px 20px rgba(236,72,153,0.15); text-align: center; }
    .card img { width: 100%; max-height: 250px; object-fit: contain; border-radius: 16px; margin-bottom: 16px; background: #f9fafb; }
    .card h2 { color: #1f2937; font-size: 18px; margin-bottom: 4px; }
    .card .price { font-size: 28px; font-weight: 800; color: #ec4899; margin: 8px 0; }
    .card .unit { font-size: 13px; color: #6b7280; }
    .card .desc { color: #4b5563; font-size: 13px; margin: 12px 0; line-height: 1.4; }
    .card .btn { display: inline-block; padding: 14px 40px; background: #ec4899; color: white; text-decoration: none; border-radius: 30px; font-size: 16px; font-weight: 600; margin-top: 8px; }
    .badge { display: inline-block; background: #10b981; color: white; padding: 4px 12px; border-radius: 15px; font-size: 11px; font-weight: 600; margin-bottom: 8px; }
  </style>
</head>
<body>
  <div class="card">
    <img src="<?php echo $productImage; ?>" alt="<?php echo $productName; ?>" onerror="this.style.display='none'">
    <div class="badge">BRINGMINE.SHOP</div>
    <h2><?php echo $productName; ?></h2>
    <div class="price">P<?php echo number_format($productPrice, 2); ?></div>
    <div class="unit">per <?php echo $productUnit; ?></div>
    <div class="desc"><?php echo $productDesc; ?></div>
    <a href="<?php echo $productUrl; ?>" class="btn">View on BRINGMINE</a>
  </div>
</body>
</html>
