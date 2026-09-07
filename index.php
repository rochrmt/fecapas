<?php

declare(strict_types=1);

require_once __DIR__ . '/inc/content.php';

$content = load_content();
$identity = $content['identity'];
$hero = $content['hero'];
$mission = $content['mission'];
$values = $content['values'];
$actionsIntro = $content['actions_intro'];
$actions = $content['actions'];
$quote = $content['quote'];
$newsIntro = $content['news_intro'];
$news = $content['news'];
$join = $content['join'];

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');
?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="<?= e($hero['description']) ?>"
    />
    <meta name="theme-color" content="#123f2e" />
    <meta property="og:title" content="<?= e($identity['name']) ?> — <?= e($hero['title_after']) ?>" />
    <meta
      property="og:description"
      content="<?= e($hero['description']) ?>"
    />
    <meta property="og:image" content="<?= e(public_asset_url($hero['image'])) ?>" />
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
    <title><?= e($identity['name']) ?>-RCA | <?= e($hero['title_after']) ?></title>
  </head>
  <body>
    <a class="skip-link" href="#main-content">Aller au contenu</a>

    <header class="site-header" id="accueil">
      <div class="nav-wrap">
        <a class="brand" href="#accueil" aria-label="FECAPAS-RCA — Accueil">
          <span class="brand-mark">
            <img src="<?= e(public_asset_url($identity['logo'])) ?>" alt="" />
          </span>
          <span>
            <strong><?= e($identity['name']) ?></strong>
            <small><?= e($identity['location']) ?></small>
          </span>
        </a>

        <button class="menu-toggle" aria-expanded="false" aria-controls="main-nav">
          <span></span>
          <span></span>
          <span></span>
          <span class="sr-only">Ouvrir le menu</span>
        </button>

        <nav class="main-nav" id="main-nav" aria-label="Navigation principale">
          <a href="#mission">Notre mission</a>
          <a href="#actions">Nos actions</a>
          <a href="#actualites">Actualités</a>
          <a class="nav-cta" href="#rejoindre">Nous rejoindre</a>
        </nav>
      </div>
    </header>

    <main id="main-content">
      <section class="hero">
        <div class="hero-glow hero-glow-one"></div>
        <div class="hero-glow hero-glow-two"></div>
        <div class="hero-grid container">
          <div class="hero-content">
            <div class="eyebrow reveal">
              <span class="eyebrow-dot"></span>
              <?= e($hero['eyebrow']) ?>
            </div>
            <h1 class="reveal">
              <?= e($hero['title_before']) ?> <em><?= e($hero['title_accent']) ?></em>,<br />
              <?= e($hero['title_after']) ?>
            </h1>
            <p class="hero-copy reveal">
              <?= e($hero['description']) ?>
            </p>
            <div class="hero-actions reveal">
              <a class="button button-primary" href="detail.php?type=mission">
                <?= e($hero['primary_button']) ?>
                <svg aria-hidden="true" viewBox="0 0 24 24">
                  <path d="M5 12h14M13 6l6 6-6 6" />
                </svg>
              </a>
              <a
                class="button button-link"
                href="<?= e($identity['facebook_url']) ?>"
                target="_blank"
                rel="noreferrer"
              >
                <?= e($hero['secondary_button']) ?>
                <span aria-hidden="true">↗</span>
              </a>
            </div>
            <div class="hero-proof reveal">
              <div class="proof-item">
                <strong><?= e($hero['stat_one_value']) ?></strong>
                <span><?= e($hero['stat_one_label']) ?></span>
              </div>
              <span class="proof-divider"></span>
              <div class="proof-item">
                <strong><?= e($hero['stat_two_value']) ?></strong>
                <span><?= e($hero['stat_two_label']) ?></span>
              </div>
            </div>
          </div>

          <div class="hero-visual reveal">
            <div class="hero-photo-frame">
              <img
                src="<?= e(public_asset_url($hero['image'])) ?>"
                alt="<?= e($hero['image_alt']) ?>"
              />
              <div class="photo-shade"></div>
              <div class="photo-caption">
                <span><?= e($hero['image_label']) ?></span>
                <strong><?= e($hero['image_title']) ?></strong>
              </div>
            </div>
            <div class="logo-orbit" aria-hidden="true">
              <span class="orbit-line"></span>
              <div class="logo-card">
                <img src="<?= e(public_asset_url($identity['logo'])) ?>" alt="" />
              </div>
            </div>
            <div class="hero-badge">
              <svg aria-hidden="true" viewBox="0 0 24 24">
                <path d="M12 3v18M3 12h18" />
                <circle cx="12" cy="12" r="8" />
              </svg>
              <span>En action<br />pour la paix</span>
            </div>
          </div>
        </div>
        <div class="scroll-note" aria-hidden="true">
          <span></span>
          Découvrir
        </div>
      </section>

      <section class="manifesto section" id="mission">
        <div class="container">
          <div class="section-heading reveal">
            <p class="section-kicker"><?= e($mission['kicker']) ?></p>
            <h2><?= e($mission['title']) ?><br /><em><?= e($mission['title_accent']) ?></em></h2>
          </div>

          <div class="manifesto-grid">
            <div class="manifesto-copy reveal">
              <p class="lead">
                <?= e($mission['lead']) ?>
              </p>
              <p>
                <?= e($mission['description']) ?>
              </p>
              <a class="text-link" href="detail.php?type=mission">
                Découvrir notre mission
                <span aria-hidden="true">→</span>
              </a>
            </div>

            <div class="values-stack">
              <article class="value-card reveal">
                <span class="value-number">01</span>
                <div>
                  <h3><?= e($values[0]['title']) ?></h3>
                  <p><?= e($values[0]['description']) ?></p>
                </div>
                <svg aria-hidden="true" viewBox="0 0 24 24">
                  <path d="M4 5h16v11H8l-4 4V5Z" />
                  <path d="M8 9h8M8 12h5" />
                </svg>
              </article>
              <article class="value-card reveal">
                <span class="value-number">02</span>
                <div>
                  <h3><?= e($values[1]['title']) ?></h3>
                  <p><?= e($values[1]['description']) ?></p>
                </div>
                <svg aria-hidden="true" viewBox="0 0 24 24">
                  <circle cx="12" cy="8" r="4" />
                  <path d="M5 21c.7-4 3.1-6 7-6s6.3 2 7 6" />
                </svg>
              </article>
              <article class="value-card reveal">
                <span class="value-number">03</span>
                <div>
                  <h3><?= e($values[2]['title']) ?></h3>
                  <p><?= e($values[2]['description']) ?></p>
                </div>
                <svg aria-hidden="true" viewBox="0 0 24 24">
                  <path d="M12 21s7-5.5 7-12A7 7 0 0 0 5 9c0 6.5 7 12 7 12Z" />
                  <circle cx="12" cy="9" r="2.5" />
                </svg>
              </article>
            </div>
          </div>
        </div>
      </section>

      <section class="impact-band" aria-label="Notre engagement">
        <div class="impact-track">
          <span>Femmes engagées</span><i></i>
          <span>Communautés unies</span><i></i>
          <span>Dialogue renforcé</span><i></i>
          <span>Paix durable</span><i></i>
          <span aria-hidden="true">Femmes engagées</span><i aria-hidden="true"></i>
          <span aria-hidden="true">Communautés unies</span><i aria-hidden="true"></i>
        </div>
      </section>

      <section class="actions section" id="actions">
        <div class="container">
          <div class="actions-head reveal">
            <div>
              <p class="section-kicker"><?= e($actionsIntro['kicker']) ?></p>
              <h2><?= e($actionsIntro['title']) ?><br /><em><?= e($actionsIntro['title_accent']) ?></em></h2>
            </div>
            <p>
              <?= e($actionsIntro['description']) ?>
            </p>
          </div>

          <div class="action-grid">
            <a class="action-card action-card-featured reveal" href="detail.php?type=action&amp;id=0">
              <span class="card-index">01</span>
              <div class="action-icon">
                <svg aria-hidden="true" viewBox="0 0 24 24">
                  <path d="M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z" />
                  <path d="m8.5 12 2.2 2.2 4.8-5" />
                </svg>
              </div>
              <h3><?= e($actions[0]['title']) ?></h3>
              <p>
                <?= e($actions[0]['description']) ?>
              </p>
              <span class="action-link">Découvrir <b aria-hidden="true">→</b></span>
              <div class="action-decoration"></div>
            </a>

            <a class="action-card reveal" href="detail.php?type=action&amp;id=1">
              <span class="card-index">02</span>
              <div class="action-icon">
                <svg aria-hidden="true" viewBox="0 0 24 24">
                  <path d="M4 20v-2a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v2" />
                  <circle cx="12" cy="7" r="4" />
                </svg>
              </div>
              <h3><?= e($actions[1]['title']) ?></h3>
              <p>
                <?= e($actions[1]['description']) ?>
              </p>
              <span class="action-link">Découvrir <b aria-hidden="true">→</b></span>
            </a>

            <a class="action-card reveal" href="detail.php?type=action&amp;id=2">
              <span class="card-index">03</span>
              <div class="action-icon">
                <svg aria-hidden="true" viewBox="0 0 24 24">
                  <path d="M3 11.5 12 4l9 7.5" />
                  <path d="M5 10v10h14V10M9 20v-6h6v6" />
                </svg>
              </div>
              <h3><?= e($actions[2]['title']) ?></h3>
              <p>
                <?= e($actions[2]['description']) ?>
              </p>
              <span class="action-link">Découvrir <b aria-hidden="true">→</b></span>
            </a>

            <a class="action-card reveal" href="detail.php?type=action&amp;id=3">
              <span class="card-index">04</span>
              <div class="action-icon">
                <svg aria-hidden="true" viewBox="0 0 24 24">
                  <path d="M8 12h8M12 8v8" />
                  <circle cx="12" cy="12" r="9" />
                </svg>
              </div>
              <h3><?= e($actions[3]['title']) ?></h3>
              <p>
                <?= e($actions[3]['description']) ?>
              </p>
              <span class="action-link">Découvrir <b aria-hidden="true">→</b></span>
            </a>
          </div>
        </div>
      </section>

      <section class="quote-section">
        <div class="quote-photo" aria-hidden="true">
          <img src="<?= e(public_asset_url($quote['image'])) ?>" alt="" />
        </div>
        <div class="quote-overlay"></div>
        <div class="quote-content container reveal">
          <img class="quote-logo" src="<?= e(public_asset_url($identity['logo'])) ?>" alt="" />
          <blockquote>
            <?= e($quote['text_before']) ?><br />
            <em><?= e($quote['accent']) ?></em> <?= e($quote['text_after']) ?>
          </blockquote>
          <p><?= e($quote['subtitle']) ?></p>
        </div>
      </section>

      <section class="news section" id="actualites">
        <div class="container">
          <div class="news-head reveal">
            <div>
              <p class="section-kicker"><?= e($newsIntro['kicker']) ?></p>
              <h2><?= e($newsIntro['title']) ?> <em><?= e($newsIntro['title_accent']) ?></em></h2>
            </div>
            <a
              class="text-link"
              href="<?= e($identity['facebook_url']) ?>"
              target="_blank"
              rel="noreferrer"
            >
              Voir toutes les actualités
              <span aria-hidden="true">↗</span>
            </a>
          </div>

          <div class="news-grid">
            <a
              class="news-card news-card-large reveal"
              href="detail.php?type=news&amp;id=0"
            >
              <div class="news-image">
                <img
                  src="<?= e(public_asset_url($news[0]['image'])) ?>"
                  alt="<?= e($news[0]['image_alt']) ?>"
                />
                <span class="news-category"><?= e($news[0]['category']) ?></span>
              </div>
              <div class="news-body">
                <time datetime="<?= e($news[0]['date']) ?>"><?= e($news[0]['date_label']) ?></time>
                <h3><?= e($news[0]['title']) ?></h3>
                <span class="read-more">Découvrir <b aria-hidden="true">→</b></span>
              </div>
            </a>

            <div class="news-side">
              <a
                class="news-card news-card-horizontal reveal"
                href="detail.php?type=news&amp;id=1"
              >
                <div class="news-thumb">
                  <img
                    src="<?= e(public_asset_url($news[1]['image'])) ?>"
                    alt="<?= e($news[1]['image_alt']) ?>"
                  />
                </div>
                <div class="news-body">
                  <time datetime="<?= e($news[1]['date']) ?>"><?= e($news[1]['date_label']) ?></time>
                  <h3><?= e($news[1]['title']) ?></h3>
                  <span class="read-more">Découvrir <b aria-hidden="true">→</b></span>
                </div>
              </a>

              <a
                class="news-card news-card-horizontal reveal"
                href="detail.php?type=news&amp;id=2"
              >
                <div class="news-thumb">
                  <img
                    src="<?= e(public_asset_url($news[2]['image'])) ?>"
                    alt="<?= e($news[2]['image_alt']) ?>"
                  />
                </div>
                <div class="news-body">
                  <time datetime="<?= e($news[2]['date']) ?>"><?= e($news[2]['date_label']) ?></time>
                  <h3><?= e($news[2]['title']) ?></h3>
                  <span class="read-more">Découvrir <b aria-hidden="true">→</b></span>
                </div>
              </a>
            </div>
          </div>
        </div>
      </section>

      <section class="join section" id="rejoindre">
        <div class="container join-inner reveal">
          <div class="join-symbol" aria-hidden="true">
            <svg viewBox="0 0 100 100">
              <circle cx="50" cy="50" r="47" />
              <circle cx="50" cy="50" r="34" />
              <path d="M50 17v66M17 50h66" />
            </svg>
          </div>
          <div class="join-copy">
            <p class="section-kicker"><?= e($join['kicker']) ?></p>
            <h2><?= e($join['title']) ?><br /><em><?= e($join['title_accent']) ?></em></h2>
            <p>
              <?= e($join['description']) ?>
            </p>
            <a
              class="button button-light"
              href="<?= e($identity['facebook_url']) ?>"
              target="_blank"
              rel="noreferrer"
            >
              <?= e($join['button']) ?>
              <svg aria-hidden="true" viewBox="0 0 24 24">
                <path d="M5 12h14M13 6l6 6-6 6" />
              </svg>
            </a>
          </div>
        </div>
      </section>
    </main>

    <footer class="site-footer">
      <div class="container footer-main">
        <div class="footer-brand">
          <a class="brand brand-light" href="#accueil">
            <span class="brand-mark">
              <img src="<?= e(public_asset_url($identity['logo'])) ?>" alt="" />
            </span>
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
            <a href="#mission">Notre mission</a>
            <a href="#actions">Nos actions</a>
            <a href="#actualites">Actualités</a>
          </div>
          <div>
            <h3>Nous suivre</h3>
            <a
              href="<?= e($identity['facebook_url']) ?>"
              target="_blank"
              rel="noreferrer"
            >
              Facebook <span aria-hidden="true">↗</span>
            </a>
            <a href="admin/">Administration</a>
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
