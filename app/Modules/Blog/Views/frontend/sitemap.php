<?php
header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?= $baseUrl ?>/blog</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    
    <?php foreach ($posts as $post): ?>
    <url>
        <loc><?= $baseUrl ?>/blog/<?= $post['slug'] ?></loc>
        <lastmod><?= date('c', strtotime($post['updated_at'])) ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority><?= $post['is_featured'] ? '0.9' : '0.7' ?></priority>
    </url>
    <?php endforeach; ?>
    
    <?php foreach ($categories as $category): ?>
    <url>
        <loc><?= $baseUrl ?>/blog/category/<?= $category['slug'] ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
    </url>
    <?php endforeach; ?>
</urlset>
