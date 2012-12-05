<?php
    // configuration
    require("../includes/config.php");
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // check that all fields have proper inputs
        if (empty($_POST["symbol"]))
        {
            apologize("You must provide a stock symbol.");
        }
        else if (lookup($_POST["symbol"]) === false)
        {
            apologize("Stock not found.");
        }
            // get stock symbol and show its values
            $stock = lookup($_POST["symbol"]);
            render("/quote_result.php", ["title" => "Quote", "symbol" => $stock["symbol"], "name" => $stock["name"], "price" => $stock["price"]]);
    }
    else
    {
    // else render form
    render("search_form.php", ["title" => "Activities Search"]);
    }
?>
