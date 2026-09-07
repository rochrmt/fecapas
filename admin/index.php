<?php

declare(strict_types=1);

require_once __DIR__ . '/../inc/admin.php';

send_security_headers();
start_admin_session();

function redirect_to_admin(string $panel = ''): never
{
    $location = './';

    if ($panel !== '') {
        $location .= '#' . rawurlencode($panel);
    }

    header('Location: ' . $location);
    exit;
}

function field_value(array $source, string $key): string
{
    $value = $source[$key] ?? '';

    return is_scalar($value) ? (string) $value : '';
}

$error = '';
$notice = $_SESSION['admin_notice'] ?? '';
unset($_SESSION['admin_notice']);

try {
    ensure_storage_directories();
    initialize_default_admin();
} catch (Throwable $exception) {
    $error = $exception->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!verify_csrf_token(clean_text($_POST['csrf_token'] ?? '', 128))) {
            throw new RuntimeException('La session a expiré. Rechargez la page et réessayez.');
        }

        $requestAction = clean_text($_POST['request_action'] ?? '', 40);

        if ($requestAction === 'setup' && !is_admin_configured()) {
            $username = clean_text($_POST['username'] ?? '', 80);
            $password = clean_text($_POST['password'] ?? '', 500);
            $confirmation = clean_text($_POST['password_confirmation'] ?? '', 500);

            if ($password !== $confirmation) {
                throw new InvalidArgumentException('Les deux mots de passe ne correspondent pas.');
            }

            save_admin_credentials($username, $password);
            authenticate_admin($username, $password);
            $_SESSION['admin_notice'] = 'L’espace administrateur est prêt.';
            redirect_to_admin();
        }

        if ($requestAction === 'login' && is_admin_configured()) {
            $lockedUntil = (int) ($_SESSION['login_locked_until'] ?? 0);

            if ($lockedUntil > time()) {
                throw new RuntimeException('Trop de tentatives. Patientez quelques instants.');
            }

            if (!authenticate_admin(
                clean_text($_POST['username'] ?? '', 80),
                clean_text($_POST['password'] ?? '', 500),
            )) {
                $attempts = (int) ($_SESSION['login_attempts'] ?? 0) + 1;
                $_SESSION['login_attempts'] = $attempts;

                if ($attempts >= 5) {
                    $_SESSION['login_locked_until'] = time() + 60;
                    $_SESSION['login_attempts'] = 0;
                }

                throw new InvalidArgumentException('Identifiants incorrects.');
            }

            if (admin_requires_credential_change()) {
                $_SESSION['admin_notice'] = 'Changez vos identifiants initiaux avant de modifier le site.';
                redirect_to_admin('security');
            }

            redirect_to_admin();
        }

        if ($requestAction === 'logout') {
            logout_admin();
            header('Location: ./');
            exit;
        }

        if (!admin_is_authenticated()) {
            throw new RuntimeException('Vous devez vous reconnecter.');
        }

        if (
            admin_requires_credential_change()
            && !in_array($requestAction, ['change_credentials', 'logout'], true)
        ) {
            throw new RuntimeException('Changez vos identifiants initiaux avant de modifier le site.');
        }

        if ($requestAction === 'change_credentials') {
            $newUsername = clean_text($_POST['new_username'] ?? '', 80);
            $currentPassword = clean_text($_POST['current_password'] ?? '', 500);
            $newPassword = clean_text($_POST['new_password'] ?? '', 500);
            $confirmation = clean_text($_POST['new_password_confirmation'] ?? '', 500);

            if (!authenticate_admin(admin_username(), $currentPassword)) {
                throw new InvalidArgumentException('Le mot de passe actuel est incorrect.');
            }

            if ($newPassword !== '' && $newPassword !== $confirmation) {
                throw new InvalidArgumentException('Les deux nouveaux mots de passe ne correspondent pas.');
            }

            if (admin_requires_credential_change() && $newPassword === '') {
                throw new InvalidArgumentException('Choisissez un nouveau mot de passe pour sécuriser le compte.');
            }

            save_admin_credentials($newUsername, $newPassword === '' ? null : $newPassword);
            $_SESSION['admin_username'] = $newUsername;
            $_SESSION['admin_notice'] = 'Les identifiants ont été modifiés.';
            redirect_to_admin('security');
        }

        if ($requestAction === 'save') {
            $section = clean_text($_POST['section'] ?? '', 40);
            $content = load_content();

            switch ($section) {
                case 'identity':
                    $content = update_scalar_section(
                        $content,
                        'identity',
                        ['name', 'location', 'short_description', 'footer_text'],
                    );
                    $content['identity']['facebook_url'] = clean_url($_POST['facebook_url'] ?? '');
                    $content['identity']['logo'] = process_image_upload(
                        'logo',
                        field_value($content['identity'], 'logo'),
                    );
                    break;

                case 'hero':
                    $content = update_scalar_section(
                        $content,
                        'hero',
                        [
                            'eyebrow',
                            'title_before',
                            'title_accent',
                            'title_after',
                            'description',
                            'primary_button',
                            'secondary_button',
                            'stat_one_value',
                            'stat_one_label',
                            'stat_two_value',
                            'stat_two_label',
                            'image_alt',
                            'image_label',
                            'image_title',
                        ],
                    );
                    $content['hero']['image'] = process_image_upload(
                        'hero_image',
                        field_value($content['hero'], 'image'),
                    );
                    break;

                case 'mission':
                    $content = update_scalar_section(
                        $content,
                        'mission',
                        ['kicker', 'title', 'title_accent', 'lead', 'description', 'image_alt'],
                    );
                    $content['mission']['detail_content'] = clean_text($_POST['detail_content'] ?? '', 12000);
                    $content['mission']['image'] = process_image_upload(
                        'mission_image',
                        field_value($content['mission'], 'image'),
                    );
                    $content['mission']['gallery'] = process_gallery_uploads(
                        'mission_gallery',
                        $content['mission']['gallery'] ?? [],
                        $_POST['mission_gallery_remove'] ?? [],
                    );
                    break;

                case 'values':
                    $postedValues = $_POST['values'] ?? [];
                    $postedValues = is_array($postedValues) ? $postedValues : [];
                    foreach ($content['values'] as $index => $value) {
                        $posted = $postedValues[$index] ?? [];
                        $posted = is_array($posted) ? $posted : [];
                        $content['values'][$index]['title'] = clean_text($posted['title'] ?? '');
                        $content['values'][$index]['description'] = clean_text($posted['description'] ?? '');
                    }
                    break;

                case 'actions':
                    $content = update_scalar_section(
                        $content,
                        'actions_intro',
                        ['kicker', 'title', 'title_accent', 'description'],
                    );
                    $postedActions = $_POST['actions'] ?? [];
                    $postedActions = is_array($postedActions) ? $postedActions : [];
                    $requestedRemoval = filter_var($_POST['remove_item'] ?? null, FILTER_VALIDATE_INT);
                    $removeIndex = is_int($requestedRemoval) && count($content['actions']) > 1
                        ? $requestedRemoval
                        : null;
                    $updatedActions = [];
                    foreach ($content['actions'] as $index => $action) {
                        if ($index === $removeIndex) {
                            continue;
                        }

                        $posted = $postedActions[$index] ?? [];
                        $posted = is_array($posted) ? $posted : [];
                        $action['title'] = clean_text($posted['title'] ?? '');
                        $action['description'] = clean_text($posted['description'] ?? '');
                        $action['image_alt'] = clean_text($posted['image_alt'] ?? '');
                        $action['detail_content'] = clean_text(
                            $posted['detail_content'] ?? '',
                            12000,
                        );
                        $action['image'] = process_image_upload(
                            'action_image_' . $index,
                            field_value($action, 'image'),
                        );
                        $action['gallery'] = process_gallery_uploads(
                            'action_gallery_' . $index,
                            $action['gallery'] ?? [],
                            $posted['gallery_remove'] ?? [],
                        );
                        $updatedActions[] = $action;
                    }
                    $content['actions'] = $updatedActions;

                    if (isset($_POST['add_item'])) {
                        if (count($content['actions']) >= MAX_DYNAMIC_ITEMS) {
                            throw new InvalidArgumentException('Vous pouvez publier au maximum 20 actions.');
                        }

                        $content['actions'][] = new_action_content();
                    }
                    break;

                case 'quote':
                    $content = update_scalar_section(
                        $content,
                        'quote',
                        ['text_before', 'accent', 'text_after', 'subtitle'],
                    );
                    $content['quote']['image'] = process_image_upload(
                        'quote_image',
                        field_value($content['quote'], 'image'),
                    );
                    break;

                case 'news':
                    $content = update_scalar_section(
                        $content,
                        'news_intro',
                        ['kicker', 'title', 'title_accent'],
                    );
                    $postedNews = $_POST['news'] ?? [];
                    $postedNews = is_array($postedNews) ? $postedNews : [];
                    $requestedRemoval = filter_var($_POST['remove_item'] ?? null, FILTER_VALIDATE_INT);
                    $removeIndex = is_int($requestedRemoval) && count($content['news']) > 1
                        ? $requestedRemoval
                        : null;
                    $updatedNews = [];
                    foreach ($content['news'] as $index => $item) {
                        if ($index === $removeIndex) {
                            continue;
                        }

                        $posted = $postedNews[$index] ?? [];
                        $posted = is_array($posted) ? $posted : [];
                        $item['date'] = clean_text($posted['date'] ?? '', 20);
                        $item['date_label'] = clean_text($posted['date_label'] ?? '', 80);
                        $item['category'] = clean_text($posted['category'] ?? '', 80);
                        $item['title'] = clean_text($posted['title'] ?? '');
                        $item['summary'] = clean_text($posted['summary'] ?? '', 500);
                        $item['image_alt'] = clean_text($posted['image_alt'] ?? '');
                        $item['url'] = clean_url($posted['url'] ?? '');
                        $item['detail_content'] = clean_text(
                            $posted['detail_content'] ?? '',
                            12000,
                        );
                        $item['image'] = process_image_upload(
                            'news_image_' . $index,
                            field_value($item, 'image'),
                        );
                        $item['gallery'] = process_gallery_uploads(
                            'news_gallery_' . $index,
                            $item['gallery'] ?? [],
                            $posted['gallery_remove'] ?? [],
                        );
                        $updatedNews[] = $item;
                    }
                    $content['news'] = $updatedNews;

                    if (isset($_POST['add_item'])) {
                        if (count($content['news']) >= MAX_DYNAMIC_ITEMS) {
                            throw new InvalidArgumentException('Vous pouvez publier au maximum 20 actualités.');
                        }

                        $content['news'][] = new_news_content();
                    }
                    break;

                case 'join':
                    $content = update_scalar_section(
                        $content,
                        'join',
                        ['kicker', 'title', 'title_accent', 'description', 'button'],
                    );
                    break;

                default:
                    throw new InvalidArgumentException('Cette section n’existe pas.');
            }

            save_content($content);
            $_SESSION['admin_notice'] = 'Les modifications ont été publiées.';
            redirect_to_admin($section);
        }
    } catch (Throwable $exception) {
        $error = $exception->getMessage();
    }
}

