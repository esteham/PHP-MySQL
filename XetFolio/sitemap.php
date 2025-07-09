<?php
$pages = [
    ['loc' => 'https://xetroot.com/', 'lastmod' => '2025-07-03', 'changefreq' => 'daily', 'priority' => '1.0'],
    ['loc' => 'https://xetroot.com/about', 'lastmod' => '2025-07-01', 'changefreq' => 'monthly', 'priority' => '0.8'],
    ['loc' => 'https://xetroot.com/contact', 'lastmod' => '2025-07-01', 'changefreq' => 'monthly', 'priority' => '0.7'],
    // Add more pages here
];

header('Content-Type: application/xml; charset=utf-8');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

foreach ($pages as $page) {
    echo "  <url>\n";
    echo "    <loc>{$page['loc']}</loc>\n";
    echo "    <lastmod>{$page['lastmod']}</lastmod>\n";
    echo "    <changefreq>{$page['changefreq']}</changefreq>\n";
    echo "    <priority>{$page['priority']}</priority>\n";
    echo "  </url>\n";
}

echo "</urlset>";
?>
