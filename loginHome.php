<?php
    
    if ($_SESSION['uname'] != NULL and $_SESSION['auth']=1) {
    }
    else {
        echo "Unauthorized access, please login to access!";
    }

    include 'config.php';
    $today = date("Y/m/d");
    $sql = "SELECT `id_branch_dn`,`branch_id`,`debit_note_no`,`endDate` FROM key_branch_debitNoteNo WHERE `endDate` >= curdate() ORDER BY `endDate` ASC LIMIT 10";
    $dn_2D_array = query($db,$sql);


    $debit_note_no_array = array();
    $endate_array = array();
    $id_branch_dn_array = array(); 
    $branch_id_ass_array = array();
    $branch_name_array = array();

    foreach ($dn_2D_array as $dns_array) {
            array_push($debit_note_no_array,$dns_array['debit_note_no']);
            array_push($endate_array,$dns_array['endDate']);
            array_push($id_branch_dn_array,$dns_array['id_branch_dn']);
            array_push($branch_id_ass_array,$dns_array['branch_id']);
    }

    $branch_id_array = array_values($branch_id_ass_array);
    
    //select branch name 
    $sql_branch_name = "SELECT `branch_name` FROM company_details WHERE branch_id IN (".implode(',',$branch_id_array).")";
    $branch_name_2D_array = query($db,$sql_branch_name);

    foreach ($branch_name_2D_array as $branch_names_array) {
            array_push($branch_name_array,$branch_names_array['branch_name']);
    }
    
    echo "<h1> Here are the upcoming renewals: </h1>";
    echo "<table>";
    echo "<tr>";
        echo "<th>View Debit Note</th>";
        echo "<th>Company/Branch</th>";
        echo "<th>Debit Note No.</th>";
        echo "<th>Renewal Date</th>";
    echo "</tr>";

    for ($i=0;$i<sizeof($dn_2D_array);$i++) {
        echo "<tr>";
        echo "<td>";
        echo "<a href='?page=private/dnPreview&id=$id_branch_dn_array[$i]'>Select</a>";
        echo "</td>";
        echo "<td>";
        echo $branch_name_array[$i];
        echo "</td>";
        echo "<td>";
        echo $debit_note_no_array[$i];
        echo "</td>";
        echo "<td>";
        echo $endate_array[$i];
        echo "</td>";
        echo "</tr>";

    }
    
    echo "</table>";
?>