$configured = is_admin_configured();
$authenticated = admin_is_authenticated();
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
?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex,nofollow" />
    <meta name="theme-color" content="#0b3024" />
    <link rel="icon" type="image/png" href="../assets/images/favicon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700&family=Playfair+Display:wght@600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="admin.css" />
    <title>Administration | FECAPAS-RCA</title>
  </head>
  <body class="<?= $authenticated ? 'dashboard-page' : 'auth-page' ?>">
    <?php if (!$configured || !$authenticated): ?>
      <main class="auth-shell">
        <section class="auth-brand">
          <a href="../" class="admin-brand">
            <img src="<?= e(admin_asset_url($identity['logo'])) ?>" alt="" />
            <span><strong>FECAPAS</strong><small>Administration</small></span>
          </a>
          <div>
            <p class="auth-kicker">Espace de gestion</p>
            <h1>Votre site,<br /><em>entre vos mains.</em></h1>
            <p>Modifiez les textes, les actualités et les images publiés sur le site.</p>
          </div>
          <span class="auth-copyright">FECAPAS-RCA</span>
        </section>

        <section class="auth-form-wrap">
          <div class="auth-form-card">
            <?php if ($error !== ''): ?>
              <div class="alert alert-error"><?= e($error) ?></div>
            <?php endif; ?>

            <?php if (!$configured): ?>
              <p class="form-kicker">Première connexion</p>
              <h2>Créer le compte administrateur</h2>
              <p class="form-intro">Choisissez un mot de passe fort pour sécuriser l’espace de gestion.</p>
              <form method="post">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
                <input type="hidden" name="request_action" value="setup" />
                <label>
                  Nom d’utilisateur
                  <input name="username" value="<?= e(INITIAL_ADMIN_USERNAME) ?>" required autocomplete="username" />
                </label>
                <label>
                  Mot de passe
                  <input type="password" name="password" minlength="10" required autocomplete="new-password" />
                </label>
                <label>
                  Confirmer le mot de passe
                  <input
                    type="password"
                    name="password_confirmation"
                    minlength="10"
                    required
                    autocomplete="new-password"
                  />
                </label>
                <button class="admin-button" type="submit">Créer et accéder au tableau de bord</button>
              </form>
            <?php else: ?>
              <p class="form-kicker">Bienvenue</p>
              <h2>Connexion administrateur</h2>
              <p class="form-intro">Connectez-vous pour mettre à jour le contenu du site.</p>
              <form method="post">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
                <input type="hidden" name="request_action" value="login" />
                <label>
                  Nom d’utilisateur
                  <input
                    name="username"
                    value="<?= e(admin_username()) ?>"
                    required
                    autocomplete="username"
                    autofocus
                  />
                </label>
                <label>
                  Mot de passe
                  <input type="password" name="password" required autocomplete="current-password" />
                </label>
                <button class="admin-button" type="submit">Se connecter</button>
              </form>
            <?php endif; ?>

            <a class="back-link" href="../">← Retourner sur le site</a>
          </div>
        </section>
      </main>
    <?php else: ?>
      <aside class="admin-sidebar">
        <a href="../" class="admin-brand">
          <img src="<?= e(admin_asset_url($identity['logo'])) ?>" alt="" />
          <span><strong>FECAPAS</strong><small>Administration</small></span>
        </a>
        <nav aria-label="Sections à modifier">
          <?php if (!admin_requires_credential_change()): ?>
            <a href="#identity">Identité</a>
            <a href="#hero">Accueil</a>
            <a href="#mission">Mission</a>
            <a href="#values">Valeurs</a>
            <a href="#actions">Actions</a>
            <a href="#quote">Message</a>
            <a href="#news">Actualités</a>
            <a href="#join">Appel à l’action</a>
          <?php endif; ?>
          <a href="#security">Sécurité</a>
        </nav>
        <form method="post" class="logout-form">
          <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
          <input type="hidden" name="request_action" value="logout" />
          <button type="submit">Se déconnecter</button>
        </form>
      </aside>

      <main class="admin-main">
        <header class="admin-topbar">
          <div>
            <p>Tableau de bord</p>
            <h1>Gérer le contenu</h1>
          </div>
          <a href="../" target="_blank">Voir le site <span>↗</span></a>
        </header>

        <?php if ($notice !== ''): ?>
          <div class="alert alert-success"><?= e((string) $notice) ?></div>
        <?php endif; ?>
        <?php if ($error !== ''): ?>
          <div class="alert alert-error"><?= e($error) ?></div>
        <?php endif; ?>

        <?php if (!admin_requires_credential_change()): ?>
          <section class="editor-card" id="identity">
          <div class="editor-heading">
            <span>01</span>
            <div><p>Paramètres généraux</p><h2>Identité du site</h2></div>
          </div>
          <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
            <input type="hidden" name="request_action" value="save" />
            <input type="hidden" name="section" value="identity" />
            <div class="field-grid">
              <label>Nom de l’organisation<input name="name" value="<?= e(field_value($identity, 'name')) ?>" required /></label>
              <label>Localisation<input name="location" value="<?= e(field_value($identity, 'location')) ?>" /></label>
              <label>Description courte<input name="short_description" value="<?= e(field_value($identity, 'short_description')) ?>" /></label>
              <label>Lien Facebook<input type="url" name="facebook_url" value="<?= e(field_value($identity, 'facebook_url')) ?>" /></label>
              <label class="field-full">Texte du pied de page<textarea name="footer_text" rows="2"><?= e(field_value($identity, 'footer_text')) ?></textarea></label>
              <label class="upload-field field-full">
                <span>Logo de l’organisation</span>
                <span class="upload-box">
                  <img src="<?= e(admin_asset_url(field_value($identity, 'logo'))) ?>" alt="Logo actuel" />
                  <span><strong>Choisir une nouvelle image</strong><small>JPG, PNG, WebP ou GIF — 8 Mo maximum</small></span>
                  <input type="file" name="logo" accept="image/jpeg,image/png,image/webp,image/gif" />
                </span>
              </label>
            </div>
            <button class="save-button" type="submit">Enregistrer l’identité</button>
          </form>
        </section>

        <section class="editor-card" id="hero">
          <div class="editor-heading">
            <span>02</span>
            <div><p>Premier écran</p><h2>Bloc d’accueil</h2></div>
          </div>
          <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
            <input type="hidden" name="request_action" value="save" />
            <input type="hidden" name="section" value="hero" />
            <div class="field-grid">
              <label class="field-full">Surtitre<input name="eyebrow" value="<?= e(field_value($hero, 'eyebrow')) ?>" /></label>
              <label>Début du titre<input name="title_before" value="<?= e(field_value($hero, 'title_before')) ?>" /></label>
              <label>Mot coloré<input name="title_accent" value="<?= e(field_value($hero, 'title_accent')) ?>" /></label>
              <label class="field-full">Suite du titre<input name="title_after" value="<?= e(field_value($hero, 'title_after')) ?>" /></label>
              <label class="field-full">Description<textarea name="description" rows="4"><?= e(field_value($hero, 'description')) ?></textarea></label>
              <label>Bouton principal<input name="primary_button" value="<?= e(field_value($hero, 'primary_button')) ?>" /></label>
              <label>Bouton Facebook<input name="secondary_button" value="<?= e(field_value($hero, 'secondary_button')) ?>" /></label>
              <label>Statistique 1<input name="stat_one_value" value="<?= e(field_value($hero, 'stat_one_value')) ?>" /></label>
              <label>Libellé statistique 1<input name="stat_one_label" value="<?= e(field_value($hero, 'stat_one_label')) ?>" /></label>
              <label>Statistique 2<input name="stat_two_value" value="<?= e(field_value($hero, 'stat_two_value')) ?>" /></label>
              <label>Libellé statistique 2<input name="stat_two_label" value="<?= e(field_value($hero, 'stat_two_label')) ?>" /></label>
              <label>Catégorie de l’image<input name="image_label" value="<?= e(field_value($hero, 'image_label')) ?>" /></label>
              <label>Titre sur l’image<input name="image_title" value="<?= e(field_value($hero, 'image_title')) ?>" /></label>
              <label class="field-full">Description accessible de l’image<input name="image_alt" value="<?= e(field_value($hero, 'image_alt')) ?>" /></label>
              <label class="upload-field field-full">
                <span>Image principale</span>
                <span class="upload-box upload-wide">
                  <img src="<?= e(admin_asset_url(field_value($hero, 'image'))) ?>" alt="Image actuelle" />
                  <span><strong>Remplacer l’image d’accueil</strong><small>Une image horizontale est recommandée</small></span>
                  <input type="file" name="hero_image" accept="image/jpeg,image/png,image/webp,image/gif" />
                </span>
              </label>
            </div>
            <button class="save-button" type="submit">Enregistrer l’accueil</button>
          </form>
        </section>

        <section class="editor-card" id="mission">
          <div class="editor-heading">
            <span>03</span>
            <div><p>Présentation</p><h2>Notre mission</h2></div>
          </div>
          <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
            <input type="hidden" name="request_action" value="save" />
            <input type="hidden" name="section" value="mission" />
            <div class="field-grid">
              <label class="field-full">Surtitre<input name="kicker" value="<?= e(field_value($mission, 'kicker')) ?>" /></label>
              <label>Titre<input name="title" value="<?= e(field_value($mission, 'title')) ?>" /></label>
              <label>Partie colorée<input name="title_accent" value="<?= e(field_value($mission, 'title_accent')) ?>" /></label>
              <label class="field-full">Phrase principale<textarea name="lead" rows="3"><?= e(field_value($mission, 'lead')) ?></textarea></label>
              <label class="field-full">Description<textarea name="description" rows="5"><?= e(field_value($mission, 'description')) ?></textarea></label>
              <label class="field-full">Contenu détaillé<textarea name="detail_content" rows="10"><?= e(field_value($mission, 'detail_content')) ?></textarea></label>
              <label class="field-full">Description accessible de l’image<input name="image_alt" value="<?= e(field_value($mission, 'image_alt')) ?>" /></label>
              <label class="upload-field field-full">
                <span>Image de couverture de la mission</span>
                <span class="upload-box upload-wide">
                  <img src="<?= e(admin_asset_url(field_value($mission, 'image'))) ?>" alt="Image actuelle" />
                  <span><strong>Choisir une nouvelle couverture</strong><small>JPG, PNG, WebP ou GIF</small></span>
                  <input type="file" name="mission_image" accept="image/jpeg,image/png,image/webp,image/gif" />
                </span>
              </label>
              <label class="upload-field field-full">
                <span>Ajouter des images à la galerie</span>
                <span class="multi-upload-box">
                  <strong>Sélectionner plusieurs images</strong>
                  <small>12 images maximum par galerie, 8 Mo par fichier</small>
                  <input type="file" name="mission_gallery[]" accept="image/jpeg,image/png,image/webp,image/gif" multiple />
                </span>
              </label>
              <?php $missionGallery = gallery_paths($mission['gallery'] ?? []); ?>
              <?php if ($missionGallery !== []): ?>
                <div class="gallery-manager field-full">
                  <?php foreach ($missionGallery as $galleryIndex => $galleryImage): ?>
                    <label class="gallery-manager-item">
                      <img src="<?= e(admin_asset_url($galleryImage)) ?>" alt="" />
                      <span>
                        <input type="checkbox" name="mission_gallery_remove[]" value="<?= $galleryIndex ?>" />
                        Retirer
                      </span>
                    </label>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
            <button class="save-button" type="submit">Enregistrer la mission</button>
          </form>
        </section>

        <section class="editor-card" id="values">
          <div class="editor-heading">
            <span>04</span>
            <div><p>Principes</p><h2>Nos valeurs</h2></div>
          </div>
          <form method="post">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
            <input type="hidden" name="request_action" value="save" />
            <input type="hidden" name="section" value="values" />
            <div class="repeat-grid">
              <?php foreach ($values as $index => $value): ?>
                <fieldset>
                  <legend>Valeur <?= $index + 1 ?></legend>
                  <label>Titre<input name="values[<?= $index ?>][title]" value="<?= e(field_value($value, 'title')) ?>" /></label>
                  <label>Description<textarea name="values[<?= $index ?>][description]" rows="3"><?= e(field_value($value, 'description')) ?></textarea></label>
                </fieldset>
              <?php endforeach; ?>
            </div>
            <button class="save-button" type="submit">Enregistrer les valeurs</button>
          </form>
        </section>

        <section class="editor-card" id="actions">
          <div class="editor-heading">
            <span>05</span>
            <div><p>Engagement</p><h2>Nos actions</h2></div>
          </div>
          <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
            <input type="hidden" name="request_action" value="save" />
            <input type="hidden" name="section" value="actions" />
            <div class="field-grid section-intro-fields">
              <label>Surtitre<input name="kicker" value="<?= e(field_value($actionsIntro, 'kicker')) ?>" /></label>
              <label>Titre<input name="title" value="<?= e(field_value($actionsIntro, 'title')) ?>" /></label>
              <label>Partie colorée<input name="title_accent" value="<?= e(field_value($actionsIntro, 'title_accent')) ?>" /></label>
              <label class="field-full">Introduction<textarea name="description" rows="3"><?= e(field_value($actionsIntro, 'description')) ?></textarea></label>
            </div>
            <div class="repeat-grid repeat-grid-two">
              <?php foreach ($actions as $index => $action): ?>
                <fieldset>
                  <legend>Action <?= $index + 1 ?></legend>
                  <?php if (count($actions) > 1): ?>
                    <button
                      class="remove-item-button"
                      type="submit"
                      name="remove_item"
                      value="<?= $index ?>"
                      formnovalidate
                    >Supprimer</button>
                  <?php endif; ?>
                  <label>Titre<input name="actions[<?= $index ?>][title]" value="<?= e(field_value($action, 'title')) ?>" /></label>
                  <label>Description<textarea name="actions[<?= $index ?>][description]" rows="4"><?= e(field_value($action, 'description')) ?></textarea></label>
                  <label>Contenu détaillé<textarea name="actions[<?= $index ?>][detail_content]" rows="8"><?= e(field_value($action, 'detail_content')) ?></textarea></label>
                  <label>Description accessible de l’image<input name="actions[<?= $index ?>][image_alt]" value="<?= e(field_value($action, 'image_alt')) ?>" /></label>
                  <label class="upload-field">
                    <span>Image de couverture</span>
                    <span class="upload-box upload-wide">
                      <img src="<?= e(admin_asset_url(field_value($action, 'image'))) ?>" alt="Image actuelle" />
                      <span><strong>Remplacer la couverture</strong><small>JPG, PNG, WebP ou GIF</small></span>
                      <input type="file" name="action_image_<?= $index ?>" accept="image/jpeg,image/png,image/webp,image/gif" />
                    </span>
                  </label>
                  <label class="upload-field">
                    <span>Ajouter des images à la galerie</span>
                    <span class="multi-upload-box">
                      <strong>Sélectionner plusieurs images</strong>
                      <small>12 images maximum</small>
                      <input type="file" name="action_gallery_<?= $index ?>[]" accept="image/jpeg,image/png,image/webp,image/gif" multiple />
                    </span>
                  </label>
                  <?php $actionGallery = gallery_paths($action['gallery'] ?? []); ?>
                  <?php if ($actionGallery !== []): ?>
                    <div class="gallery-manager">
                      <?php foreach ($actionGallery as $galleryIndex => $galleryImage): ?>
                        <label class="gallery-manager-item">
                          <img src="<?= e(admin_asset_url($galleryImage)) ?>" alt="" />
                          <span>
                            <input type="checkbox" name="actions[<?= $index ?>][gallery_remove][]" value="<?= $galleryIndex ?>" />
                            Retirer
                          </span>
                        </label>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                </fieldset>
              <?php endforeach; ?>
            </div>
            <div class="editor-form-actions">
              <button class="add-item-button" type="submit" name="add_item" value="1" formnovalidate>
                + Ajouter une action
              </button>
              <button class="save-button" type="submit">Enregistrer les actions</button>
            </div>
          </form>
        </section>

        <section class="editor-card" id="quote">
          <div class="editor-heading">
            <span>06</span>
            <div><p>Prise de parole</p><h2>Message central</h2></div>
          </div>
          <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
            <input type="hidden" name="request_action" value="save" />
            <input type="hidden" name="section" value="quote" />
            <div class="field-grid">
              <label>Début du message<input name="text_before" value="<?= e(field_value($quote, 'text_before')) ?>" /></label>
              <label>Mot coloré<input name="accent" value="<?= e(field_value($quote, 'accent')) ?>" /></label>
              <label class="field-full">Fin du message<input name="text_after" value="<?= e(field_value($quote, 'text_after')) ?>" /></label>
              <label class="field-full">Sous-titre<input name="subtitle" value="<?= e(field_value($quote, 'subtitle')) ?>" /></label>
              <label class="upload-field field-full">
                <span>Image de fond</span>
                <span class="upload-box upload-wide">
                  <img src="<?= e(admin_asset_url(field_value($quote, 'image'))) ?>" alt="Image actuelle" />
                  <span><strong>Remplacer l’image du message</strong><small>Une image verticale ou horizontale convient</small></span>
                  <input type="file" name="quote_image" accept="image/jpeg,image/png,image/webp,image/gif" />
                </span>
              </label>
            </div>
            <button class="save-button" type="submit">Enregistrer le message</button>
          </form>
        </section>

        <section class="editor-card" id="news">
          <div class="editor-heading">
            <span>07</span>
            <div><p>Publications</p><h2>Actualités</h2></div>
          </div>
          <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
            <input type="hidden" name="request_action" value="save" />
            <input type="hidden" name="section" value="news" />
            <div class="field-grid section-intro-fields">
              <label>Surtitre<input name="kicker" value="<?= e(field_value($newsIntro, 'kicker')) ?>" /></label>
              <label>Titre<input name="title" value="<?= e(field_value($newsIntro, 'title')) ?>" /></label>
              <label>Partie colorée<input name="title_accent" value="<?= e(field_value($newsIntro, 'title_accent')) ?>" /></label>
            </div>
            <div class="news-editors">
              <?php foreach ($news as $index => $item): ?>
                <fieldset>
                  <legend>Actualité <?= $index + 1 ?></legend>
                  <?php if (count($news) > 1): ?>
                    <button
                      class="remove-item-button"
                      type="submit"
                      name="remove_item"
                      value="<?= $index ?>"
                      formnovalidate
                    >Supprimer</button>
                  <?php endif; ?>
                  <div class="field-grid">
                    <label>Date technique<input type="date" name="news[<?= $index ?>][date]" value="<?= e(field_value($item, 'date')) ?>" /></label>
                    <label>Date affichée<input name="news[<?= $index ?>][date_label]" value="<?= e(field_value($item, 'date_label')) ?>" /></label>
                    <label>Catégorie<input name="news[<?= $index ?>][category]" value="<?= e(field_value($item, 'category')) ?>" /></label>
                    <label>Lien externe<input type="url" name="news[<?= $index ?>][url]" value="<?= e(field_value($item, 'url')) ?>" /></label>
                    <label class="field-full">Titre<textarea name="news[<?= $index ?>][title]" rows="2"><?= e(field_value($item, 'title')) ?></textarea></label>
                    <label class="field-full">Résumé<textarea name="news[<?= $index ?>][summary]" rows="3"><?= e(field_value($item, 'summary')) ?></textarea></label>
                    <label class="field-full">Description accessible de l’image<input name="news[<?= $index ?>][image_alt]" value="<?= e(field_value($item, 'image_alt')) ?>" /></label>
                    <label class="field-full">Contenu détaillé<textarea name="news[<?= $index ?>][detail_content]" rows="9"><?= e(field_value($item, 'detail_content')) ?></textarea></label>
                    <label class="upload-field field-full">
                      <span>Image de l’actualité</span>
                      <span class="upload-box upload-wide">
                        <img src="<?= e(admin_asset_url(field_value($item, 'image'))) ?>" alt="Image actuelle" />
                        <span><strong>Choisir une nouvelle image</strong><small>JPG, PNG, WebP ou GIF</small></span>
                        <input type="file" name="news_image_<?= $index ?>" accept="image/jpeg,image/png,image/webp,image/gif" />
                      </span>
                    </label>
                    <label class="upload-field field-full">
                      <span>Ajouter des images à la galerie</span>
                      <span class="multi-upload-box">
                        <strong>Sélectionner plusieurs images</strong>
                        <small>12 images maximum</small>
                        <input type="file" name="news_gallery_<?= $index ?>[]" accept="image/jpeg,image/png,image/webp,image/gif" multiple />
                      </span>
                    </label>
                    <?php $newsGallery = gallery_paths($item['gallery'] ?? []); ?>
                    <?php if ($newsGallery !== []): ?>
                      <div class="gallery-manager field-full">
                        <?php foreach ($newsGallery as $galleryIndex => $galleryImage): ?>
                          <label class="gallery-manager-item">
                            <img src="<?= e(admin_asset_url($galleryImage)) ?>" alt="" />
                            <span>
                              <input type="checkbox" name="news[<?= $index ?>][gallery_remove][]" value="<?= $galleryIndex ?>" />
                              Retirer
                            </span>
                          </label>
                        <?php endforeach; ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </fieldset>
              <?php endforeach; ?>
            </div>
            <div class="editor-form-actions">
              <button class="add-item-button" type="submit" name="add_item" value="1" formnovalidate>
                + Ajouter une actualité
              </button>
              <button class="save-button" type="submit">Enregistrer les actualités</button>
            </div>
          </form>
        </section>

          <section class="editor-card" id="join">
          <div class="editor-heading">
            <span>08</span>
            <div><p>Dernier bloc</p><h2>Appel à l’action</h2></div>
          </div>
          <form method="post">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
            <input type="hidden" name="request_action" value="save" />
            <input type="hidden" name="section" value="join" />
            <div class="field-grid">
              <label class="field-full">Surtitre<input name="kicker" value="<?= e(field_value($join, 'kicker')) ?>" /></label>
              <label>Titre<input name="title" value="<?= e(field_value($join, 'title')) ?>" /></label>
              <label>Partie colorée<input name="title_accent" value="<?= e(field_value($join, 'title_accent')) ?>" /></label>
              <label class="field-full">Description<textarea name="description" rows="4"><?= e(field_value($join, 'description')) ?></textarea></label>
              <label class="field-full">Texte du bouton<input name="button" value="<?= e(field_value($join, 'button')) ?>" /></label>
            </div>
            <button class="save-button" type="submit">Enregistrer l’appel à l’action</button>
          </form>
          </section>
        <?php endif; ?>

        <section class="editor-card" id="security">
          <div class="editor-heading">
            <span>09</span>
            <div><p>Compte</p><h2>Sécurité</h2></div>
          </div>
          <form method="post">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
            <input type="hidden" name="request_action" value="change_credentials" />
            <div class="field-grid">
              <label class="field-full">
                Nom d’utilisateur
                <input name="new_username" value="<?= e(admin_username()) ?>" required autocomplete="username" />
              </label>
              <label class="field-full">Mot de passe actuel<input type="password" name="current_password" required autocomplete="current-password" /></label>
              <label>
                Nouveau mot de passe
                <input
                  type="password"
                  name="new_password"
                  minlength="10"
                  <?= admin_requires_credential_change() ? 'required' : '' ?>
                  autocomplete="new-password"
                />
              </label>
              <label>
                Confirmer le mot de passe
                <input
                  type="password"
                  name="new_password_confirmation"
                  minlength="10"
                  <?= admin_requires_credential_change() ? 'required' : '' ?>
                  autocomplete="new-password"
                />
              </label>
            </div>
            <p class="security-help">
              <?= admin_requires_credential_change()
                ? 'Choisissez un nouveau mot de passe avant d’accéder aux outils de publication.'
                : 'Laissez les champs du nouveau mot de passe vides pour modifier uniquement le nom d’utilisateur.' ?>
            </p>
            <button class="save-button" type="submit">Modifier les identifiants</button>
          </form>
        </section>
      </main>
    <?php endif; ?>
  </body>
</html>
