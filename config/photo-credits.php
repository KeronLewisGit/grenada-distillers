<?php

// Every photograph on the site. Company photos are Grenada Distillers' own, recovered from the
// archived clarkescourtrum.com (Wayback Machine) for this proposal; the rest are Wikimedia Commons,
// with the attribution each licence requires (metadata read October 2026).
// 'used_for' flags the generic Commons photos that are NOT of the Woodlands distillery.
$wb = 'https://web.archive.org/web/';
$company = "Grenada Distillers' own photo (archived clarkescourtrum.com), used for this proposal";

return [
    'hero' => ['title' => "Clarke's Court rums on the sand", 'author' => 'Grenada Distillers Ltd', 'license' => $company, 'license_url' => null, 'source' => $wb.'20150219155155/http://www.clarkescourtrum.com/images/slides/slide3.jpg'],
    'range' => ['title' => "Clarke's Court flavoured and white rums by the sea", 'author' => 'Grenada Distillers Ltd', 'license' => $company, 'license_url' => null, 'source' => $wb.'2015/http://www.clarkescourtrum.com/images/slides/slide1.jpg'],
    'bottle-pure-white' => ['title' => 'Bottle photographs of the range (all twelve bottles)', 'author' => 'Grenada Distillers Ltd', 'license' => $company, 'license_url' => null, 'source' => $wb.'20141127132400/http://www.clarkescourtrum.com/products/light/clarke-s-court-pure-white-rum'],
    'cane-drop' => ['title' => 'Cane arriving at the mill', 'author' => 'Grenada Sugar Factory Ltd / Grenada Distillers Ltd', 'license' => $company, 'license_url' => null, 'source' => $wb.'20021215055944/http://www.clarkescourtrum.com/production.htm'],
    'mill-old' => ['title' => 'The old sugar mill, 18th century', 'author' => 'Grenada Distillers Ltd (archive)', 'license' => $company, 'license_url' => null, 'source' => $wb.'20080510184609/http://www.clarkescourtrum.com/history.aspx'],
    'mill-1950s' => ['title' => 'The new mill in the 1950s', 'author' => 'Grenada Distillers Ltd (archive)', 'license' => $company, 'license_url' => null, 'source' => $wb.'20141127132144/http://www.clarkescourtrum.com/about-us'],
    'mill-today' => ['title' => 'The factory at Woodlands', 'author' => 'Grenada Distillers Ltd', 'license' => $company, 'license_url' => null, 'source' => $wb.'20141127132144/http://www.clarkescourtrum.com/about-us'],
    'launch' => ['title' => 'Launch of Black Gold at the distillery, 2015', 'author' => 'Grenada Distillers Ltd', 'license' => $company, 'license_url' => null, 'source' => $wb.'20180602032601/http://www.clarkescourtrum.com/news/article/-black-gold-launch'],
    'bay' => ['title' => 'Sunset Burn In Woburn (Clarke\'s Court Bay, lower Woburn)', 'author' => 'Diane Holmes', 'license' => 'CC BY 3.0', 'license_url' => 'https://creativecommons.org/licenses/by/3.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Sunset_Burn_In_Woburn_(148318801).jpeg'],
    'estate-sale' => ['title' => "Grenada, particulars of a valuable sugar estate known as Clarke's Court, 1877", 'author' => 'Hards, Vaughan & Jenkinson (Library of Congress)', 'license' => 'Public domain', 'license_url' => null, 'source' => 'https://commons.wikimedia.org/wiki/File:Grenada,_particulars_of_a_valuable_Sugar_Estate_-_known_as_Clarke%27s_Court,_in_the_Island_of_Grenada,_containing_770_acres_or_thereabouts,_together_with_the_fixtures,_machinery,_and_live_and_dead_stock_LOC_2016586624-1.jpg'],
    'cane' => ['title' => 'Sugar cane in Grenada', 'author' => 'georama', 'license' => 'CC BY 3.0', 'license_url' => 'https://creativecommons.org/licenses/by/3.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Sugar_cane_-_panoramio.jpg'],
    'nutmeg' => ['title' => 'Nutmeg drying at a Grenada co-op', 'author' => 'Paul Harrison', 'license' => 'CC BY-SA 4.0', 'license_url' => 'https://creativecommons.org/licenses/by-sa/4.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Nutmeg_Drying_at_a_Grenada_Co-op.jpg', 'used_for' => 'Black Gold, until the distillery supplies a bottle photo'],
    'casks' => ['title' => 'Foursquare Rum Distillery barrel warehouse', 'author' => 'Unknown author', 'license' => 'CC BY 2.5', 'license_url' => 'https://creativecommons.org/licenses/by/2.5', 'source' => 'https://commons.wikimedia.org/wiki/File:Foursquare_Rum_Distillery_Barrel_Warehouse.jpg', 'used_for' => 'a stand-in: a warehouse in Barbados, not Woodlands'],
    'still' => ['title' => 'Column still from a distillery', 'author' => 'Yukonmanner', 'license' => 'CC BY-SA 4.0', 'license_url' => 'https://creativecommons.org/licenses/by-sa/4.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Column_still_from_a_distillery.jpg', 'used_for' => 'a stand-in: not the Woodlands still'],
    'engine' => ['title' => 'Sugar mill steam engine', 'author' => 'Bill Abbott', 'license' => 'CC BY-SA 2.0', 'license_url' => 'https://creativecommons.org/licenses/by-sa/2.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Sugar_Mill_steam_engine_DSC_0825_(48646909982).jpg', 'used_for' => 'a stand-in: not one of the Woodlands engines'],
];
