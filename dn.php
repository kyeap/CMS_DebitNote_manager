<!-- Check if logged in -->
<?php
    if ($_SESSION['uname'] != NULL and $_SESSION['auth']=1) {
        
    include 'config.php';

    $sql_class = "SELECT class from class";
    $class_array = query ($db,$sql_class);

    $sql_company_name = "SELECT `company_name`,`company_id` FROM `company_name_DB` ";
    $company_name = query($db,$sql_company_name);

?>

<script>

    var i = 0;
    var div_container_left = [];
    var div_container_mid = [];
    var div_container_right = [];
    var div_container_element_1 = [];
    var div_container_element_2 = [];
    var div_container_element_3 = [];
    var input_class= [];
    var input_reference = [];
    var input_misc = [];   
    var new_class_container_start =[];
    var input_amount = [];

    function addrow() {
        i ++;

        // create the HTML elements
        div_container_left[i] = document.createElement("div");
        div_container_mid[i] = document.createElement("div");
        div_container_right[i] = document.createElement("div");
        div_container_element_1[i] = document.createElement("div");
        div_container_element_2[i] = document.createElement("div");
        div_container_element_3[i] = document.createElement("div");
        input_class[i] = document.createElement("select");
            <?php
                foreach ($class_array as $result_number => $array) { 
                    $class = $array["class"]; 
            ?>
                    input_class[i].options.add( new Option("<?php echo $class;?>"),"<?php echo $class; ?>");
                <?php }
            ?>
            
        input_reference[i] = document.createElement("input");
        input_misc[i] = document.createElement("textarea");
        input_amount[i] = document.createElement("input");

        // set the attributes
        div_container_left[i].className = "container left";
        div_container_mid[i].className = "container mid";
        div_container_right[i].className = "container right";
        div_container_element_1[i].className = "containerElement";
        div_container_element_2[i].className = "containerElement";
        div_container_element_3[i].className = "containerElement";
        input_class[i].name = "class[]";
        input_reference[i].type = "text";
        input_reference[i].name = "reference[]";
        input_reference[i].placeholder = "reference";
        input_misc[i].type = "text";
        input_misc[i].name = "misc[]";
        input_misc[i].placeholder = "misc (optional)";
        input_amount[i].type = "number";
        input_amount[i].step = "0.01";
        input_amount[i].name = "amountClass[]";
        input_amount[i].id = "amountClass";
        input_amount[i].placeholder = "class amount";


        // connect the nodes 
        new_class_container_start[i] = document.getElementById('class_containter_debitNote');
        new_class_container_start[i].appendChild(div_container_left[i]);
        new_class_container_start[i].appendChild(div_container_mid[i]);
            div_container_mid[i].appendChild(div_container_element_1[i]);
                div_container_element_1[i].appendChild(input_class[i]);
            div_container_mid[i].appendChild(div_container_element_2[i]);
                div_container_element_2[i].appendChild(input_reference[i]);
            div_container_mid[i].appendChild(div_container_element_3[i]);
                div_container_element_3[i].appendChild(input_misc[i]);
        new_class_container_start[i].appendChild(div_container_right[i]);
            div_container_right[i].appendChild(input_amount[i]);

    }

    function submitNotice() {
        alert("Congratulations! You have worked hard, now you can spend time with your sons. ;)");
    }

    function branch_exist() {
        alert("Error! This outlet already exist! Please use existing outlet!;)");
    }

    function please_select_a_company() {
        alert("Error! You need to select a company for the debit note!;)");
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

    function companyName(listindex) {   
        var xhttp;  
        if (listindex == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        }
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("company_branch").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "private/getcustomer.php?companyID="+listindex, true);
        xhttp.send();

    }

    function branchName(listindex) {   
        var xhttp;  
        if (listindex == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        }
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("branchAdd").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "private/getcustomer.php?branchID="+listindex, true);
        xhttp.send();

    }

    function addCompany () {
        modal.style.display = "block";
    }

</script>

