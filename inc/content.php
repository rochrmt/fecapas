<?php

declare(strict_types=1);

const CONTENT_FILE = __DIR__ . '/../data/content.json';
const AUTH_FILE = __DIR__ . '/../data/auth.json';
const UPLOAD_DIRECTORY = __DIR__ . '/../uploads';

function default_content(): array
{
    return [
        'identity' => [
            'name' => 'FECAPAS',
            'location' => 'République centrafricaine',
            'short_description' => 'Femmes courageuses en action',
            'footer_text' => 'Pour la paix et la sécurité en République centrafricaine.',
            'facebook_url' => 'https://www.facebook.com/profile.php?id=61564006413825',
            'logo' => 'assets/images/logo-fecapas.webp',
        ],
        'hero' => [
            'eyebrow' => 'Paix • Sécurité • Leadership féminin',
            'title_before' => 'Femmes de',
            'title_accent' => 'courage',
            'title_after' => 'bâtisseuses de paix.',
            'description' => 'FECAPAS mobilise les femmes centrafricaines pour faire grandir une culture de paix, de sécurité et de solidarité au cœur de nos communautés.',
            'primary_button' => 'Découvrir notre mission',
            'secondary_button' => 'Suivre nos actions',
            'stat_one_value' => '02',
            'stat_one_label' => 'années d’engagement',
            'stat_two_value' => 'RCA',
            'stat_two_label' => 'au cœur de notre action',
            'image' => 'assets/images/message-compassion.webp',
            'image_alt' => 'La présidente de FECAPAS lors d’une rencontre publique',
            'image_label' => 'Leadership',
            'image_title' => 'Porter la voix des femmes',
        ],
        'mission' => [
            'kicker' => 'Notre raison d’être',
            'title' => 'Transformer le courage',
            'title_accent' => 'en impact collectif.',
            'lead' => 'Nous croyons que chaque femme peut devenir une force de dialogue, de protection et de réconciliation.',
            'description' => 'L’Association des Femmes Courageuses en Action pour la Paix et la Sécurité crée des espaces d’écoute, de mobilisation et d’engagement afin que les femmes prennent pleinement part à la construction d’une République centrafricaine plus apaisée.',
        ],
        'values' => [
            [
                'title' => 'La paix par le dialogue',
                'description' => 'Rassembler, écouter et créer des passerelles durables.',
            ],
            [
                'title' => 'La force des femmes',
                'description' => 'Faire émerger des voix, des talents et des initiatives.',
            ],
            [
                'title' => 'L’action de proximité',
                'description' => 'Agir avec les communautés, au plus près des réalités.',
            ],
        ],
        'actions_intro' => [
            'kicker' => 'Nos champs d’action',
            'title' => 'Agir aujourd’hui.',
            'title_accent' => 'Inspirer demain.',
            'description' => 'Des actions ancrées dans la réalité, portées par la conviction que la paix se construit ensemble.',
        ],
        'actions' => [
            [
                'title' => 'Sensibilisation à la paix',
                'description' => 'Promouvoir une culture de non-violence, de responsabilité et de cohésion au sein des communautés.',
            ],
            [
                'title' => 'Leadership féminin',
                'description' => 'Encourager les femmes à prendre la parole et à participer aux décisions qui façonnent leur avenir.',
            ],
            [
                'title' => 'Mobilisation communautaire',
                'description' => 'Fédérer citoyens, responsables et partenaires autour d’initiatives locales concrètes.',
            ],
            [
                'title' => 'Solidarité & compassion',
                'description' => 'Être présente auprès des populations et porter des messages d’unité face aux épreuves.',
            ],
        ],
        'quote' => [
            'text_before' => '« Pour la paix par les femmes, avec',
            'accent' => 'courage',
            'text_after' => 'et détermination. »',
            'subtitle' => 'Ensemble, bâtissons une nation de paix et de sécurité.',
            'image' => 'assets/images/intercession-paix.webp',
        ],
        'news_intro' => [
            'kicker' => 'Sur le terrain',
            'title' => 'Nos temps',
            'title_accent' => 'forts.',
        ],
        'news' => [
            [
                'date' => '2026-08-10',
                'date_label' => '10 août 2026',
                'category' => 'Vie de l’association',
                'title' => 'Deux années de courage, de foi et d’actions pour la paix',
                'image' => 'assets/images/anniversaire-fecapas.webp',
                'image_alt' => 'Affiche du deuxième anniversaire de FECAPAS',
                'url' => 'https://www.facebook.com/photo/?fbid=122209644860466880&set=pb.61564006413825.-2207520000',
            ],
            [
                'date' => '2026-08-05',
                'date_label' => '05 août 2026',
                'category' => 'Événement',
                'title' => 'Une journée nationale d’intercession pour la paix',
                'image' => 'assets/images/intercession-paix.webp',
                'image_alt' => 'Affiche de la journée nationale d’intercession pour la paix',
                'url' => 'https://www.facebook.com/photo/?fbid=122209015640466880&set=pb.61564006413825.-2207520000',
            ],
            [
                'date' => '2026-08-11',
                'date_label' => '11 août 2026',
                'category' => 'Communiqué',
                'title' => 'Compassion et appel à une action urgente pour la sécurité routière',
                'image' => 'assets/images/message-compassion.webp',
                'image_alt' => 'FECAPAS réunie autour de sa présidente',
                'url' => 'https://www.facebook.com/photo/?fbid=122209767404466880&set=pb.61564006413825.-2207520000',
            ],
        ],
        'join' => [
            'kicker' => 'Rejoignez le mouvement',
            'title' => 'Votre voix peut faire avancer la',
            'title_accent' => 'paix.',
            'description' => 'Suivez FECAPAS-RCA, partagez nos initiatives et prenez part à une communauté de femmes et d’alliés engagés.',
            'button' => 'Rejoindre sur Facebook',
        ],
    ];
}

function load_content(): array
{
    $defaults = default_content();

    if (!is_file(CONTENT_FILE)) {
        return $defaults;
    }

    $json = file_get_contents(CONTENT_FILE);
    $saved = is_string($json) ? json_decode($json, true) : null;

    if (!is_array($saved)) {
        return $defaults;
    }

    return array_replace_recursive($defaults, $saved);
}

function save_content(array $content): void
{
    ensure_storage_directories();
    $json = json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    if (!is_string($json)) {
        throw new RuntimeException('Le contenu n’a pas pu être encodé.');
    }

    $temporaryFile = CONTENT_FILE . '.tmp';

    if (file_put_contents($temporaryFile, $json . PHP_EOL, LOCK_EX) === false) {
        throw new RuntimeException('Le contenu n’a pas pu être enregistré.');
    }

    if (!rename($temporaryFile, CONTENT_FILE)) {
        @unlink($temporaryFile);
        throw new RuntimeException('Le contenu n’a pas pu être remplacé.');
    }
}

function ensure_storage_directories(): void
{
    foreach ([dirname(CONTENT_FILE), UPLOAD_DIRECTORY] as $directory) {
        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new RuntimeException('Le répertoire de stockage ne peut pas être créé.');
        }
    }
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function content_value(array $content, string $section, string $key): string
{
    $value = $content[$section][$key] ?? '';

    return is_scalar($value) ? (string) $value : '';
}

function public_asset_url(string $path): string
{
    if (preg_match('#^(https?:)?//#i', $path) === 1) {
        return $path;
    }

    return ltrim($path, '/');
}

function admin_asset_url(string $path): string
{
    if (preg_match('#^(https?:)?//#i', $path) === 1) {
        return $path;
    }

    return '../' . ltrim($path, '/');
}
