<?php

declare(strict_types=1);

const CONTENT_FILE = __DIR__ . '/../data/content.json';
const AUTH_FILE = __DIR__ . '/../data/auth.json';
const UPLOAD_DIRECTORY = __DIR__ . '/../uploads';
const MAX_DYNAMIC_ITEMS = 20;

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
            'description' => 'FECAPAS mobilise les femmes et les communautés centrafricaines autour de la prévention des conflits, du leadership féminin et d’une paix durable.',
            'primary_button' => 'Découvrir notre mission',
            'secondary_button' => 'Suivre nos actions',
            'stat_one_value' => '519+',
            'stat_one_label' => 'femmes réunies à Mandja Otto',
            'stat_two_value' => '2025–27',
            'stat_two_label' => 'plan d’actions communautaires',
            'image' => 'assets/images/distinction-presse-groupe.webp',
            'image_alt' => 'La présidente de FECAPAS entourée de femmes engagées à Bangui',
            'image_label' => 'Leadership reconnu',
            'image_title' => 'Agir localement, inspirer au-delà',
        ],
        'mission' => [
            'kicker' => 'Notre raison d’être',
            'title' => 'Transformer le courage',
            'title_accent' => 'en impact collectif.',
            'lead' => 'Faire des femmes des actrices reconnues de la prévention des conflits, de la consolidation de la paix et du développement communautaire.',
            'description' => 'À travers son plan d’actions 2025-2027 et son approche de proximité, FECAPAS crée des espaces de sensibilisation, de dialogue et de mobilisation afin que les femmes participent pleinement à la paix et à la sécurité en République centrafricaine.',
            'image' => 'assets/images/distinction-presse-conference.webp',
            'image_alt' => 'La présidente de FECAPAS prenant la parole lors d’une conférence à Bangui',
            'detail_content' => "FECAPAS-RCA place les femmes au cœur de la prévention des conflits, du dialogue communautaire et de la recherche de solutions durables. L’association agit pour que leur expérience, leur voix et leur capacité d’initiative contribuent aux décisions qui concernent la paix, la sécurité et le développement de leurs communautés.\n\nSon plan d’actions 2025-2027 s’appuie sur une politique de proximité destinée à faire adhérer les communautés de base aux idéaux de paix. Cette démarche associe sensibilisation, écoute, leadership féminin, solidarité et mobilisation citoyenne.\n\nLe 28 février 2025, cette approche s’est concrétisée à l’église CEBI de Mandja Otto, dans le 6e arrondissement de Bangui. Plus de 519 femmes Ouali Ti tènè Biani, venues de différents districts de la capitale et de ses périphéries, ont participé à une sensibilisation sur le rôle des femmes dans la prévention des conflits et la consolidation de la paix.\n\nLa rencontre a également ouvert une réflexion sur les droits, l’égalité et l’autonomisation des femmes et des filles. Les participantes ont souhaité poursuivre ces échanges à travers des rencontres trimestrielles et annuelles de renforcement des capacités.",
            'gallery' => [
                'assets/images/distinction-presse-groupe.webp',
                'assets/images/anniversaire-fecapas-presidente.webp',
                'assets/images/intercession-paix.webp',
                'assets/images/independance-rca-fecapas.webp',
            ],
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
            'description' => 'Des engagements documentés, menés au plus près des femmes et des communautés centrafricaines.',
        ],
        'actions' => [
            [
                'title' => 'Mobilisation communautaire à la base',
                'description' => 'Aller au contact des communautés pour faire des femmes des relais de paix, de dialogue et de cohésion.',
                'image' => 'assets/images/anniversaire-fecapas-presidente.webp',
                'image_alt' => 'Visuel officiel présentant le leadership féminin de FECAPAS',
                'detail_content' => "FECAPAS met en œuvre une approche de proximité afin que les communautés de base s’approprient les enjeux de paix et de sécurité. Les rencontres sont conçues comme des espaces d’écoute, de sensibilisation et de transmission où chaque participante peut devenir un relais dans sa famille, son église et son quartier.\n\nLe 28 février 2025, l’association a rencontré plus de 519 femmes Ouali Ti tènè Biani à l’église CEBI de Mandja Otto, dans le 6e arrondissement de Bangui. Les échanges ont porté sur le rôle des femmes, notamment des femmes croyantes, dans la prévention des conflits et la consolidation de la paix.\n\nFECAPAS a également introduit le thème de la Journée internationale des femmes 2025 : « Pour toutes les femmes et les filles : droits, égalité et autonomisation ». Les participantes ont demandé la tenue régulière de rencontres trimestrielles et annuelles pour renforcer leurs capacités.",
                'gallery' => [],
            ],
            [
                'title' => 'Leadership féminin et participation',
                'description' => 'Encourager les femmes à prendre la parole, à mobiliser et à participer aux décisions qui façonnent leur avenir.',
                'image' => 'assets/images/distinction-presse-groupe.webp',
                'image_alt' => 'Femmes réunies autour de la présidente de FECAPAS à Bangui',
                'detail_content' => "FECAPAS valorise un leadership féminin ancré dans le service, la solidarité et la responsabilité. L’objectif est de permettre à davantage de femmes de proposer des solutions, de conduire des initiatives communautaires et de participer aux décisions relatives à la paix et au développement.\n\nEn juin 2026, l’engagement social et communautaire de la présidente fondatrice, Manuella Géraldine Kobambe épouse Sangone, a été distingué à New Delhi par l’International Change Maker Award 2026 et un Doctorat Honoris Causa. À son retour à Bangui, elle a présenté ces distinctions comme une reconnaissance collective et a appelé les femmes et les jeunes à s’engager pour la paix, la sécurité et la cohésion sociale.",
                'gallery' => [
                    'assets/images/distinction-presse-interview.webp',
                    'assets/images/distinction-presse-conference.webp',
                    'assets/images/distinction-presse-declaration.webp',
                ],
            ],
            [
                'title' => 'Intercession nationale pour la paix',
                'description' => 'Rassembler responsables religieux, artistes et communautés dans un même élan d’unité et d’espérance.',
                'image' => 'assets/images/intercession-paix.webp',
                'image_alt' => 'Affiche officielle de la journée nationale d’intercession pour la paix',
                'detail_content' => "Le samedi 18 juillet 2026, FECAPAS a organisé une grande journée nationale d’intercession pour la paix en République centrafricaine. La rencontre s’est tenue de 8 heures à 16 heures à la salle de l’Ambassade chrétienne, à proximité de la Fédération centrafricaine de football.\n\nPlacée sous le thème « Dans l’intimité de Déborah », la journée a réuni plusieurs orateurs, responsables religieux et chantres invités. Cette mobilisation a associé prière, prise de parole et appel à l’engagement collectif pour la paix et la sécurité du pays.\n\nL’événement illustre la volonté de FECAPAS de fédérer différents réseaux de femmes et partenaires autour d’initiatives capables de renforcer l’unité nationale.",
                'gallery' => [],
            ],
            [
                'title' => 'Plaidoyer, solidarité et compassion',
                'description' => 'Porter la voix des familles touchées et appeler à des réponses collectives face aux enjeux de sécurité.',
                'image' => 'assets/images/message-compassion.webp',
                'image_alt' => 'La présidente de FECAPAS lors d’une prise de parole publique',
                'detail_content' => "FECAPAS associe la compassion à un plaidoyer concret en faveur de la protection des vies. Lorsqu’une communauté est touchée par un drame, l’association exprime sa solidarité, relaie les préoccupations des familles et appelle les acteurs concernés à agir.\n\nAprès l’accident de circulation impliquant un camion-citerne survenu le 7 août 2026 vers 19 heures à Bimbo, dans le secteur de la Rue des Sœurs, FECAPAS a adressé ses condoléances aux familles endeuillées et son soutien aux blessés. Son communiqué public a demandé une action urgente et durable en faveur de la sécurité routière.\n\nCette démarche rappelle que la paix et la sécurité concernent aussi la prévention des risques du quotidien, la responsabilité de chacun et la capacité des institutions et des citoyens à protéger la vie.",
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
            'title' => 'Actions, messages',
            'title_accent' => 'et temps forts.',
        ],
        'news' => [
            [
                'date' => '2026-08-13',
                'date_label' => '13 août 2026',
                'category' => 'Message national',
                'title' => 'FECAPAS célèbre l’indépendance de la République centrafricaine',
                'summary' => 'Un message d’unité, de responsabilité et d’engagement citoyen au service d’une nation de paix.',
                'image' => 'assets/images/independance-rca-fecapas.webp',
                'image_alt' => 'Message de FECAPAS pour la fête de l’indépendance de la République centrafricaine',
                'url' => 'https://www.facebook.com/photo/?fbid=122209983650466880&set=pb.61564006413825.-2207520000',
                'detail_content' => "À l’occasion de la fête de l’indépendance, FECAPAS a adressé ses vœux au peuple centrafricain et rappelé que la liberté nationale appelle une responsabilité partagée.\n\nLe message invite chaque citoyenne et chaque citoyen à faire vivre l’unité, la solidarité et la paix dans ses choix quotidiens. Pour l’association, l’indépendance prend tout son sens lorsque les communautés s’engagent ensemble à construire une nation stable, inclusive et sûre.",
                'gallery' => [],
            ],
            [
                'date' => '2026-08-11',
                'date_label' => '11 août 2026',
                'category' => 'Communiqué',
                'title' => 'Compassion et appel à une action urgente pour la sécurité routière',
                'summary' => 'Après le drame de Bimbo, FECAPAS appelle à renforcer durablement la prévention et la protection des vies.',
                'image' => 'assets/images/message-compassion.webp',
                'image_alt' => 'La présidente de FECAPAS lors d’une rencontre publique',
                'url' => 'https://www.facebook.com/photo/?fbid=122209767404466880&set=pb.61564006413825.-2207520000',
                'detail_content' => "Dans un communiqué publié le 11 août 2026, FECAPAS a exprimé sa profonde tristesse après l’accident de circulation impliquant un camion-citerne survenu le 7 août vers 19 heures à Bimbo, dans le secteur de la Rue des Sœurs.\n\nSelon le communiqué de l’association, le drame a causé le décès de plus de dix personnes et blessé plusieurs autres. FECAPAS a présenté ses condoléances aux familles endeuillées, exprimé son soutien aux blessés et appelé à une mobilisation urgente pour la sécurité routière.\n\nAu-delà de la compassion, l’association insiste sur la prévention, la responsabilité collective et la nécessité de mesures durables capables de réduire les risques et de mieux protéger les usagers de la route.",
                'gallery' => [],
            ],
            [
                'date' => '2026-08-10',
                'date_label' => '10 août 2026',
                'category' => 'Vie de l’association',
                'title' => 'Deux années de courage, de foi et d’actions pour la paix',
                'summary' => 'Fondée en 2024, FECAPAS célèbre deux années d’engagement collectif au service de la paix et de la sécurité.',
                'image' => 'assets/images/anniversaire-fecapas.webp',
                'image_alt' => 'Affiche du deuxième anniversaire de FECAPAS',
                'url' => 'https://www.facebook.com/photo/?fbid=122209645988466880&set=pb.61564006413825.-2207520000',
                'detail_content' => "FECAPAS a célébré en août 2026 ses deux années d’existence sous le message « Eben-Ezer, car l’Éternel nous a secourus jusqu’ici ». Fondée en 2024, l’association a placé cette étape sous le signe de la reconnaissance et de la continuité.\n\nLes visuels officiels de l’anniversaire mettent en avant deux années de courage, de foi et d’actions pour la paix et la sécurité. Ils rappellent également le leadership de la présidente fondatrice, Manuella Géraldine Kobambe épouse Sangone, et l’ambition de bâtir une nation de paix par les femmes, avec courage et détermination.\n\nCet anniversaire ne marque pas un aboutissement, mais un nouvel engagement à approfondir les actions communautaires, la participation des femmes et les partenariats au service de la paix.",
                'gallery' => [
                    'assets/images/anniversaire-fecapas-presidente.webp',
                ],
            ],
            [
                'date' => '2026-07-18',
                'date_label' => '18 juillet 2026',
                'category' => 'Événement',
                'title' => 'Une journée nationale d’intercession pour la paix',
                'summary' => 'De 8 heures à 16 heures, femmes, responsables religieux et artistes se sont mobilisés autour du thème « Dans l’intimité de Déborah ».',
                'image' => 'assets/images/intercession-paix.webp',
                'image_alt' => 'Affiche de la journée nationale d’intercession pour la paix',
                'url' => 'https://www.facebook.com/photo/?fbid=122209015640466880&set=pb.61564006413825.-2207520000',
                'detail_content' => "FECAPAS a organisé le samedi 18 juillet 2026 une grande journée nationale d’intercession pour la paix en République centrafricaine. L’événement s’est déroulé de 8 heures à 16 heures à la salle de l’Ambassade chrétienne, près de la Fédération centrafricaine de football.\n\nSous le thème « Dans l’intimité de Déborah », la rencontre a rassemblé plusieurs orateurs, responsables religieux et chantres invités. La programmation associait notamment le révérend Léonard G., le prophète Gamboy, le prophète T. Wallot et le pasteur A. Sana, ainsi que des artistes mobilisés pour porter le message de paix.\n\nCette journée a créé un espace d’unité, de prière et de responsabilité collective, fidèle à la conviction de FECAPAS : les femmes peuvent fédérer les communautés et contribuer activement à la sécurité et à la paix nationales.",
                'gallery' => [],
            ],
            [
                'date' => '2026-07-03',
                'date_label' => '03 juillet 2026',
                'category' => 'Leadership',
                'title' => 'Double distinction internationale pour la présidente de FECAPAS',
                'summary' => 'Après New Delhi, Manuella Géraldine Kobambe épouse Sangone partage à Bangui une reconnaissance dédiée au changement social et communautaire.',
                'image' => 'assets/images/distinction-presse-groupe.webp',
                'image_alt' => 'La présidente de FECAPAS entourée de participantes après la conférence de presse',
                'url' => 'https://etoileinfos.overblog.fr/2026/07/manuella-geraldine-kobambe-epouse-sangone-a-recu-le-prix-international-d-actrice-de-changement-d-award-2026-a-new-delhi-inde-et-un-titre-de-dr-honoris-causa.html',
                'detail_content' => "Le 20 juin 2026 à New Delhi, Manuella Géraldine Kobambe épouse Sangone, présidente fondatrice de FECAPAS, a reçu l’International Change Maker Award 2026 ainsi qu’un titre de Docteur Honoris Causa décerné par la Socrates Social Research University.\n\nÀ son retour en République centrafricaine, elle a présenté ces distinctions aux médias lors d’une conférence de presse organisée le 3 juillet 2026 à l’Hôtel Ledger Plaza de Bangui. Elle a décrit cette reconnaissance non comme une consécration personnelle, mais comme la mise en valeur d’un engagement collectif pour la paix, le développement, la justice et la solidarité.\n\nSon message aux femmes et à la jeunesse a rappelé qu’aucun développement durable n’est possible sans paix ni sécurité. Elle les a invités à participer activement à la vie du pays et aux initiatives de cohésion sociale.",
                'gallery' => [
                    'assets/images/distinction-presse-interview.webp',
                    'assets/images/distinction-presse-conference.webp',
                    'assets/images/distinction-presse-declaration.webp',
                ],
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

    $content = array_replace_recursive($defaults, $saved);

    foreach (['values', 'actions', 'news'] as $collection) {
        if (isset($saved[$collection]) && is_array($saved[$collection])) {
            $content[$collection] = array_values(array_filter($saved[$collection], 'is_array'));
        }
    }

    return $content;
}

function new_action_content(): array
{
    return [
        'title' => 'Nouvelle action',
        'description' => 'Ajoutez une présentation courte de cette action.',
        'image' => 'assets/images/intercession-paix.webp',
        'image_alt' => '',
        'detail_content' => 'Décrivez ici le contexte, les objectifs et les résultats attendus de cette action.',
        'gallery' => [],
    ];
}

function new_news_content(): array
{
    return [
        'date' => date('Y-m-d'),
        'date_label' => '',
        'category' => 'Actualité',
        'title' => 'Nouvelle actualité',
        'summary' => 'Ajoutez un résumé de cette actualité.',
        'image' => 'assets/images/anniversaire-fecapas.webp',
        'image_alt' => '',
        'url' => '',
        'detail_content' => 'Décrivez ici cette actualité en détail.',
        'gallery' => [],
    ];
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

function item_value(array $item, string $key): string
{
    $value = $item[$key] ?? '';

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
