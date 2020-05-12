<?php

    include 'config.php';

    try {
        $db = new PDO("mysql:host=$servername;dbname=customerDB", $username, $password);
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

    $company_id = $_REQUEST["companyID"];
    $branch_id = $_REQUEST["branchID"];

    if ($company_id != "") {
        
        // select the branches name based on the company_id
        $sql_branches_name = "SELECT `branch_id`,`branch_name` FROM `company_details` WHERE company_id = '$company_id'";

        $branch = query($db,$sql_branches_name);

        echo "<option value=''>Select Company</option>";
        foreach ($branch as $key => $value) {    
            $branch_name = $value['branch_name'];
            $branch_id = $value['branch_id'];
            echo "<option value='$branch_id'>$branch_name</option>";
        }
    }


    if ($branch_id != "") {

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
        var_dump($Street);
        echo "<br>";
        echo $City;
        echo "<br>";
        echo $postcode."".$State;
        echo "<br>";
        echo $country;
        echo "<br>";    
    }


?>