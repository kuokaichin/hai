<?php
    // configuration
    require("../includes/config.php");
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // check that all fields have proper inputs
        if (empty($_POST["username"]))
        {
            apologize("You must provide a username.");
        }
        else if (empty($_POST["password"]))
        {
            apologize("You must provide your password.");
        }
        else if ($_POST["password"] !== $_POST["confirmation"])
        {
            apologize("You must enter matching passwords.");
        }
        
        // insert new user
        if( false === query("INSERT INTO admin (username, hash) VALUES(?, ?)", $_POST["username"], crypt($_POST["password"])))
        {
            apologize("New user not created. Invalid username/password.");
        }
        $rows = query("SELECT LAST_INSERT_ID() AS id");
        $id = $rows[0]["id"];
        $_SESSION["id"] = $id;
        redirect("/");
    }
    else
    {
    // else render form
    render("register_form.php", ["title" => "Register"]);
    }
?>
