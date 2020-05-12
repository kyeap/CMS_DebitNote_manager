<?php

    include 'config.php'

    try {
        $db = new PDO("mysql:host=$servername;dbname=u15572p11364_sooann", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully"; 
        }

    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }

    function query($db,$sql){
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $search_result_array =  $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $search_result_array;
        }
        catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            }
    }
    
    $branch_id = intval($_REQUEST["id"]);

    $sql_address = "SELECT `street`,`city`,`postcode`,`state`,`country` FROM `company_details` WHERE branch_id = '$branch_id'";

    $address = query($db,$sql_address);

    foreach ($address as $result_number => $array) { 

        $Street = $array["street"];
        $City = $array["city"];
        $postcode = $array["postcode"];        
        $State = $array["state"];
        $country = $array["country"];

    }

    echo "<br>";
    echo $Street;
    echo "<br>";
    echo $City;
    echo "<br>";
    echo $postcode;
    echo "&nbsp";
    echo $State;
    echo "<br>";
    echo $country;
    echo "<br>";

    }

?>