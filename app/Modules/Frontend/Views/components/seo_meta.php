<?php

/**
 * SEO Meta Tags Component
 * 
 * This component renders comprehensive SEO meta tags including:
 * - Primary meta tags (title, description, keywords, author, robots, canonical)
 * - Open Graph / Social Media meta tags
 * - Twitter Card meta tags
 * 
 * @param string $title Page title
 * @param string $description Meta description
 * @param string $keywords Meta keywords (comma-separated)
 * @param string $author Content author
 * @param string $canonical Canonical URL
 * @param string $og_title Open Graph title
 * @param string $og_description Open Graph description
 * @param string $og_image Open Graph image URL
 * @param string $og_url Open Graph URL
 * @param string $og_type Open Graph type (website, article, etc.)
 * @param string $og_locale Open Graph locale
 * @param string $og_site_name Open Graph site name
 * @param string $twitter_card Twitter card type
 * @param string $twitter_title Twitter title
 * @param string $twitter_description Twitter description
 * @param string $twitter_image Twitter image URL
 */

// Ensure all parameters have defaults
$title = $title ?? 'SOS Course and Training';
$description = $description ?? 'SOS Course and Training - Kursus Bahasa Asing Terbaik di Kampung Inggris Pare';
$keywords = $keywords ?? 'kursus bahasa, kampung inggris, les bahasa, mandarin, inggris, jepang, korea, jerman';
$author = $author ?? 'SOS Course and Training';
$canonical = $canonical ?? base_url();
$og_title = $og_title ?? $title;
$og_description = $og_description ?? $description;
$og_image = $og_image ?? '';
$og_url = $og_url ?? base_url();
$og_type = $og_type ?? 'website';
$og_locale = $og_locale ?? 'id_ID';
$og_site_name = $og_site_name ?? 'SOS Course and Training';
$twitter_card = $twitter_card ?? 'summary_large_image';
$twitter_title = $twitter_title ?? $title;
$twitter_description = $twitter_description ?? $description;
$twitter_image = $twitter_image ?? $og_image;
?>

<title><?= esc($title) ?></title>
<meta name="description" content="<?= esc($description) ?>">
<meta name="keywords" content="<?= esc($keywords) ?>">
<meta name="author" content="<?= esc($author) ?>">
<meta name="robots" content="index, follow">
<link rel="canonical" href="<?= esc($canonical) ?>">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="<?= esc($og_type) ?>">
<meta property="og:url" content="<?= esc($og_url) ?>">
<meta property="og:title" content="<?= esc($og_title) ?>">
<meta property="og:description" content="<?= esc($og_description) ?>">
<?php if (!empty($og_image)): ?>
    <meta property="og:image" content="<?= esc($og_image) ?>">
<?php endif; ?>
<meta property="og:locale" content="<?= esc($og_locale) ?>">
<meta property="og:site_name" content="<?= esc($og_site_name) ?>">

<!-- Twitter -->
<meta name="twitter:card" content="<?= esc($twitter_card) ?>">
<meta name="twitter:title" content="<?= esc($twitter_title) ?>">
<meta name="twitter:description" content="<?= esc($twitter_description) ?>">
<?php if (!empty($twitter_image)): ?>
    <meta name="twitter:image" content="<?= esc($twitter_image) ?>">
<?php endif; ?>