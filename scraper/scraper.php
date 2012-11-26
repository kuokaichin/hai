#!/usr/bin/env php
<?
    // constants
    require("constants.php");
 
    // connect to database
    mysql_connect(DB_HOST, DB_USER, DB_PASS);
    mysql_select_db(DB_NAME);
 
    // get start and end dates
    $sd = getdate();
    $ed = getdate(strtotime("+6 days", $sd[0]));
 
    // iterate over dates
    for ($date = $sd; $date[0] <= $ed[0]; $date = getdate(strtotime("+1 day", $date[0])))
    {
        // get today's date in M-D-YYYY format
        $njY= date("n-j-Y", $date[0]);
 
        // get today's date in YYYY-MM-DD format
        $Ymd = date("Y-m-d", $date[0]);
 
        // get today's month and day in (M)MDD format
        $nd = (int) date("nd", $date[0]);
 
        // determine which meals are avaialble; assume that Summer School 
        // (which has breakfast, lunch, and dinner on Sundays) starts no sooner
        // than 15 June and runs no later than 15 August
        if ($date["wday"] == 0 && ($nd < 615 || 815 < $nd))
            $meals = array("Brunch", "Dinner");
        else
            $meals = array("Breakfast", "Lunch", "Dinner");
 
        // get meals
        for ($i = 0, $n = count($meals); $i < $n; $i++)
        {
            // fetch meal's menu
            if (!($tidy = tidy_parse_file("http://www.foodpro.huds.harvard.edu/foodpro/menu_items.asp?date={$njY}&type=30&meal={$i}",
                                          array("numeric-entities" => true, "output-xhtml" => true))))
                continue;
 
            // convert menu to XHTML
            $tidy->cleanRepair();
            $xhtml = (string) $tidy;
 
            // parse XHTML
            $dom = simplexml_load_string($xhtml);
 
            // register XHTML namespace
            $dom->registerXPathNamespace("xhtml", "http://www.w3.org/1999/xhtml");
 
            // get menu's TRs
            $trs = $dom->xpath("//xhtml:form[@id='report_form']/xhtml:table/xhtml:tr");
 
            // get categories (and items therein)
            unset($category);
            foreach ($trs as $tr)
            {
                // remember category
                if ($tr["class"] == "category")
                    $category = trim((string) $tr->td);
 
                // skip leading category-less TRs
                else if (!isset($category))
                    continue;
 
                // associate item with current category
                else
                {
                    // get item
                    $a = $tr->td->div->span->a;
                    if (!($item = trim($a)))
                        continue;
 
                    // determine recipe
                    if (!preg_match("/recipe=(\d+)/", $a["href"], $matches))
                        continue;
                    $recipe = $matches[1];
 
                    // INSERT INTO into items
                    $sql = sprintf("INSERT IGNORE INTO items (recipe, item) VALUES('%s', '%s')",
                                   mysql_real_escape_string($recipe),
                                   mysql_real_escape_string($item));
                    mysql_query($sql);
 
                    // INSERT INTO legend
                    $a->registerXPathNamespace("xhtml", "http://www.w3.org/1999/xhtml");
                    foreach ($a->xpath("../../xhtml:img") as $img)
                    {
                        $sql = sprintf("INSERT IGNORE INTO legend (recipe, `key`) VALUES('%s', '%s')",
                                       mysql_real_escape_string($recipe),
                                       mysql_real_escape_string($img["alt"]));
                        mysql_query($sql);
                    }
 
                    // INSERT INTO menu
                    $sql = sprintf("INSERT INTO menu (date, meal, category, recipe) VALUES('%s', '%s', '%s', '%s')",
                                   mysql_real_escape_string($Ymd),
                                   mysql_real_escape_string($meals[$i]),
                                   mysql_real_escape_string($category),
                                   mysql_real_escape_string($recipe));
                    mysql_query($sql);
                }
            }
 
            // avoid blacklisting
            sleep(1);
        }
    }
 
?>