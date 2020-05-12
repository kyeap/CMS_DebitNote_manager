
<h2>Modal Example</h2>

<!-- Trigger/Open The Modal -->
<button id="myBtn">Open Modal</button>

<form action="" method="post">
    <input type="text" required>
    <input type="text" name="debitNoteNo"  placeholder="Debit Note No." required>
    <input type="date" name="issueDate"  placeholder="Issue Date" required>
    <input type="submit">
</form>

<!-- The Modal -->
<div id="myModal" class="modal">





  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <form action="" method="post" >
        Please enter the Company details below: 
        <div class="modal_addCompany_input"> <input type="text" name="company_name"  placeholder="Company Name:"> </div>
        <div class="modal_addCompany_input"> <input type="text" name="company_branch"  placeholder="Name of branch"> </div>
        <div class="modal_addCompany_input"> <input type="text" name="add_Street"  placeholder="Address: Street"> </div>
        <div class="modal_addCompany_input"> <input type="text" name="add_City"  placeholder="Address: city/area"> </div>
        <div class="modal_addCompany_input"> <input type="number" name="add_postcode"  placeholder="postcode"> </div>
        <div class="modal_addCompany_input"> <input type="text" name="add_State"  placeholder="state"> </div>
        <div class="modal_addCompany_input"> <input type="text" name="add_country"  placeholder="Address: Country"> </div> 

        <div class="modal_submit"> <input type="submit" onclick="submitNotice();" name="newCompany"> </div>
    </form>
  </div>

</div>

<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
    modal.style.display = "block";
    }

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

<?php

    echo $_POST['newCompany'];

    if($_POST['newCompany']=='Submit') {

        $companyName = $_POST["company_name"];
        $company_branch = $_POST["company_branch"];
        $add_Street = $_POST["add_Street"];
        $add_City = $_POST["add_City"];
        $add_postcode = $_POST["add_postcode"];        
        $add_State = $_POST["add_State"];
        $add_country = $_POST["add_country"];

        include 'config.php';

        $sql_company_details = "insert into company_details (`name`, `branch_name`,`street`,`city`,`postcode`,`state`,`country`)
        values ('$companyName', '$company_branch', '$add_Street', '$add_City', '$add_postcode', '$add_State', '$add_country')";

        try {
            $db->exec($sql_company_details);
            echo "customer details entered <br>";
        }
        catch(PDOException $e) {
            $error = $e->getMessage();
            echo "Connection failed: " . $error;
            exit();
        }

    }

?>

