<?php

declare(strict_types=1);

require_once __DIR__ . '/inc/content.php';

$content = load_content();
$identity = $content['identity'];
$type = is_string($_GET['type'] ?? null) ? $_GET['type'] : '';
$requestedId = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
$id = is_int($requestedId) ? $requestedId : null;
$item = [];
$sectionLabel = '';
$title = '';
$summary = '';
$image = '';
$imageAlt = '';
$detailContent = '';
$gallery = [];
$sourceUrl = '';
$date = '';
$dateLabel = '';
$relatedItems = [];
$backAnchor = '';
$found = false;

if ($type === 'mission') {
    $found = true;
    $item = $content['mission'];
    $sectionLabel = 'Notre mission';
    $title = trim(content_value($content, 'mission', 'title') . ' ' . content_value($content, 'mission', 'title_accent'));
    $summary = content_value($content, 'mission', 'lead');
    $image = content_value($content, 'mission', 'image');
    $imageAlt = content_value($content, 'mission', 'image_alt');
    $detailContent = content_value($content, 'mission', 'detail_content');
    $gallery = gallery_paths($item['gallery'] ?? []);
    $backAnchor = 'mission';
} elseif ($type === 'action' && $id !== null && isset($content['actions'][$id]) && is_array($content['actions'][$id])) {
    $found = true;
    $item = $content['actions'][$id];
    $sectionLabel = 'Nos actions';
    $title = is_string($item['title'] ?? null) ? $item['title'] : '';
    $summary = is_string($item['description'] ?? null) ? $item['description'] : '';
    $image = is_string($item['image'] ?? null) ? $item['image'] : '';
    $imageAlt = is_string($item['image_alt'] ?? null) ? $item['image_alt'] : '';
    $detailContent = is_string($item['detail_content'] ?? null) ? $item['detail_content'] : '';
    $gallery = gallery_paths($item['gallery'] ?? []);
    $relatedItems = $content['actions'];
    $backAnchor = 'actions';
} elseif ($type === 'news' && $id !== null && isset($content['news'][$id]) && is_array($content['news'][$id])) {
    $found = true;
    $item = $content['news'][$id];
    $sectionLabel = is_string($item['category'] ?? null) ? $item['category'] : 'Actualité';
    $title = is_string($item['title'] ?? null) ? $item['title'] : '';
    $summary = is_string($item['summary'] ?? null) ? $item['summary'] : '';
    $image = is_string($item['image'] ?? null) ? $item['image'] : '';
    $imageAlt = is_string($item['image_alt'] ?? null) ? $item['image_alt'] : '';
    $detailContent = is_string($item['detail_content'] ?? null) ? $item['detail_content'] : '';
    $gallery = gallery_paths($item['gallery'] ?? []);
    $sourceUrl = is_string($item['url'] ?? null) ? $item['url'] : '';
    $date = is_string($item['date'] ?? null) ? $item['date'] : '';
    $dateLabel = is_string($item['date_label'] ?? null) ? $item['date_label'] : '';
    $relatedItems = $content['news'];
    $backAnchor = 'actualites';
} else {
    http_response_code(404);
}