<div class="DNLogo"> <img src="/img/logo.png" height="50" style="vertical-align:bottom">secure Risk Management </div>

    <!-- Trigger/Open The Modal -->
    <button id="myBtn" onclick="addCompany();" >Add New Company</button>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <form action="" method="post" >
                Please enter the Company details below: 
                <div class="modal_addCompany_input"> <input class="modal_input" type="text" name="company_name"  placeholder="Company Name:" value="<?php echo isset($_POST['company_name']) ? $_POST['company_name'] : '' ?>" required> </div>
                <div class="modal_addCompany_input"> <input class="modal_input" type="text" name="company_branch"  placeholder="Name of branch" value="<?php echo isset($_POST['company_branch']) ? $_POST['company_branch'] : '' ?>" required> </div>
                <div class="modal_addCompany_input"> <input class="modal_input" type="text" name="add_Street"  placeholder="Address: Street" value="<?php echo isset($_POST['add_Street']) ? $_POST['add_Street'] : '' ?>"required> </div>
                <div class="modal_addCompany_input"> <input class="modal_input" type="text" name="add_City"  placeholder="Address: city/area" value="<?php echo isset($_POST['add_City']) ? $_POST['add_City'] : '' ?>" required> </div>
                <div class="modal_addCompany_input"> <input class="modal_input" type="number" name="add_postcode"  placeholder="postcode" value="<?php echo isset($_POST['add_postcode']) ? $_POST['add_postcode'] : '' ?>" required> </div>
                <div class="modal_addCompany_input"> <input class="modal_input" type="text" name="add_State"  placeholder="state" value="<?php echo isset($_POST['add_State']) ? $_POST['add_State'] : '' ?>" required> </div>
                <div class="modal_addCompany_input"> <input class="modal_input" type="text" name="add_country"  placeholder="Address: Country" value="<?php echo isset($_POST['add_country']) ? $_POST['add_country'] : '' ?>" required> </div> 
                <div class="modal_submit"> <input type="submit" name="newCompany"> </div>
            </form>
        </div>
    </div>

<!-- Form to collect user input  -->
<form action="" method="post" >
    <div id="class_containter_debitNote" class="flex-container">
        <div class="container left">
            <div class="containerElement">
                <select name="company_name" onchange="javascript: companyName(this.options[this.selectedIndex].value);">
                    <option value="">Select company</option>
                <?php
                    foreach ($company_name as $key => $values) {
                        $c_name = $values['company_name'];
                        $c_id = $values['company_id'];
                        echo "<option value='$c_id'>$c_name</option>";
                    }
                ?>
                </select>
            </div>
            
            <div class="containerElement">
                <select name="company_branch" id="company_branch" onchange="javascript: branchName(this.options[this.selectedIndex].value);">
                    <option value="">Select company</option>
                </select>
            </div>

            <div class="containerElement" id="branchAdd">  </div>

        </div>
        <div class="container mid"></div>
        <div class="container right">
            <div class="containerElement"> Debit Note </div>
            <div class="containerElement"> <input type="text" name="debitNoteNo"  placeholder="Debit Note No." value="<?php echo isset($_POST['debitNoteNo']) ? $_POST['debitNoteNo'] : '' ?>" required> </div>
            <div class="containerElement"> <input type="date" name="issueDate"  placeholder="Issue Date" value="<?php echo isset($_POST['issueDate']) ? $_POST['issueDate'] : '' ?>" required></div>
        </div>  

        <div class="container left title"> Date </div>
        <div class="container mid title"> Particulars </div>
        <div class="container right title"> Amount (RM) </div>  

        <div class="container left" >
            <div> <input type="date" name="renewalDate"  placeholder="renewal date" value="<?php echo isset($_POST['renewalDate']) ? $_POST['renewalDate'] : '' ?>" required> </div>
            <div> to </div>
            <div> <input type="date" name="endDate"  placeholder="end date" value="<?php echo isset($_POST['endDate']) ? $_POST['endDate'] : '' ?>" required>  </div>
        </div>
        <div class="container mid">
            <label for="class">Choose a class:</label>
                <select name="class[0]">
                <?php
                foreach ($class_array as $result_number => $array) { 
                    $class = $array["class"];
                    echo "<option value='$class'> $class </option>";
                }?>
                </select>
            <div class="containerElement"> <input type="text" name="reference[0]"  placeholder="Reference:" value="<?php echo isset($_POST['reference[0]']) ? $_POST['reference[0]'] : '' ?>" required> </div>
            <textarea class="containerElement" rows="5" name="misc[0]" placeholder="misc (optional)" cols="30"></textarea>
        </div>
        <div class="container right"> <input type="number" step="0.01" name="amountClass[]"  placeholder="class amount:" id="amountClass" value="<?php echo isset($_POST['amountClass[]']) ? $_POST['amountClass[]'] : '' ?>" required></div>  
    </div>

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
            <input type="number" step="0.01" name="totalSum" placeholder="RM10,000 (make auto)" id="totalSum" required>
            <button type="button" onclick="sum_amount()">Add'em up!</button>
        </div>

        <div class="container left"></div>
        <div class="container mid"> Ringgit Malaysia : <input type="text" name="amount_word"  placeholder="This will automatically be generated when you preview the debit note." size="100"> </div>
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
    <input type="submit" onclick="submitNotice();" name="submit">
    <input type="button" onclick="addrow();" value="add row">
