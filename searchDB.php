<?php
    if ($_SESSION['uname'] != NULL and $_SESSION['auth']=1) {
        include 'config.php';

?>

<form action="" method="post" >
    
    <?php
    $sql_get_branches = "SELECT `branch_id`,`branch_name` FROM company_details";
        
        try {
            $stmt = $db->prepare($sql_get_branches);
            $stmt->execute();
            //set the resulting array to associative
            $search_result_array =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            }
    ?>

    <label for="branches">Choose a branch:</label>
    <select id="branches" name="input_branch_name">
        <option value=""> Select </option> 
        <?php
            foreach ($search_result_array as $key => $value) {
                $branch_name = $value['branch_name'];
                $branch_id = $value['branch_id'];
                echo "<option value='$branch_id'> $branch_name </option>";
            }
        ?>
    </select>

    <input type="submit" name="submit_branch_search" value="submit">
</form>

<table>
    <tr>
        <th>Select</th>
        <th>Edit</th>
        <th>Debit Note No.</th>
        <th>Total Sum</th>
        <th>issue date</th>
        <th>Renewal Date</th> 
        <th>End Date</th>     
    </tr>

<?php
if($_POST['submit_branch_search']=='submit') {
    $branch_id = "";
    $branch_id = $_POST['input_branch_name'];

    //get information about the debit note (result can be more than one array)
    $sql_branch_dn = "SELECT id_branch_dn,debit_note_no,totalSum,issueDate,renewalDate,endDate FROM key_branch_debitNoteNo 
        WHERE branch_id = $branch_id";

    try {
        $stmt = $db->prepare($sql_branch_dn);
        $stmt->execute();
        $search_result_array =  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        }
    
    if ($search_result_array == NULL) {
        echo "No debit note for this branch yet, you need to work harder.";
    }
    foreach ($search_result_array as $result_number => $array) { 
        echo "<tr>";
        $value_array = array_values($search_result_array[$result_number]);
        foreach ($value_array as $key => $value) {

            //when the key is id
            if ($key==0) {
                echo "<td>";
                echo "<a href='?page=private/dnPreview&id=$value'>select</a>";
                echo "</td>";
                echo "<td>";
                echo "<a href='?page=private/editDN&id=$value'>Edit</a>";
                echo "</td>";
            } 
            //for the rest
            else {
                echo "<td>";
                echo $value;
                echo "</td>";
            }
        }
        echo "</tr>";
    }
} ?>


</table>

<?php
    }
    else {
        echo "You are not authorized to access this page. ";
    }
?>