$paragraphs = preg_split('/\n{2,}/', trim($detailContent)) ?: [];

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');
?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?= e($found ? $summary : 'Page introuvable') ?>" />
    <meta name="theme-color" content="#123f2e" />
    <meta property="og:title" content="<?= e($found ? $title : 'Page introuvable') ?> | <?= e($identity['name']) ?>" />
    <?php if ($found): ?>
      <meta property="og:description" content="<?= e($summary) ?>" />
      <meta property="og:image" content="<?= e(public_asset_url($image)) ?>" />
    <?php endif; ?>
    <link rel="icon" type="image/png" href="assets/images/favicon.png" />
    <script>
      document.documentElement.classList.add("js");
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles.css" />
    <title><?= e($found ? $title : 'Page introuvable') ?> | <?= e($identity['name']) ?>-RCA</title>
  </head>
  <body class="detail-page">
    <a class="skip-link" href="#main-content">Aller au contenu</a>

    <header class="site-header scrolled" id="accueil">
      <div class="nav-wrap">
        <a class="brand" href="index.php" aria-label="FECAPAS-RCA — Accueil">
          <span class="brand-mark">
            <img src="<?= e(public_asset_url($identity['logo'])) ?>" alt="" />
          </span>
          <span>
            <strong><?= e($identity['name']) ?></strong>
            <small><?= e($identity['location']) ?></small>
          </span>
        </a>

        <button class="menu-toggle" aria-expanded="false" aria-controls="main-nav">
          <span></span><span></span><span></span>
          <span class="sr-only">Ouvrir le menu</span>
        </button>

        <nav class="main-nav" id="main-nav" aria-label="Navigation principale">
          <a href="index.php#mission">Notre mission</a>
          <a href="index.php#actions">Nos actions</a>
          <a href="index.php#actualites">Actualités</a>
          <a class="nav-cta" href="index.php#rejoindre">Nous rejoindre</a>
        </nav>
      </div>
    </header>

    <main id="main-content">
      <?php if (!$found): ?>
        <section class="detail-not-found">
          <div class="container">
            <p class="section-kicker">Erreur 404</p>
            <h1>Cette page n’existe pas.</h1>
            <a class="button button-primary" href="index.php">Retourner à l’accueil</a>
          </div>
        </section>
      <?php else: ?>
        <section class="detail-hero">
          <div class="container">
            <nav class="detail-breadcrumb" aria-label="Fil d’Ariane">
              <a href="index.php">Accueil</a>
              <span aria-hidden="true">/</span>
              <a href="index.php#<?= e($backAnchor) ?>"><?= e($sectionLabel) ?></a>
            </nav>

            <div class="detail-hero-grid">
              <div class="detail-hero-copy reveal">
                <p class="section-kicker"><?= e($sectionLabel) ?></p>
                <?php if ($dateLabel !== ''): ?>
                  <time datetime="<?= e($date) ?>"><?= e($dateLabel) ?></time>
                <?php endif; ?>
                <h1><?= e($title) ?></h1>
                <p><?= e($summary) ?></p>
              </div>
              <figure class="detail-cover reveal">
                <img src="<?= e(public_asset_url($image)) ?>" alt="<?= e($imageAlt) ?>" />
              </figure>
            </div>
          </div>
        </section>

        <section class="detail-content section">
          <div class="container detail-content-grid">
            <article class="detail-article reveal">
              <?php foreach ($paragraphs as $paragraph): ?>
                <?php if ($paragraph !== ''): ?>
                  <p><?= nl2br(e($paragraph)) ?></p>
                <?php endif; ?>
              <?php endforeach; ?>

              <?php if ($sourceUrl !== ''): ?>
                <a class="text-link detail-source" href="<?= e($sourceUrl) ?>" target="_blank" rel="noreferrer">
                  Consulter la source originale
                  <span aria-hidden="true">↗</span>
                </a>
              <?php endif; ?>
            </article>

            <aside class="detail-aside reveal">
              <span>FECAPAS-RCA</span>
              <strong>Femmes de courage,<br />bâtisseuses de paix.</strong>
              <a href="index.php#rejoindre">Rejoindre le mouvement →</a>
            </aside>
          </div>
        </section>

        <?php if ($gallery !== []): ?>
          <section class="detail-gallery section">
            <div class="container">
              <div class="detail-section-heading reveal">
                <p class="section-kicker">En images</p>
                <h2><?= $type === 'mission' ? 'Nos engagements' : 'Galerie de' ?> <em><?= $type === 'mission' ? 'en images.' : 'l’initiative.' ?></em></h2>
              </div>
              <div class="detail-gallery-grid">
                <?php foreach ($gallery as $galleryIndex => $galleryImage): ?>
                  <figure class="reveal">
                    <img
                      src="<?= e(public_asset_url($galleryImage)) ?>"
                      alt="<?= e($title) ?> — image <?= e((string) ($galleryIndex + 1)) ?>"
                      loading="lazy"
                    />
                  </figure>
                <?php endforeach; ?>
              </div>
            </div>
          </section>
        <?php endif; ?>

        <?php if ($relatedItems !== []): ?>
          <section class="detail-related section">
            <div class="container">
              <div class="detail-section-heading reveal">
                <p class="section-kicker">Continuer la découverte</p>
                <h2>D’autres <em><?= $type === 'news' ? 'actualités.' : 'actions.' ?></em></h2>
              </div>
              <div class="detail-related-grid">
                <?php foreach ($relatedItems as $relatedId => $related): ?>
                  <?php if ($relatedId !== $id && is_array($related)): ?>
                    <a class="detail-related-card reveal" href="detail.php?type=<?= e($type) ?>&amp;id=<?= $relatedId ?>">
                      <span><?= str_pad((string) ($relatedId + 1), 2, '0', STR_PAD_LEFT) ?></span>
                      <h3><?= e(is_string($related['title'] ?? null) ? $related['title'] : '') ?></h3>
                      <b>Découvrir →</b>
                    </a>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            </div>
          </section>
        <?php endif; ?>
      <?php endif; ?>
    </main>

    <footer class="site-footer">
      <div class="container footer-main">
        <div class="footer-brand">
          <a class="brand brand-light" href="index.php">
            <span class="brand-mark"><img src="<?= e(public_asset_url($identity['logo'])) ?>" alt="" /></span>
            <span>
              <strong><?= e($identity['name']) ?></strong>
              <small><?= e($identity['short_description']) ?></small>
            </span>
          </a>
          <p><?= e($identity['footer_text']) ?></p>
        </div>
        <div class="footer-links">
          <div>
            <h3>Navigation</h3>
            <a href="detail.php?type=mission">Notre mission</a>
            <a href="index.php#actions">Nos actions</a>
            <a href="index.php#actualites">Actualités</a>
          </div>
          <div>
            <h3>Nous suivre</h3>
            <a href="<?= e($identity['facebook_url']) ?>" target="_blank" rel="noreferrer">
              Facebook <span aria-hidden="true">↗</span>
            </a>
          </div>
        </div>
      </div>
      <div class="container footer-bottom">
        <p>© <span id="current-year"></span> <?= e($identity['name']) ?>-RCA. Tous droits réservés.</p>
        <p>Femmes • Paix • Sécurité</p>
      </div>
    </footer>

    <script src="script.js"></script>
  </body>
</html>