</form>


<script>

    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
    modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    }

</script>


<!-- Insert the user input to the database -->
<?php
    echo $_POST['submit'];
    
    if($_POST['newCompany']=='Submit') {
        $companyName = $_POST["company_name"];
        $company_branch = $_POST["company_branch"];
        $add_Street = $_POST["add_Street"];
        $add_City = $_POST["add_City"];
        $add_postcode = $_POST["add_postcode"];        
        $add_State = $_POST["add_State"];
        $add_country = $_POST["add_country"];

        //check if branch_name already exist, show error and exit if existing
        $sql_branch_exist = "SELECT * from company_details WHERE branch_name = '$company_branch'";
        $branch_exist = query($db,$sql_branch_exist);
        if (!empty($branch_exist)) {
            echo "the branch existed <br>";
            ?>
            <script> branch_exist(); </script>
            <?php exit();
        }

        //Check if company_name already exist
        $sql_check_exist = "SELECT company_name from company_name_DB WHERE company_name = '$companyName'";
        $exist = query($db,$sql_check_exist);
        var_dump($exist);
        if (empty($exist)) {
            echo "the company has not existed <br>";
            //Insert company name to company name DB
            $sql_company_name = "insert into company_name_DB (`company_name`) values ('$companyName')";
            insert($db,$sql_company_name);
            $sql_get_companyID = "SELECT `company_id`from company_name_DB WHERE company_name = '$companyName'";
            $company_id_array = query ($db,$sql_get_companyID);
            $company_id = $company_id_array[0]['company_id'];
        }
        else {
            echo "the company exisited, using exisiting credentials <br>";
            //use the exisiting credentials 
            $sql_get_companyID = "SELECT `company_id`from company_name_DB WHERE company_name = '$companyName'";
            $company_id_array = query ($db,$sql_get_companyID);
            $company_id = $company_id_array[0]['company_id'];
        }

        //insert branch details into company_details
        $sql_company_details = "insert into company_details (`company_id`, `branch_name`,`street`,`city`,`postcode`,`state`,`country`)
        values ('$company_id', '$company_branch', '$add_Street', '$add_City', '$add_postcode', '$add_State', '$add_country')";
        echo $sql_company_details;

        insert($db,$sql_company_details);

    }
    if($_POST['submit']=='Submit') {

        // defining variables to be used in sql
        $companyName = $_POST["company_name"];
        $branch_id = $_POST["company_branch"];
        $add_Street = $_POST["add_Street"];
        $add_City = $_POST["add_City"];
        $add_postcode = $_POST["add_postcode"];        
        $add_State = $_POST["add_State"];
        $add_country = $_POST["add_country"];
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

        if ($branch_id == NULL) {
            echo "<script type='text/javascript'>please_select_a_company();</script>";
            exit();
        }
        
        // insert the debit note general details into DB
        $sql_key_branch_debitNoteNo = "insert into key_branch_debitNoteNo (`branch_id`,`debit_note_no`,`issueDate`,`renewalDate`,`endDate`,`totalSum`,`amount_word`)
        values ('$branch_id', '$debitNoteNo', '$issueDate', '$renewalDate', '$endDate','$totalSum','$amount_word')";
        
        insert($db,$sql_key_branch_debitNoteNo);

        // get the id_branch_dn value to key into other tables 
        $get_id = "SELECT `id_branch_dn` FROM `key_branch_debitNoteNo` WHERE `branch_id`= '$branch_id'";
        
        $id_branch_dn_array = query($db,$get_id);
        $id_branch_dn = $id_branch_dn_array[0]['id_branch_dn'];
        

        $sql_key_dn_ref = "insert into key_dn_ref (`id_branch_dn`,`ref`,`class`, `misc`, `amount`)
        values ('$id_branch_dn','$reference[0]', '$class[0]', '$misc[0]', '$amountClass[0]')";
        
        insert($db,$sql_key_dn_ref);

    }

    for($i=1;$i<count($class);$i++)
    {
        $sql_key_dn_ref = "insert into key_dn_ref (`id_branch_dn`,`ref`,`class`,`misc`, `amount`)
        values ('$id_branch_dn','$reference[$i]','$class[$i]','$misc[$i]', '$amountClass[$i]')";

        insert($db,$sql_key_dn_ref);

    }

}
else {
    echo "You are not authorized to access this page.";
}
?>



