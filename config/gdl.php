<?php

/*
 * Grenada Distillers Ltd / Clarke's Court: every fact the site shows lives here, read via gdl('key').
 * Sources are noted next to each fact. Anything marked UNVERIFIED is listed in the README under
 * "Before launch: confirm with the client". Never add prices, awards, stats or testimonials
 * that the client has not supplied.
 */
return [
    'name' => 'Grenada Distillers Ltd',
    'short_name' => "Clarke's Court",
    'tagline' => 'Rum from Woodlands, Grenada, since 1937',
    'description' => "Clarke's Court rum is made by Grenada Distillers Ltd at Woodlands, St George, Grenada. See the range, book a distillery tour, send a trade or export enquiry, or apply for a job.",
    'footer_blurb' => "Grenada's rum, distilled at Woodlands, St George, on the old Grenada Sugar Factory estate since 1937.",
    'credits_lead' => 'Where each photograph comes from, and the licence it is used under.',
    'directions' => "The distillery is in the Woodlands valley in the south of St George, a short drive inland from Clarke's Court Bay and about 15 minutes from Grand Anse and the airport. Taxi drivers know it as the Clarke's Court factory.",
    'contact_photo' => 'bay',
    'founded' => 1937,
    // Legal drinking age in Grenada.
    'legal_age' => 18,

    // true on the temporary preview domain: banner + noindex. Remove at launch.
    'preview' => (bool) env('GDL_PREVIEW', false),
    // (473) 444-5363 is the tours and office number on the archived clarkescourtrum.com (2006-2014). UNVERIFIED today.
    'phone' => env('GDL_PHONE', '473-444-5363'),
    'whatsapp' => env('GDL_WHATSAPP', ''),
    // assistsect@ is the address on every GDL vacancy notice on NOW Grenada, 2023-25. A general
    // info@ mailbox is recommended at launch. UNVERIFIED as the public address.
    'email' => env('GDL_EMAIL', 'assistsect@clarkescourtrum.com'),
    // Who gets "new request" emails, comma separated.
    'notify' => env('GDL_NOTIFY_EMAIL', ''),
    'admin' => [
        'name' => env('ADMIN_NAME', 'Administrator'),
        'email' => env('ADMIN_EMAIL'),
        'password' => env('ADMIN_PASSWORD'),
    ],

    'address' => [
        'street' => 'Woodlands',
        'locality' => 'Woodlands',
        'parish' => 'St George',
        'country' => 'Grenada',
        'country_code' => 'GD',
    ],
    'map_url' => 'https://www.google.com/maps/search/?api=1&query=Grenada+Distillers+Ltd+Woodlands+St+George+Grenada',
    // Linked from the archived site (2014). UNVERIFIED: confirm the accounts are still the company's.
    'social' => [
        'facebook' => 'https://www.facebook.com/clarkes.court',
        'instagram' => 'https://instagram.com/clarkescourtrum',
    ],

    // Office and factory hours: 8am to 4pm, Monday to Friday (archived "About us", 2014). Confirm.
    'opening' => [
        1 => ['08:00', '16:00'],
        2 => ['08:00', '16:00'],
        3 => ['08:00', '16:00'],
        4 => ['08:00', '16:00'],
        5 => ['08:00', '16:00'],
    ],
    // Public holidays: no tours. Y-m-d.
    'closed_dates' => [
        '2026-12-25', '2026-12-26', '2027-01-01', '2027-02-07', '2027-03-26', '2027-03-29',
    ],

    'tours' => [
        // The archived site says tours run 8:30am to 3:30pm, Monday to Friday, and groups can book weekends.
        // The fixed start times and capacity below are a proposal: confirm with the client.
        'slots' => [
            1 => ['09:00', '10:30', '13:00', '14:30'],
            2 => ['09:00', '10:30', '13:00', '14:30'],
            3 => ['09:00', '10:30', '13:00', '14:30'],
            4 => ['09:00', '10:30', '13:00', '14:30'],
            5 => ['09:00', '10:30', '13:00', '14:30'],
        ],
        'days_ahead' => 60,
        // Defaults for Settings (guests per tour, largest online party). UNVERIFIED.
        'slot_capacity' => 20,
        'max_party' => 12,
        // Seconds a booking waits for another booking of the same slot to finish.
        'lock_wait' => 5,
        'group_types' => [
            'couple' => 'Just me, or a couple',
            'family' => 'Family or friends',
            'cruise' => 'Cruise passengers',
            'operator' => 'Tour operator or taxi driver with guests',
            'school' => 'School or college group',
            'business' => 'Business or trade visit',
        ],
        'photo' => 'engine',
        // From the archived "Factory tour" and "About us" pages (2006, 2014).
        'about' => [
            'lead' => "A guide walks you through how Clarke's Court is made, from cane and molasses to the still, the casks and the bottling line, then pours a tasting at the Hospitality Centre.",
            'heading' => 'Cane, still, cask, bottle',
            'stops' => [
                ['title' => 'Welcome and the story of Woodlands', 'text' => "One of the distillery's guides explains the history of the estate and how the factory has made rum here since 1937."],
                ['title' => 'From cane to molasses to rum', 'text' => 'See the stages of production: sugar cane, syrup and molasses, fermentation and distillation.'],
                ['title' => 'Old steam engines', 'text' => 'Some of the steam engines on the site date back as far as 1886.'],
                ['title' => 'Ageing, blending and bottling', 'text' => 'How the rums are aged in oak, blended to recipe and bottled.'],
                ['title' => 'Hospitality Centre and tasting', 'text' => "Barrel furniture made from used rum casks, the full Clarke's Court range, a tasting for adults and recipes to take home."],
            ],
            'days_text' => 'Monday to Friday',
            'side_photo' => 'cane-drop',
            'side_alt' => 'Cut sugar cane dropping from the hoist into the mill at Woodlands',
        ],
    ],

    'trade' => [
        'business_types' => [
            'importer' => 'Importer or distributor',
            'wholesaler' => 'Wholesaler',
            'retailer' => 'Retailer or off-licence',
            'travel_retail' => 'Duty-free or travel retail',
            'on_trade' => 'Bar, hotel or restaurant',
            'cruise' => 'Cruise line or yacht supplier',
            'other' => 'Something else',
        ],
        'volumes' => [
            'samples' => 'Samples first',
            'cases' => 'A few cases',
            'pallet' => 'About a pallet',
            'container' => 'A container or more',
            'unsure' => 'Not sure yet',
        ],
        'page' => [
            'photo' => 'casks',
            'lead' => "Grenada Distillers ships white, dark, aged and flavoured rums and liqueurs from Woodlands. Importers, distributors, duty-free and bars can reach the export team here and get an answer from a named person.",
            'points' => [
                ['icon' => 'barrel', 'title' => 'A full range from one distillery', 'text' => 'White and overproof rum, dark and aged rums, flavoured rums and spiced liqueurs, all made at Woodlands since 1937.'],
                ['icon' => 'shield', 'title' => 'Food-safety certified', 'text' => 'Grenada Distillers has held ISO 22000 food-safety certification since 2017 (company announcement, July 2020).'],
                ['icon' => 'globe', 'title' => 'Coming to the UK trade', 'text' => "Clarke's Court is preparing a UK trade launch. UK buyers can register their interest now.", 'link' => ['label' => 'clarkescourt.com (UK holding page)', 'url' => 'https://clarkescourt.com']],
            ],
        ],
    ],

    'careers' => [
        'experience' => [
            'none' => 'None yet, I am starting out',
            '1_2' => '1 to 2 years',
            '3_5' => '3 to 5 years',
            '6_10' => '6 to 10 years',
            '10_plus' => 'More than 10 years',
        ],
        'qualifications' => [
            'school' => 'Secondary school',
            'cxc' => 'CSEC (CXC) passes',
            'cape' => 'CAPE or A levels',
            'associate' => 'Associate degree or diploma (e.g. TAMCC)',
            'degree' => "Bachelor's degree",
            'postgrad' => 'Postgraduate degree',
            'professional' => 'Professional qualification (ACCA, CPA …)',
        ],
        'photo' => 'still',
        'lead' => 'Grenada Distillers employs people in production, blending, quality, the warehouse, sales and the office at Woodlands. Open vacancies are listed here, and you can apply online with your CV.',
        'side_photo' => 'launch',
        'side_alt' => 'Grenada Distillers staff at the launch of Black Gold rum at the distillery',
    ],
    'parishes' => [
        'st_george' => 'St George',
        'st_david' => 'St David',
        'st_andrew' => 'St Andrew',
        'st_patrick' => 'St Patrick',
        'st_mark' => 'St Mark',
        'st_john' => 'St John',
        'carriacou' => 'Carriacou and Petite Martinique',
        'overseas' => 'Outside Grenada',
    ],

    'enquiry_topics' => [
        'general' => 'A general question',
        'where_to_buy' => 'Where to buy our rum',
        'tour_group' => 'A large group or private tour',
        'events' => 'Events and sponsorship',
        'media' => 'Media and press',
        'feedback' => 'Feedback about a product',
    ],

    'families' => [
        'aged' => ['label' => 'Aged & dark', 'title' => 'Aged and dark rums', 'photo' => 'casks', 'blurb' => 'Rums matured in oak, from the golden Special Dark to Old Grog, the sipping rum named for the casks once marked for King George III.'],
        'white' => ['label' => 'White & overproof', 'title' => 'White and overproof rums', 'photo' => 'still', 'blurb' => "Clear rums straight from Woodlands: Pure White, the brand's principal rum at 69%, and the lighter Superior Light."],
        'flavoured' => ['label' => 'Flavoured & liqueurs', 'title' => 'Flavoured rums and liqueurs', 'photo' => 'nutmeg', 'blurb' => "Rum with Grenada's fruit and spice: lemon, sorrel, passion fruit, coconut, and Camerhogne, the spice liqueur named for the island."],
    ],
    'range' => [
        'photo' => 'range',
        'lead' => 'Every Clarke\'s Court rum is distilled from molasses and blended at Woodlands. The facts on these pages come from the distillery\'s own published product notes.',
    ],

    // Product facts from the archived clarkescourtrum.com product pages (Wayback Machine) only.
    // No awards, prices or sizes unless the source states them. Ranges change: confirm with the client.
    'rums' => [
        'old-grog' => [
            'name' => 'Old Grog', 'family' => 'aged', 'style' => 'Premium sipping rum', 'abv' => 40, 'photo' => 'bottle-old-grog',
            'summary' => "A premium sipping rum whose name goes back to the casks of Grenada's finest rum shipped to King George III, marked G.R.O.G. for Georgius Rex Old Grenada.",
            'notes' => [
                "Clarke's Old Grog is a premium sipping rum. It dates back to the early days when the finest of Grenada's rum was shipped to His Majesty George III of England. To identify the King's rum, the casks were marked G.R.O.G., short for Georgius Rex Old Grenada.",
                'Appearance: copper gold. Aroma: a hint of smoky oak. Palate: tropical fruit and spice, with oak that lingers smoothly.',
            ],
            'serve' => 'Neat or over ice.',
            'sources' => [['label' => "Clarke's Court Grog Rum, clarkescourtrum.com (archived 2015)", 'url' => 'https://web.archive.org/web/20150131201448/http://www.clarkescourtrum.com/products/aged/clarke-s-court-grog-rum']],
        ],
        'old-grog-extra-old' => [
            'name' => 'Old Grog Extra Old', 'family' => 'aged', 'style' => 'Extra old rum', 'abv' => null, 'photo' => 'bottle-old-grog-extra-old',
            'summary' => 'The extra-old expression of Old Grog, listed among the aged rums in the Clarke\'s Court range.',
            'notes' => ['Old Grog Extra Old sits alongside Old Grog in the aged range. The distillery\'s tasting notes and strength for this rum will be added once Grenada Distillers supplies them.'],
            'sources' => [['label' => "Clarke's Court Old Grog Extra Old, clarkescourtrum.com (archived 2015)", 'url' => 'https://web.archive.org/web/20150423005842/http://www.clarkescourtrum.com/products/aged/clarke-s-court-old-grog-extra-old-rum']],
        ],
        'number-37' => [
            'name' => '#37', 'family' => 'aged', 'style' => 'Double-matured golden rum', 'abv' => null, 'photo' => 'bottle-37',
            'summary' => 'A double-matured golden rum launched at the distillery in April 2010 and named for 1937, the year the distillery began.',
            'notes' => [
                "#37 was launched on 16 April 2010 with a tasting at Nick's Barrel House, the retail and visitor centre at the distillery. It was the thirteenth product in the Clarke's Court line.",
                'It is a double-matured golden rum. At launch, limited-edition bottles were offered numbered and signed by the company\'s chairman.',
            ],
            'serve' => 'A sipping rum: neat, or with a single cube of ice.',
            'sources' => [
                ['label' => "Clarke's Court launches #37, company news, April 2010 (archived)", 'url' => 'https://web.archive.org/web/20110620204239/http://www.clarkescourtrum.com/news/2010/37-launched-21-04-10.html'],
                ['label' => "Clarke's Court #37, clarkescourtrum.com (archived 2014)", 'url' => 'https://web.archive.org/web/20141127132630/http://www.clarkescourtrum.com/products/specialty/clarke-s-court-37'],
            ],
        ],
        'special-dark' => [
            'name' => 'Special Dark', 'family' => 'aged', 'style' => 'Golden rum', 'abv' => 40, 'photo' => 'bottle-special-dark',
            'summary' => 'A warm, mellow golden rum, blended and aged in oak bourbon barrels.',
            'notes' => ['A warm, mellow rum, golden in colour, blended and aged in traditional oak bourbon barrels. Special Dark is 40% alcohol by volume and well loved by those who prefer a gentler rum.'],
            'serve' => 'Over ice, or with cola or ginger beer.',
            'sources' => [['label' => "Clarke's Court Special Dark Rum, clarkescourtrum.com (archived 2015)", 'url' => 'https://web.archive.org/web/20150131201523/http://www.clarkescourtrum.com/products/dark/clarke-s-court-special-dark-rum']],
        ],
        'black-gold' => [
            'name' => 'Black Gold', 'family' => 'aged', 'style' => 'Rum infused with nutmeg', 'abv' => 46, 'sizes' => ['750 ml'], 'photo' => 'nutmeg', 'cover' => true,
            'summary' => "A premium Grenadian rum infused with nutmeg flavour, made to add value to the island's best-known spice.",
            'notes' => [
                'Black Gold is a premium Grenadian rum infused with nutmeg flavour. The concept was developed by the chairman of the board, who saw the need to bring new life to the nutmeg.',
                'The name "Black Gold" was coined by the late Prime Minister George Brizan, a firm advocate of adding value to the nutmeg crop. Aroma: nutmeg.',
            ],
            'serve' => 'On the rocks or neat.',
            'sources' => [['label' => 'Black Gold, clarkescourtrum.com (archived 2016)', 'url' => 'https://web.archive.org/web/20160619001420/http://www.clarkescourtrum.com/products/specialty/black-gold']],
        ],
        'pure-white' => [
            'name' => 'Pure White', 'family' => 'white', 'style' => 'Overproof white rum', 'abv' => 69, 'photo' => 'bottle-pure-white',
            'summary' => "The principal product of the Clarke's Court brand: a white rum made from molasses and bottled at 69%.",
            'notes' => ['Pure White is the principal product of the Clarke\'s Court brand. Made from molasses, it is blended to give the rum its special flavour, and bottled at 69% alcohol by volume.'],
            'serve' => 'In rum punch, or straight with a dash of bitters.',
            'sources' => [['label' => "Clarke's Court Pure White Rum, clarkescourtrum.com (archived 2014)", 'url' => 'https://web.archive.org/web/20141127132400/http://www.clarkescourtrum.com/products/light/clarke-s-court-pure-white-rum']],
        ],
        'superior-light' => [
            'name' => 'Superior Light', 'family' => 'white', 'style' => 'Light white rum', 'abv' => 40, 'photo' => 'bottle-superior-light',
            'summary' => 'A light, mellow rum with a clean, fresh taste, for people who prefer lighter rums.',
            'notes' => ['Superior Light is aged and has a clean, fresh taste. It is light, mellow and 40% alcohol by volume: the one for those who prefer lighter rums.'],
            'serve' => 'With soda and lime, or in a daiquiri.',
            'sources' => [['label' => "Clarke's Court Superior Light Rum, clarkescourtrum.com (archived 2015)", 'url' => 'https://web.archive.org/web/20150818191315/http://www.clarkescourtrum.com/products/light/clarke-s-court-superior-light-rum']],
        ],
        'rum-lemon' => [
            'name' => 'Rum Lemon', 'family' => 'flavoured', 'style' => 'Lemon-flavoured rum', 'abv' => 35, 'photo' => 'bottle-rum-lemon',
            'summary' => 'Crystal clear and light-bodied, with a citrus note and a long, lingering citrus finish.',
            'notes' => ['Crystal clear and light-bodied, with a citrus note. Rum Lemon has a rich, smooth entry, a medium to full-bodied palate and a long, lingering citrus finish. It is 35% alcohol by volume.'],
            'serve' => 'In any fruit-juice mix, or on the rocks.',
            'sources' => [['label' => "Clarke's Court Lemon, clarkescourtrum.com (archived 2014)", 'url' => 'https://web.archive.org/web/20141127152743/http://www.clarkescourtrum.com/products/flavored/clarke-s-court-lemon']],
        ],
        'sorrel' => [
            'name' => 'Sorrel', 'family' => 'flavoured', 'style' => 'Sorrel and spice rum', 'abv' => 20, 'photo' => 'bottle-sorrel',
            'summary' => "Grenadian sorrel and spices blended with the distillery's own rum: light and mellow, at 20%.",
            'notes' => ["A blend of indigenous extracts of sorrel and the spices of Grenada with the distillery's own distilled rum, giving a light, mellow drink. Rum Sorrel is 20% alcohol by volume."],
            'serve' => 'Chilled, or as the base for a sorrel punch.',
            'sources' => [['label' => "Clarke's Court Sorrel, clarkescourtrum.com (archived 2014)", 'url' => 'https://web.archive.org/web/20141115173425/http://www.clarkescourtrum.com/products/flavored/clarke-s-court-sorrel']],
        ],
        'passion-fruit' => [
            'name' => 'Passion Fruit', 'family' => 'flavoured', 'style' => 'Passion-fruit rum', 'abv' => null, 'photo' => 'bottle-passion-fruit',
            'summary' => 'A smooth, refreshing rum with the authentic taste of passion fruit.',
            'notes' => ["Clarke's Court Passion Fruit has a smooth, refreshing and authentic taste. Like the rest of the range it is made by the distillery's trained distillers from molasses and blended to their own traditional methods."],
            'sources' => [['label' => "Clarke's Court Passion Fruit, clarkescourtrum.com (archived 2019)", 'url' => 'https://web.archive.org/web/20191013043150/http://www.clarkescourtrum.com/products/flavored/clarke-s-court-passion-fruit']],
        ],
        'rhythm-coconut' => [
            'name' => 'Rhythm Coconut', 'family' => 'flavoured', 'style' => 'Coconut rum', 'abv' => null, 'photo' => 'bottle-rhythm-coconut',
            'summary' => "Clarke's Court's coconut rum, part of the flavoured range.",
            'notes' => ["Rhythm Coconut is the coconut rum in the Clarke's Court flavoured range. Tasting notes and strength will be added once Grenada Distillers supplies them."],
            'sources' => [['label' => "Clarke's Court Rhythm Coconut Rum, clarkescourtrum.com (archived 2014)", 'url' => 'https://web.archive.org/web/20141127153103/http://www.clarkescourtrum.com/products/flavored/clarke-s-court-rhythm-coconut-rum']],
        ],
        'mojito' => [
            'name' => 'Mojito', 'family' => 'flavoured', 'style' => 'Mojito-flavoured rum', 'abv' => null, 'photo' => 'bottle-mojito',
            'summary' => 'The flavours of a mojito in a ready-flavoured Clarke\'s Court rum.',
            'notes' => ["Clarke's Court Mojito is part of the flavoured range. Tasting notes and strength will be added once Grenada Distillers supplies them."],
            'sources' => [['label' => "Clarke's Court Mojito, clarkescourtrum.com (archived 2014)", 'url' => 'https://web.archive.org/web/20141127153021/http://www.clarkescourtrum.com/products/flavored/clarke-s-court-mojito']],
        ],
        'camerhogne' => [
            'name' => 'Camerhogne Spice Liqueur', 'family' => 'flavoured', 'style' => 'Spiced rum liqueur', 'abv' => null, 'photo' => 'bottle-camerhogne',
            'summary' => 'A rich, spicy rum liqueur flavoured with nutmeg, named with the Amerindian name for Grenada.',
            'notes' => ['Camerhogne is the Amerindian name for Grenada, and lends itself to this rich spice rum liqueur. Its smooth, spicy and fruity flavour is well balanced, with the island\'s nutmeg at its heart.'],
            'serve' => 'Over ice, or in coffee.',
            'sources' => [['label' => 'Camerhogne Spice Liqueur, clarkescourtrum.com (archived 2014)', 'url' => 'https://web.archive.org/web/20141127132337/http://www.clarkescourtrum.com/products/dark/camerhogne-spice-liqueur']],
        ],
    ],

    'home' => [
        'hero_alt' => "A row of Clarke's Court rums standing on the sand at the water's edge",
        'title' => "Grenada's rum, made at Woodlands since 1937.",
        'lead' => "Clarke's Court comes from the largest distillery in Grenada, on the old sugar estate in the Woodlands valley, St George. See the range, visit the distillery, or bring the rum to your market.",
        'range_title' => 'From Pure White to Old Grog',
        'featured' => ['pure-white', 'old-grog', 'number-37', 'special-dark'],
        'heritage_title' => 'An estate older than the island\'s capital streets',
        'heritage_text' => "Clarke's Court takes its name from Clarke's Court Bay and the Woodlands estate, which Gedney Clarke assembled in the 1700s. The distillery has made rum on the site since 1937.",
        'heritage_photo' => 'bay',
        'heritage_alt' => "Sunset over Clarke's Court Bay, Woburn, with small boats on the water",
        'tour_photo' => 'engine',
        'tour_alt' => 'A restored sugar-mill steam engine with a large flywheel, on a lawn',
        'tour_title' => 'Visit the distillery',
        'tour_text' => 'A guide shows you how the rum is made, from molasses and the still to the casks, past steam engines from as early as 1886, and pours a tasting for adults at the Hospitality Centre.',
        'export_title' => 'Importers, distributors and duty-free',
        'export_text' => 'Tell the export team about your market and your first order. Every enquiry gets a reference number and a named person who follows it up.',
    ],

    'heritage' => [
        'photo' => 'bay',
        'title' => "The story of Clarke's Court",
        'lead' => 'A Woodlands sugar estate with three centuries of history, and a distillery that has made rum on it since 1937.',
        'story' => [
            "Clarke's Court rum takes its name from Clarke's Court Bay in Woodlands, a few minutes from the distillery. The name is said to come from two sources. Dutch colonists who came to Grenada in the 1670s seized land around the bay and called it Court Bay; the French later took it back. Between 1763 and around 1801, Gedney Clarke bought parcels of land from the French totalling about 780 acres, the land known today as the Woodlands Estate, and with it Court Bay.",
            'Before that, the bay was known as Watering Bay, a name from the Caribs, who were active here because of its freshwater springs.',
            'Like every sugar estate in the Caribbean, Clarke\'s Court was built on the labour of enslaved Africans. An inventory from 1771 lists 211 enslaved people on the plantation, which then ran two sugar works with a boiling house, curing house and still house. In 1795 the estate was the scene of fighting during the uprising in Grenada.',
            "The distillery has been in operation since 1937 and is the largest in Grenada. Before the name Clarke's Court was established, its rums were sold as Tradewinds and Red Neck.",
        ],
        'side_photo' => 'estate-sale',
        'side_alt' => "Printed particulars for the 1877 sale of the Clarke's Court sugar estate, 770 acres",
        'side_caption' => "Particulars for the sale of the Clarke's Court estate, 28 November 1877. Library of Congress, via Wikimedia Commons.",
        'timeline' => [
            ['year' => '1670s', 'title' => 'Court Bay', 'text' => 'Dutch colonists seize land around the bay in Woodlands and name it Court Bay, according to the distillery\'s own history. The French later recapture it.', 'source' => ['label' => 'Our story, clarkescourtrum.com (archived 2014)', 'url' => 'https://web.archive.org/web/20141127132144/http://www.clarkescourtrum.com/about-us']],
            ['year' => '1763', 'title' => 'Gedney Clarke buys the land', 'text' => 'From 1763 to around 1801 Gedney Clarke buys parcels of land from the French, about 780 acres in all, including Court Bay: the origin of the name Clarke\'s Court.', 'source' => ['label' => 'Our story, clarkescourtrum.com (archived 2014)', 'url' => 'https://web.archive.org/web/20141127132144/http://www.clarkescourtrum.com/about-us']],
            ['year' => '1771', 'title' => 'An estate of enslaved labour', 'text' => 'An inventory lists 211 enslaved people on the plantation and two sugar works, an upper works driven by a stone windmill and a lower works by a cattle mill.', 'source' => ['label' => 'Research by Dr S. D. Smith, University of York, published on clarkescourtrum.com', 'url' => 'https://web.archive.org/web/20030204123529/http://www.clarkescourtrum.com/effect/morehistory.htm']],
            ['year' => '1795', 'title' => 'The uprising', 'text' => 'Clarke\'s Court is the scene of fighting during the revolt in Grenada; crops on the estate are not fully harvested again until 1799.', 'source' => ['label' => 'Research by Dr S. D. Smith, University of York, published on clarkescourtrum.com', 'url' => 'https://web.archive.org/web/20030204123529/http://www.clarkescourtrum.com/effect/morehistory.htm']],
            ['year' => '1824', 'title' => 'Sugar cane on 770 acres', 'text' => 'A survey shows the estate has passed to John Ross, who holds 770 acres, used mostly to grow sugar cane.', 'source' => ['label' => 'Our story, clarkescourtrum.com (archived 2014)', 'url' => 'https://web.archive.org/web/20141127132144/http://www.clarkescourtrum.com/about-us']],
            ['year' => '1877', 'title' => 'The estate is sold', 'text' => "Clarke's Court, \"containing 770 acres or thereabouts\", is offered for sale with its fixtures, machinery and stock on 28 November 1877.", 'source' => ['label' => 'Sale particulars, Library of Congress (Wikimedia Commons)', 'url' => 'https://commons.wikimedia.org/wiki/File:Grenada,_particulars_of_a_valuable_Sugar_Estate_-_known_as_Clarke%27s_Court,_in_the_Island_of_Grenada,_containing_770_acres_or_thereabouts,_together_with_the_fixtures,_machinery,_and_live_and_dead_stock_LOC_2016586624-1.jpg']],
            ['year' => '1886', 'title' => 'Steam power', 'text' => 'The oldest of the steam engines still on the site date from as far back as 1886. Visitors see them on the tour.', 'source' => ['label' => 'Factory tour, clarkescourtrum.com (archived 2006)', 'url' => 'https://web.archive.org/web/20091119045919/http://www.clarkescourtrum.com/factorytour.aspx']],
            ['year' => '1937', 'title' => 'The distillery opens', 'text' => 'Rum production begins at Woodlands. The factory, also home to the Grenada Sugar Factory, becomes the largest distillery in Grenada.', 'source' => ['label' => 'Our story, clarkescourtrum.com (archived 2014)', 'url' => 'https://web.archive.org/web/20141127132144/http://www.clarkescourtrum.com/about-us']],
            ['year' => '2010', 'title' => '#37 is launched', 'text' => "A double-matured golden rum named for the founding year, launched at Nick's Barrel House, the distillery's visitor centre.", 'source' => ['label' => 'Company news, April 2010 (archived)', 'url' => 'https://web.archive.org/web/20110620204239/http://www.clarkescourtrum.com/news/2010/37-launched-21-04-10.html']],
            ['year' => '2015', 'title' => 'Black Gold', 'text' => 'A premium rum infused with Grenada nutmeg joins the range.', 'source' => ['label' => 'Black Gold launch, company news (archived)', 'url' => 'https://web.archive.org/web/20180602032601/http://www.clarkescourtrum.com/news/article/-black-gold-launch']],
            ['year' => '2017', 'title' => 'Food-safety certified', 'text' => 'Grenada Distillers is certified to the ISO 22000 food-safety management standard, and re-certified in 2020.', 'source' => ['label' => 'ISO re-certification, company news, July 2020 (archived)', 'url' => 'https://web.archive.org/web/20200927081423/http://www.clarkescourtrum.com/news/article/-grenada-distillers-limited-announces-recertification-under-the-international-organization-for-standards-iso-']],
            ['year' => '2020', 'title' => 'Distillery of the Year', 'text' => 'Grenada Distillers is named Distillery of the Year (Gold) at the World Spirits Award in Austria, a title the company reported again in 2021.', 'source' => ['label' => 'Company news, April 2020 (archived)', 'url' => 'https://web.archive.org/web/20200803233503/http://www.clarkescourtrum.com/news/article/-distillery-of-the-year-gold-2020']],
        ],
        'gallery' => [
            ['photo' => 'mill-1950s', 'alt' => 'The Woodlands mill and chimney in the 1950s, behind a field of cane', 'caption' => 'The new mill in the 1950s.'],
            ['photo' => 'cane-drop', 'alt' => 'Cut sugar cane dropping from the hoist into the mill', 'caption' => 'Cane arriving at the mill, from the 2002 website.'],
            ['photo' => 'mill-today', 'alt' => 'The distillery buildings and chimney today', 'caption' => 'The factory at Woodlands.'],
            ['photo' => 'mill-old', 'alt' => 'An engraving of a stone windmill on a sugar estate, with palm trees', 'caption' => 'The old sugar mill, dating back to the 18th century.'],
        ],
    ],

    // Old clarkescourtrum.com addresses => new paths (from the Wayback Machine index).
    'legacy_redirects' => [
        'products' => '/rums',
        'products/aged' => '/rums#aged',
        'products/dark' => '/rums#aged',
        'products/light' => '/rums#white',
        'products/flavored' => '/rums#flavoured',
        'products/specialty' => '/rums#aged',
        'products/aged/clarke-s-court-grog-rum' => '/rums/old-grog',
        'products/aged/clarke-s-court-old-grog-extra-old-rum' => '/rums/old-grog-extra-old',
        'products/specialty/clarke-s-court-37' => '/rums/number-37',
        'products/specialty/black-gold' => '/rums/black-gold',
        'products/dark/clarke-s-court-special-dark-rum' => '/rums/special-dark',
        'products/dark/camerhogne-spice-liqueur' => '/rums/camerhogne',
        'products/light/clarke-s-court-pure-white-rum' => '/rums/pure-white',
        'products/light/clarke-s-court-superior-light-rum' => '/rums/superior-light',
        'products/flavored/clarke-s-court-lemon' => '/rums/rum-lemon',
        'products/flavored/clarke-s-court-sorrel' => '/rums/sorrel',
        'products/flavored/clarke-s-court-passion-fruit' => '/rums/passion-fruit',
        'products/flavored/clarke-s-court-rhythm-coconut-rum' => '/rums/rhythm-coconut',
        'products/flavored/clarke-s-court-mojito' => '/rums/mojito',
        'products/oldgrog.html' => '/rums/old-grog',
        'products/37.html' => '/rums/number-37',
        'products/purewhite.html' => '/rums/pure-white',
        'products/specialdark.html' => '/rums/special-dark',
        'products/superiorlight.html' => '/rums/superior-light',
        'products/rumlemon.html' => '/rums/rum-lemon',
        'products/rumsorrel.html' => '/rums/sorrel',
        'products/camerhogneliqueur.html' => '/rums/camerhogne',
        'about-us' => '/heritage',
        'aboutus' => '/heritage',
        'aboutus/index.html' => '/heritage',
        'history.aspx' => '/heritage',
        'effect/history.html' => '/heritage',
        'effect/morehistory.htm' => '/heritage',
        'hospitality.htm' => '/tours',
        'production.htm' => '/heritage',
        'contact_distributors.htm' => '/trade',
        'factorytour.aspx' => '/tours',
        'nick-s-barrel-house' => '/tours',
        'distributors' => '/trade',
        'distributors.aspx' => '/trade',
        'distributors/index.html' => '/trade',
        'contact.aspx' => '/contact',
        'product' => '/rums',
        'home.html' => '/',
    ],

    // Photo sizes (originals) for <x-photo>; files are public/img/{key}-{480,960,1920}.webp.
    'photos' => [
        'hero' => ['w' => 1400, 'h' => 489, 'position' => '70% center'],
        'range' => ['w' => 1400, 'h' => 489, 'position' => '85% center'],
        'casks' => ['w' => 1920, 'h' => 1280],
        'still' => ['w' => 1920, 'h' => 1280],
        'engine' => ['w' => 1920, 'h' => 1280],
        'cane' => ['w' => 1920, 'h' => 1440],
        'bay' => ['w' => 1920, 'h' => 1440, 'position' => 'center 60%'],
        'nutmeg' => ['w' => 1920, 'h' => 1200],
        'estate-sale' => ['w' => 1920, 'h' => 2981, 'position' => 'center 20%'],
        'mill-old' => ['w' => 246, 'h' => 189],
        'mill-1950s' => ['w' => 298, 'h' => 190],
        'mill-today' => ['w' => 340, 'h' => 190],
        'cane-drop' => ['w' => 558, 'h' => 837],
        'launch' => ['w' => 600, 'h' => 400],
        'bottle-37' => ['w' => 158, 'h' => 363],
        'bottle-camerhogne' => ['w' => 600, 'h' => 600],
        'bottle-mojito' => ['w' => 600, 'h' => 600],
        'bottle-old-grog-extra-old' => ['w' => 600, 'h' => 600],
        'bottle-old-grog' => ['w' => 600, 'h' => 600],
        'bottle-passion-fruit' => ['w' => 600, 'h' => 600],
        'bottle-pure-white' => ['w' => 600, 'h' => 600],
        'bottle-rhythm-coconut' => ['w' => 600, 'h' => 600],
        'bottle-rum-lemon' => ['w' => 600, 'h' => 600],
        'bottle-sorrel' => ['w' => 600, 'h' => 600],
        'bottle-special-dark' => ['w' => 600, 'h' => 600],
        'bottle-superior-light' => ['w' => 600, 'h' => 600],
    ],
];
