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
            'image' => 'assets/images/message-compassion.webp',
            'image_alt' => 'Des membres de FECAPAS réunies autour de leur présidente',
            'detail_content' => "FECAPAS-RCA place les femmes au cœur de la prévention des conflits, du dialogue communautaire et de la recherche de solutions durables. Notre mission est de créer les conditions qui leur permettent de faire entendre leur voix, de partager leur expérience et d’agir dans leur quartier comme à l’échelle nationale.\n\nNous développons des espaces de sensibilisation, d’écoute et de mobilisation ouverts aux femmes, aux jeunes, aux responsables communautaires et à toutes les personnes qui souhaitent contribuer à une société plus solidaire. Chaque initiative cherche à rapprocher les communautés et à faire grandir une culture de non-violence.\n\nNotre engagement s’appuie sur la conviction que la paix se construit au quotidien : par la parole, la compassion, la responsabilité et des actions concrètes menées au plus près des réalités.",
            'gallery' => [],
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
                'image' => 'assets/images/intercession-paix.webp',
                'image_alt' => 'Mobilisation de FECAPAS en faveur de la paix',
                'detail_content' => "La sensibilisation aide chacun à reconnaître son rôle dans la construction d’un climat apaisé. FECAPAS-RCA porte des messages accessibles qui encouragent l’écoute, la tolérance et le règlement pacifique des désaccords.\n\nNos prises de parole et rencontres communautaires rappellent que la paix n’est pas seulement l’absence de conflit : elle se nourrit de respect, de confiance et de responsabilité partagée. Nous invitons les femmes, les familles et les acteurs locaux à devenir des relais de ces valeurs.",
                'gallery' => [],
            ],
            [
                'title' => 'Leadership féminin',
                'description' => 'Encourager les femmes à prendre la parole et à participer aux décisions qui façonnent leur avenir.',
                'image' => 'assets/images/message-compassion.webp',
                'image_alt' => 'La présidente et des membres de FECAPAS',
                'detail_content' => "Le leadership féminin renforce la capacité des communautés à comprendre leurs besoins et à y répondre de façon inclusive. FECAPAS-RCA valorise la prise de parole, l’initiative et la participation active des femmes aux décisions qui concernent leur avenir.\n\nNous favorisons le partage d’expériences et la mise en confiance afin que davantage de femmes puissent proposer, mobiliser et conduire des actions utiles. Une femme qui ose agir ouvre aussi la voie à d’autres.",
                'gallery' => [],
            ],
            [
                'title' => 'Mobilisation communautaire',
                'description' => 'Fédérer citoyens, responsables et partenaires autour d’initiatives locales concrètes.',
                'image' => 'assets/images/anniversaire-fecapas.webp',
                'image_alt' => 'Une initiative communautaire portée par FECAPAS',
                'detail_content' => "Les changements durables naissent lorsque les habitants participent à leur conception. FECAPAS-RCA rassemble les bonnes volontés autour d’objectifs communs et facilite le dialogue entre les citoyens, les responsables locaux et les partenaires.\n\nChaque mobilisation est pensée à partir des réalités du terrain. Elle permet de faire émerger des idées, de coordonner les efforts et de transformer la solidarité en actions visibles au service de la paix et de la sécurité.",
                'gallery' => [],
            ],
            [
                'title' => 'Solidarité & compassion',
                'description' => 'Être présente auprès des populations et porter des messages d’unité face aux épreuves.',
                'image' => 'assets/images/message-compassion.webp',
                'image_alt' => 'FECAPAS réunie pour porter un message de compassion',
                'detail_content' => "Dans les moments difficiles, la présence et l’écoute sont essentielles. FECAPAS-RCA exprime sa solidarité auprès des personnes touchées par les épreuves et porte des messages qui appellent à l’unité, à la dignité et à la responsabilité.\n\nNotre démarche cherche à créer des liens plutôt qu’à laisser l’isolement s’installer. Par la compassion et l’action collective, nous voulons rappeler à chaque personne qu’elle compte et que la communauté peut devenir une force de soutien.",
                'gallery' => [],
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
                'summary' => 'Retour sur deux années d’engagement collectif au service de la paix et de la sécurité.',
                'image' => 'assets/images/anniversaire-fecapas.webp',
                'image_alt' => 'Affiche du deuxième anniversaire de FECAPAS',
                'url' => 'https://www.facebook.com/photo/?fbid=122209644860466880&set=pb.61564006413825.-2207520000',
                'detail_content' => "FECAPAS-RCA célèbre deux années d’engagement portées par le courage, la foi et la volonté d’agir pour la paix. Cet anniversaire est l’occasion de regarder le chemin parcouru et de remercier toutes les femmes, communautés et personnes de bonne volonté qui accompagnent cette mission.\n\nChaque rencontre et chaque message partagé renforcent notre détermination à poursuivre le travail. Cette étape ouvre un nouveau chapitre, avec la même ambition : rassembler davantage et transformer l’engagement en impact durable.",
                'gallery' => [],
            ],
            [
                'date' => '2026-08-05',
                'date_label' => '05 août 2026',
                'category' => 'Événement',
                'title' => 'Une journée nationale d’intercession pour la paix',
                'summary' => 'Un temps de mobilisation, d’unité et d’espérance pour la République centrafricaine.',
                'image' => 'assets/images/intercession-paix.webp',
                'image_alt' => 'Affiche de la journée nationale d’intercession pour la paix',
                'url' => 'https://www.facebook.com/photo/?fbid=122209015640466880&set=pb.61564006413825.-2207520000',
                'detail_content' => "Cette journée nationale d’intercession rassemble les voix et les espérances autour d’un même appel : voir grandir une paix durable en République centrafricaine.\n\nFECAPAS-RCA s’associe à cette mobilisation en invitant les femmes, les familles et les communautés à faire de ce temps un moment d’unité, de recueillement et de responsabilité collective.",
                'gallery' => [],
            ],
            [
                'date' => '2026-08-11',
                'date_label' => '11 août 2026',
                'category' => 'Communiqué',
                'title' => 'Compassion et appel à une action urgente pour la sécurité routière',
                'summary' => 'Un appel à la prévention et à la responsabilité collective pour mieux protéger les vies.',
                'image' => 'assets/images/message-compassion.webp',
                'image_alt' => 'FECAPAS réunie autour de sa présidente',
                'url' => 'https://www.facebook.com/photo/?fbid=122209767404466880&set=pb.61564006413825.-2207520000',
                'detail_content' => "Face aux drames de la route, FECAPAS-RCA adresse sa compassion aux victimes, à leurs familles et à toutes les personnes touchées. Au-delà de l’émotion, ces situations nous appellent à renforcer la prévention et la responsabilité de chacun.\n\nNous encourageons une mobilisation urgente et durable autour de la sécurité routière afin de protéger les vies. Informer, sensibiliser et agir ensemble sont des étapes indispensables pour éviter de nouvelles tragédies.",
                'gallery' => [],
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

function gallery_paths(mixed $gallery): array
{
    if (!is_array($gallery)) {
        return [];
    }

    return array_values(array_filter(
        $gallery,
        static fn (mixed $path): bool => is_string($path) && $path !== '',
    ));
}
