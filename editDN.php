<script>
    function submitNotice_company_details() {
        alert("Congratulations you have updated the company details! ;)");
    }

    function submitNotice_db_change() {
        alert("Congratulations you have updated the debit note details! ;)");
    }

    function sum_amount() {
        console.log("loop through the amount");

        var arr = document.getElementsByName("amountClass[]");
        var sum = 0;
        console.log(arr);
        for(i=0;i<arr.length;i++) {
            console.log(arr[i].value);
            sum += parseFloat(arr[i].value);
        }
        
        console.log(sum);
        document.getElementById("totalSum").value = sum;
    }
</script>

<?php 

if ($_SESSION['uname'] != NULL and $_SESSION['auth']=1) {


    $id_branch_dn = $_GET['id'];
    include 'config.php';

    //get the branch name to get the company information
    $sql_branch_dn = "SELECT branch_id,debit_note_no,issueDate,renewalDate,endDate,totalSum,amount_word FROM key_branch_debitNoteNo WHERE id_branch_dn = $id_branch_dn";

    $branch_dn = query($db,$sql_branch_dn);

    foreach ($branch_dn as $result_number => $array) { 

        $branch_id = $array["branch_id"];
        $branch = $array["branch"];
        $debitNoteNo = $array["debit_note_no"];
        $issueDate = $array["issueDate"];
        $renewalDate = $array["renewalDate"];
        $endDate = $array["endDate"];
        $totalSum = $array["totalSum"];
        $amount_word = $array["amount_word"];
    }

    //get company information
    $sql_company_details = "SELECT `company_id`,`branch_name`,`street`,`city`,`postcode`,`state`,`country` FROM `company_details` WHERE branch_id = '$branch_id'";

    $company_details = query($db,$sql_company_details);

    foreach ($company_details as $result_number => $array) { 

        $company_id = $array["company_id"]; 
        $branch = $array["branch_name"];
        $Street = $array["street"];
        $City = $array["city"];
        $postcode = $array["postcode"];        
        $State = $array["state"];
        $country = $array["country"];
    }

    //get company name 
    $sql_company_name = "SELECT `company_name` FROM `company_name_DB` WHERE company_id = '$company_id'";
    $company_name = query($db,$sql_company_name);

    foreach ($company_name as $result_number => $array) { 

        $companyName = $array["company_name"];
    }

    //use debit note No. to get the reference number (which can be in an array - when more than one reference)
    $sql_ref_dn = "SELECT `ref`,`class`,`misc`,`amount` FROM `key_dn_ref` WHERE id_branch_dn = '$id_branch_dn'";

    $ref_dn_array = query($db,$sql_ref_dn);

    $ref_array = array();
    $class_array = array();
    $misc_array = array();
    $amount_array = array();

    foreach ($ref_dn_array as $key => $array){
        array_push($class_array,$array["class"]);
        array_push($ref_array,$array["ref"]);
        array_push($misc_array,$array["misc"]);
        array_push($amount_array,$array["amount"]);
    }

    $sql_select_class = "SELECT class from class";
    $sql_select_class = query ($db,$sql_select_class);

    ?>
        <div id="class_containter_debitNote" class="flex-container">
            <div class="container left">
                <form action="" method="post" >
                    <div class="containerElement"> <input type="text" name="company_name"  value= "<?php echo $companyName ?>"> </div>
                    <div class="containerElement"> <input type="text" name="company_branch"  value= "<?php echo $branch ?>"> </div>
                    <div class="containerElement"> <input type="text" name="add_Street"  value= "<?php echo $Street ?>"> </div>
                    <div class="containerElement"> <input type="text" name="add_City"  value= "<?php echo $City ?>"> </div>
                    <div class="containerElement"> <input type="number" step="0.01" name="add_postcode"  value= "<?php echo $postcode ?>"> <input type="text" name="add_State"  value="<?php echo $State ?>"> </div>
                    <div class="containerElement"> <input type="text" name="add_country"  value= " <?php echo $country ?>"> </div>
                <input type="submit" onclick="submitNotice_company_details();" name="submit_company_details_change" value="Update Company Details">
            </div>
    </form>

            <div class="container mid"></div>
            <div class="container right">
    <form action="" method="post" >
                <div class="containerElement"> Debit Note </div>
                <div class="containerElement"> <input type="text" name="debitNoteNo"  value= "<?php echo $debitNoteNo ?>" > </div>
                <div class="containerElement"> <input type="date" name="issueDate"  value= "<?php echo $issueDate ?>"></div>
            </div>  

            <div class="container left title"> Date </div>
            <div class="container mid title"> Particulars </div>
            <div class="container right title"> Amount (RM) </div>  

            <div class="container left" >
                <div> <input type="date" name="renewalDate"  value= "<?php echo $renewalDate ?>"> </div>
                <div> to </div>
                <div> <input type="date" name="endDate"  value= "<?php echo $endDate ?>">  </div>
            </div>

            <?php
                for ($i=0;$i<sizeof($ref_array);$i++){ 
                    if ($i>=1) {
                        echo "<div class='container left'></div>";
                    }
                    ?>

                    <div class="container mid">
                        <label for="class">Choose a class:</label>
                        <select name="class[<?php $i ?>]">
                            <?php
                            $j = 0;
                            foreach ($sql_select_class as $result_number => $array) { 
                                $class = $array["class"];
                                if ($class == $class_array[$i]) {
                                    echo "<option value='$class' selected> $class </option>";
                                }else {
                                    echo "<option value='$class'> $class </option>";
                                }
                                $j++;
                            }?>
                        </select>
                        <div class="containerElement"> <input type="text" name="reference[<?php $i ?>]"  value="<?php echo $ref_array[$i] ?>"> </div>
                        <textarea class="containerElement" rows="5" name="misc[<?php $i ?>]" cols="30"> <?php echo $misc_array[$i] ?> </textarea>
                    </div>

                    <div class="container right"> <input type="number" step="0.01" name="amountClass[]"  value= "<?php echo $amount_array[$i] ?>" id="amountClass"> </div>  
            
            <?php    
                }
            ?> 

        <div class="flex-container">
            <div class="container left"></div>
            <div class="container mid">
                <div>Gross Premium </div>
                <div>(inclusive of 6% SST &  </div>
                <div>General Stamp Duty)</div>
            </div>
            <div class="container right"></div>
                
            <div class="container left"></div>
            <div class="container mid">Premium Due</div>
            <div class="container right sum">
                <input type="number" name="totalSum"  value="click to auto sum" id="totalSum" required>
                <button type="button" onclick="sum_amount()">Add'em up!</button>
            </div>

            <div class="container left"></div>
            <div class="container mid"> Will create sum automatically in Debit Note preview </div>
            <div class="container right"></div>

            <div class="container left"></div>
            <div class="container mid">
                <div>Remarks: </div>
                <div>Cheque or via Bank Giro payable to : </div>
                <div>ISECURE RISK MANAGEMENT</div>
                <div>Either bank in to CIMB NEW A/C NO : 8601022931 </div>
                <div>or via Great Eastern Credit Card Form</div>
            </div>
            <div class="container right"></div>

        </div>
        <input type="submit" onclick="submitNotice_db_change();" name="submit_db_change" value="Update Debit Note">
        <input type="button" onclick="addrow();" value="add row"> 
        <!-- ToDo: add new class!!! -->
    </form>

    <?php
        if($_POST['submit_company_details_change']=='Update Company Details') {

            // defining variables to be used in sql
            $companyName = $_POST["company_name"];
            $company_branch = $_POST["company_branch"];
            $add_Street = $_POST["add_Street"];
            $add_City = $_POST["add_City"];
            $add_postcode = $_POST["add_postcode"];        
            $add_State = $_POST["add_State"];
            $add_country = $_POST["add_country"];


            $sql_company_name= "UPDATE company_name_DB SET company_name = '$companyName' WHERE company_id='$company_id'";

            try {
                $db->exec($sql_company_name);
                echo "company name updated!";
            }
            catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                exit();
            }

            //insert values into various DB's
            $sql_company_details = "UPDATE company_details SET branch_name = '$company_branch', street= '$add_State',
            city = '$add_City', postcode = '$add_postcode', state = '$add_State', country = '$add_country' WHERE branch_id='$branch_id'"; 

            try {
                $db->exec($sql_company_details);
                echo "company details updated!";
            }
            catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                exit();
            }
        }

        if($_POST['submit_db_change']=='Update Debit Note') { 

            $debitNoteNo = $_POST["debitNoteNo"];
            $issueDate = $_POST["issueDate"];
            $renewalDate = $_POST["renewalDate"];
            $endDate = $_POST["endDate"];
            $reference = $_POST["reference"];
            $class = $_POST["class"];
            $amountClass = $_POST["amountClass"];
            $reference = $_POST["reference"];
            $misc = $_POST["misc"];
            $totalSum = $_POST["totalSum"];
            $amount_word = $_POST["amount_word"];

            //insert values into various DB's
            $sql_dn_details = "UPDATE key_branch_debitNoteNo SET debit_note_no = '$debitNoteNo', issueDate = '$issueDate', renewalDate= '$renewalDate',
            endDate = '$endDate', totalSum = '$totalSum' WHERE id_branch_dn='$id_branch_dn'"; 

            try {
                $db->exec($sql_dn_details);
                echo "debit note details updated!";
            }
            catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                exit();
            }

            for($i=1;$i<count($class);$i++)
            {
                $sql_key_dn_ref = "UPDATE key_dn_ref SET ref = '$reference[$i]', class = '$class[$i]', misc= '$misc[$i]', amount = '$amountClass[$i]' WHERE id='$branch_id'";
                echo $sql_key_dn_ref;
                try {
                    $db->exec($sql_key_dn_ref);
                    echo "debit note and reference details[$i] updated in debit note - reference key table <br>";
                }
                catch(PDOException $e) {
                echo "Connection failed for key table dn_ref [$i]: " . $e->getMessage()."<br>";
                exit();
                }
            }
        }
}
else {
    echo "You are not authorized to access this page.";
}
?>
