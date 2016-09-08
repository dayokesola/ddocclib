<?php

namespace com\ddocc\base\service;

use com\ddocc\base\utility\Connect;
use com\ddocc\base\entity\Country;
use com\ddocc\base\entity\Region;
use com\ddocc\base\entity\Locale;

class LocationService {

    public static function ListCountries() {
        $sql = "SELECT country.tab_ent AS country_id, country.tab_text AS country_name
FROM net_text country WHERE country.tab_id = 4 order by country.tab_text";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $ds = $cn->Select();
        $items = array();
        if ($cn->num_rows > 0) {
            foreach ($ds as $dr) {
                $item = new Country();
                $item->Set($dr);
                $items[$item->country_id] = $item;
            }
        }
        return $items;
    }

    public static function ListRegions() {
        $sql = "SELECT region.tab_ent AS region_id, region.tab_text AS region_name,
region.var2 AS region_code, country.tab_ent AS country_id, country.tab_text AS country_name, country.var2 AS country_code
FROM net_text region LEFT JOIN
net_text country ON country.tab_id = 4 AND region.var1 = country.tab_ent
WHERE region.tab_id = 5 ORDER BY region.tab_text";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $ds = $cn->Select();
        $items = array();
        if ($cn->num_rows > 0) {
            foreach ($ds as $dr) {
                $item = new Region();
                $item->Set($dr);
                $items[$item->region_id] = $item;
            }
        }
        return $items;
    }

    public static function ListLocales() {
        $sql = "SELECT locale.tab_ent AS locale_id, locale.tab_text AS locale_name, locale.var2 AS locale_code,
region.tab_ent AS region_id, region.tab_text AS region_name,region.var2 AS region_code, 
country.tab_ent AS country_id, country.tab_text AS country_name, country.var2 AS country_code
FROM net_text locale 
LEFT JOIN net_text region ON region.tab_id = 5 AND  locale.var1 = region.tab_ent  
LEFT JOIN net_text country ON country.tab_id = 4 AND region.var1 = country.tab_ent
WHERE locale.tab_id = 6 
ORDER BY country.tab_text, region.tab_text, locale.tab_text";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $ds = $cn->Select();
        $items = array();
        if ($cn->num_rows > 0) {
            foreach ($ds as $dr) {
                $item = new Locale();
                $item->Set($dr);
                $items[$item->locale_id] = $item;
            }
        }
        return $items;
    }

}
