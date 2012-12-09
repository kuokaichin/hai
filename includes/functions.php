<?php

    /***********************************************************************
     * functions.php
     *
     * Computer Science 50
     *
     * Helper functions.
     **********************************************************************/

    require_once("constants.php");

    /**
     * Apologizes to user with message.
     */
    function apologize($message)
    {
        render("apology.php", array("message" => $message));
        exit;
    }

    /**
     * Facilitates debugging by dumping contents of variable
     * to browser.
     */
    function dump($variable)
    {
        require("../templates/dump.php");
        exit;
    }

    /**
     * Logs out current user, if any.  Based on Example #1 at
     * http://us.php.net/manual/en/function.session-destroy.php.
     */
    function logout()
    {
        // unset any session variables
        $_SESSION = array();

        // expire cookie
        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 42000);
        }

        // destroy session
        session_destroy();
    }
    
    /**
     * adds new tags and ids into the tags table.
     */
    function insert_categories($categories_all)
    {
        // build query
        $query = "INSERT INTO tags (tag_id, tag_name) VALUES ";
        foreach ($categories_all as $tag)
        {
            // html_entity_decode fixes ampersands, apostrophes for table
            $query .= "('" . mres($tag[1]) . "', '" . mres(html_entity_decode($tag[2], ENT_QUOTES)) . "'), ";
        }
        $query = substr($query, 0, strlen($query) - 2);
        query($query);
    }
    
    // necessary so that apostrophes in org. names don't truncate string, other problems
    // from http://stackoverflow.com/questions/1162491/alternative-to-mysql-real-escape-string-without-connecting-to-db
    function mres($value)
    {
        return strtr($value, array( "\x00" => '\x00', "\n" => '\n', "\r" => '\r', '\\' => '\\\\', "'" => "\'", '"' => '\"', "\x1a" => '\x1a' ));
    }
    
    /**
     * Returns an array of IDs of activities that were hits in the search
     */
    function search($search_value, $filter)
    {
        // array to be populated with search results
        $results = array();
        // search name, description, and tags all at once
        if ($filter === "all")
        {
            // pull IDs of activities where the name or description have the search value
            $query1 = "SELECT id FROM activities WHERE name LIKE '%" . $search_value . "%' OR description LIKE '%" . $search_value  ."%' ";
            $hits = query($query1);
            foreach ($hits as $hit)
            {
                $results[$hit['id']] = $hit;
            }
            // query for tags
            $query_tags = query("SELECT tag_id FROM tags WHERE tag_name LIKE '%" . $search_value . "%' ");
            if (!empty($query_tags))
            {
                $query2 = "SELECT activity_id FROM activities_tags WHERE ";
                foreach ($query_tags as $tag)
                {         
                    $query2 .= "tag_id=$tag[tag_id] OR ";
                }
                $query2 = substr($query2, 0 , strlen($query2) - 4);            
                $hits2 = query($query2);
                foreach ($hits2 as $hit)
                {
                    $results[$hit['activity_id']] = $hit;
                }
            }
        }
        // only search tags for value
        else if ($filter === "tags")
        {
            $query_tags = query("SELECT tag_id FROM tags WHERE tag_name LIKE '%" . $search_value . "%' ");
            if (!empty($query_tags))
            {
                $query2 = "SELECT activity_id FROM activities_tags WHERE ";
                foreach ($query_tags as $tag)
                {         
                    $query2 .= "tag_id=$tag[tag_id] OR ";
                }
                $query2 = substr($query2, 0 , strlen($query2) - 4);            
                $hits2 = query($query2);
                foreach ($hits2 as $hit)
                {
                    $results[$hit['activity_id']] = $hit;
                }
            }
        }
        // only search names or descriptions if those are the filters chosen
        else
        {
            $query = "SELECT id FROM activities WHERE $filter LIKE '%" . $search_value . "%'";
            $hits = query($query);
            foreach ($hits as $hit)
            {
                $results[$hit['id']] = $hit;
            }
        }
        return $results;
    }

    /**
     * Returns an array of detailed results given a single ID for one activity
     */    
    function lookup_detailed($activity_id)
    {
        $data1 = query("SELECT name, description, email, website, size, members FROM activities WHERE id = $activity_id");
        $data2 = query("SELECT ROUND(AVG(satisfaction),2) as satisfaction, ROUND(AVG(time),2) as time, ROUND(AVG(organization),2) as organization, ROUND(AVG(selectiveness),2) as selectiveness, ROUND(AVG(friendliness),2) as friendliness, ROUND(AVG(learning_impact),2) as learning_impact FROM ratings_all WHERE id = $activity_id");
        // since all ratings are submitted together, one of them being empty means that there are no ratings for any of the others
        if (empty($data2[0]['satisfaction']))
        {
            $data2[0]['satisfaction'] = "No ratings so far";
            $data2[0]['time'] = "No ratings so far";
            $data2[0]['organization'] = "No ratings so far";
            $data2[0]['selectiveness'] = "No ratings so far";
            $data2[0]['friendliness'] = "No ratings so far";
            $data2[0]['learning_impact'] = "No ratings so far";            
        }
        $tags = query("SELECT tag_id FROM activities_tags WHERE activity_id = $activity_id");
        $query ="SELECT tag_name FROM tags WHERE ";
        foreach ($tags as $tag)
        {
            
            $query .= 'tag_id=' . $tag['tag_id'] . ' OR ';
        }
        $query = substr($query, 0, strlen($query) - 4);
        $tags_names = query($query);
        $data3 = "";
        foreach ($tags_names as $name)
        {
            $data3 .= $name['tag_name'] . ', ';
        }
        $data3 = substr($data3, 0 , strlen($data3) - 2);
        
        
        // return activities' info as an associative array        
        return array(
            'name' => $data1[0]['name'],
            'description' => $data1[0]['description'],
            'email' => $data1[0]['email'],
            'website' => $data1[0]['website'],
            'size' => $data1[0]['size'],
            'members' => $data1[0]['members'],
            'satisfaction' => $data2[0]['satisfaction'],
            'time' => $data2[0]['time'],
            'organization' => $data2[0]['organization'],
            'selectiveness' => $data2[0]['selectiveness'],
            'friendliness' => $data2[0]['friendliness'],
            'learning_impact' => $data2[0]['learning_impact'],
            'tags' => $data3
        );   
    }
    
    /**
     * Returns an array of quick results given an array of IDs representing search hits
     */    
    function lookup_quick($activity_id)
    {
        $data1 = query("SELECT name, description FROM activities WHERE id = $activity_id");
        $data2 = query("SELECT ROUND(AVG(satisfaction),2) as satisfaction FROM ratings_all WHERE id = $activity_id");
        if (empty($data2[0]['satisfaction']))
        {
            $data2[0]['satisfaction'] = "No ratings so far"; 
        }
        $tags = query("SELECT tag_id FROM activities_tags WHERE activity_id = $activity_id");
        $query ="SELECT tag_name FROM tags WHERE ";
        foreach ($tags as $tag)
        {
            
            $query .= 'tag_id=' . $tag['tag_id'] . ' OR ';
        }
        $query = substr($query, 0, strlen($query) - 4);
        $tags_names = query($query);
        $data3 = "";
        foreach ($tags_names as $name)
        {
            $data3 .= $name['tag_name'] . ', ';
        }
        $data3 = substr($data3, 0 , strlen($data3) - 2);
        
        
        // return activity's info as an associative array
        
        return array(
            'name' => $data1[0]['name'],
            'id' => $activity_id,
            'description' => $data1[0]['description'],
            'satisfaction' => $data2[0]['satisfaction'],
            'tags' => $data3
        );   
    }
    /**
     * Gets all the comments for the activity identified by a single ID
     */
    function get_comments($activity_id)
    {
        $comments = query("SELECT comment, upvotes, email FROM ratings_all WHERE id = $activity_id ORDER BY upvotes DESC");
        return $comments;
    }
    
    /**
     * Executes SQL statement, possibly with parameters, returning
     * an array of all rows in result set or false on (non-fatal) error.
     */
    function query(/* $sql [, ... ] */)
    {
        // SQL statement
        $sql = func_get_arg(0);

        // parameters, if any
        $parameters = array_slice(func_get_args(), 1);

        // try to connect to database
        static $handle;
        if (!isset($handle))
        {
            try
            {
                // connect to database
                $handle = new PDO("mysql:dbname=" . DATABASE . ";host=" . SERVER, USERNAME, PASSWORD);

                // ensure that PDO::prepare returns false when passed invalid SQL
                $handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            }
            catch (Exception $e)
            {
                // trigger (big, orange) error
                trigger_error($e->getMessage(), E_USER_ERROR);
                exit;
            }
        }

        // prepare SQL statement
        $statement = $handle->prepare($sql);
        if ($statement === false)
        {
            // trigger (big, orange) error
            $errorInfo = $handle->errorInfo();
            trigger_error($errorInfo[2], E_USER_ERROR);
            exit;
        }

        // execute SQL statement
        $results = $statement->execute($parameters);

        // return result set's rows, if any
        if ($results !== false)
        {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

    /**
     * Redirects user to destination, which can be
     * a URL or a relative path on the local host.
     *
     * Because this function outputs an HTTP header, it
     * must be called before caller outputs any HTML.
     */
    function redirect($destination)
    {
        // handle URL
        if (preg_match("/^https?:\/\//", $destination))
        {
            header("Location: " . $destination);
        }

        // handle absolute path
        else if (preg_match("/^\//", $destination))
        {
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            header("Location: $protocol://$host$destination");
        }

        // handle relative path
        else
        {
            // adapted from http://www.php.net/header
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            header("Location: $protocol://$host$path/$destination");
        }

        // exit immediately since we're redirecting anyway
        exit;
    }

    /**
     * Renders template, passing in values.
     */
    function render($template, $values = array())
    {
        // if template exists, render it
        if (file_exists("../templates/$template"))
        {
            // extract variables into local scope
            extract($values);

            // render header
            require("../templates/header.php");

            // render template
            require("../templates/$template");

            // render footer
            require("../templates/footer.php");
        }

        // else err
        else
        {
            trigger_error("Invalid template: $template", E_USER_ERROR);
        }
    }

?>
