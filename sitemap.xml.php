<?php
/**
 * Dynamic Sitemap Generator
 * Access via: /sitemap.xml.php or create a cron job to generate static sitemap.xml
 */

require_once 'includes/config.php';
require_once 'includes/database.php';

header('Content-Type: application/xml; charset=utf-8');

$base_url = 'https://www.dorsh-palestine.com'; // Update with your domain

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// Homepage
echo "  <url>\n";
echo "    <loc>{$base_url}/</loc>\n";
echo "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
echo "    <changefreq>daily</changefreq>\n";
echo "    <priority>1.0</priority>\n";
echo "  </url>\n";

// Static pages
$static_pages = [
    ['url' => '/shop.php', 'changefreq' => 'daily', 'priority' => '0.9'],
    ['url' => '/about.php', 'changefreq' => 'monthly', 'priority' => '0.7'],
    ['url' => '/contact.php', 'changefreq' => 'monthly', 'priority' => '0.6'],
];

foreach ($static_pages as $page) {
    echo "  <url>\n";
    echo "    <loc>{$base_url}{$page['url']}</loc>\n";
    echo "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
    echo "    <changefreq>{$page['changefreq']}</changefreq>\n";
    echo "    <priority>{$page['priority']}</priority>\n";
    echo "  </url>\n";
}

// Products (active only)
$products = $db->query(
    "SELECT id, updated_at FROM products WHERE status = 'active' ORDER BY id DESC"
)->fetchAll();

foreach ($products as $product) {
    echo "  <url>\n";
    echo "    <loc>{$base_url}/product.php?id={$product['id']}</loc>\n";
    echo "    <lastmod>" . date('Y-m-d', strtotime($product['updated_at'])) . "</lastmod>\n";
    echo "    <changefreq>weekly</changefreq>\n";
    echo "    <priority>0.8</priority>\n";
    echo "  </url>\n";
}

// Categories
$categories = $db->query(
    "SELECT id, name_en FROM categories WHERE status = 'active'"
)->fetchAll();

foreach ($categories as $category) {
    $slug = strtolower(str_replace(' ', '-', $category['name_en']));
    echo "  <url>\n";
    echo "    <loc>{$base_url}/shop.php?category={$slug}</loc>\n";
    echo "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
    echo "    <changefreq>weekly</changefreq>\n";
    echo "    <priority>0.7</priority>\n";
    echo "  </url>\n";
}

echo '</urlset>';
