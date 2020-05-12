<script>

    // numtoWords function
    const arr = x => Array.from(x);
    const num = x => Number(x) || 0;
    const str = x => String(x);
    const isEmpty = xs => xs.length === 0;
    const take = n => xs => xs.slice(0,n);
    const drop = n => xs => xs.slice(n);
    const reverse = xs => xs.slice(0).reverse();
    const comp = f => g => x => f (g (x));
    const not = x => !x;
    const chunk = n => xs =>
    isEmpty(xs) ? [] : [take(n)(xs), ...chunk (n) (drop (n) (xs))];

    // numToWords :: (Number a, String a) => a -> String
    let numToWords = n => {
    
    let a = [
        '', 'one', 'two', 'three', 'four',
        'five', 'six', 'seven', 'eight', 'nine',
        'ten', 'eleven', 'twelve', 'thirteen', 'fourteen',
        'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    ];
    
    let b = [
        '', '', 'twenty', 'thirty', 'forty',
        'fifty', 'sixty', 'seventy', 'eighty', 'ninety'
    ];
    
    let g = [
        '', 'thousand', 'million', 'billion', 'trillion', 'quadrillion',
        'quintillion', 'sextillion', 'septillion', 'octillion', 'nonillion'
    ];
    
    // this part is really nasty still
    // it might edit this again later to show how Monoids could fix this up
    let makeGroup = ([ones,tens,huns]) => {
        return [
        // if huns is equal to 0 then it is empty else it's huns + hundred
        num(huns) === 0 ? '' : a[huns] + ' hundred ',
        num(ones) === 0 ? b[tens] : b[tens] && b[tens] + '-' || '',
        a[tens+ones] || a[ones]
        ].join('');
    };
    
    let thousand = (group,i) => group === '' ? group : `${group} ${g[i]}`;
    
    if (typeof n === 'number')
        return numToWords(String(n));
    else if (n === '0')
        return 'zero';
    else
        return comp (chunk(3)) (reverse) (arr(n))
        .map(makeGroup)
        .map(thousand)
        .filter(comp(not)(isEmpty))
        .reverse()
        .join(' ');
    };
</script>

<?php 

    if ($_SESSION['uname'] != NULL and $_SESSION['auth']=1) {


    $id_branch_dn = $_GET['id'];
    include 'config.php';

    //get the branch name to get the DN information
    $sql_branch_dn = "SELECT branch_id,debit_note_no,issueDate,renewalDate,endDate,totalSum,amount_word FROM key_branch_debitNoteNo WHERE id_branch_dn = $id_branch_dn";

    $branch_dn = query($db,$sql_branch_dn);

    foreach ($branch_dn as $result_number => $array) { 

        $branch_id = $array["branch_id"];
        $debitNoteNo = $array["debit_note_no"];
        $issueDate = $array["issueDate"];
        $renewalDate = $array["renewalDate"];
        $endDate = $array["endDate"];
        $totalSum = $array["totalSum"];
        $amount_word = $array["amount_word"];
    }

    //get company information
    $sql_company_details = "SELECT `company_id`,`branch_name`,`street`,`city`,`postcode`,`state`,`country` FROM `company_details` 
        WHERE branch_id = '$branch_id'";

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
    $sql_ref_dn = "SELECT class,ref,misc,amount FROM `key_dn_ref` WHERE id_branch_dn = '$id_branch_dn'";

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

?>

<div class="DNLogo"> <img src="/img/logo.png" height="50" style="vertical-align:bottom">secure Risk Management </div>

<div class="flex-container">
    <div class="container left">
        <p class="containerElement" id="company_name"> <?php echo $companyName ?> </p>
        <div class="containerElement" id="company_branch"> <?php echo $branch ?> </div>
        <div class="containerElement" id="street"> <?php echo $Street ?> </div>
        <div class="containerElement" id="city"> <?php echo $City ?> </div>
        <div class="containerElement" id="postcode"> <?php echo $postcode; echo "&nbsp"; echo $State ?> </div>
        <div class="containerElement" id="country"> <?php echo $country ?> </div>
    </div>
    <div class="container mid"></div>
    <div class="container right">
        <div class="containerElement"> Debit Note </div>
        <div class="containerElement" id="debitNoteNo"> <?php echo $debitNoteNo ?> </div>
        <div class="containerElement" id="issueDate"> <?php echo $issueDate ?> </div>
        </div>  

    <div class="container left title"> Date </div>
    <div class="container mid title"> Particulars </div>
    <div class="container right title"> Amount (RM) </div>  

    <div class="container left">
        <div id="renewalDate"> <?php echo $renewalDate ?> </div>
        <div> to </div>
        <div id="endDate"> <?php echo $endDate ?>  </div>
    </div>
    <?php
        for ($i=0;$i<sizeof($ref_array);$i++){ 
            if ($i>=1) {
                echo "<div class='container left'></div>";
            }
            ?>

            <div class="container mid">
                <div class="containerElement" id="class"> <?php echo $class_array[$i] ?> </div>
                <div class="containerElement" id="reference"> <?php echo $ref_array[$i] ?> </div>
                <div class="containerElement" id="misc"> m<?php echo $misc_array[$i] ?>isc </div>
            </div>
            <div class="container right"> <?php echo $amount_array[$i] ?> </div>  
    
    <?php    }
    ?> 

    <div class="container left"></div>
    <div class="container mid">
        <div>Gross Premium </div>
        <div>(inclusive of 6% SST &  </div>
        <div>General Stamp Duty)</div>
    </div>
    <div class="container right"></div>
        
    <div class="container left"></div>
    <div class="container mid">Premium Due</div>
    <div class="container right sum" id="totalSUm"> <?php echo $totalSum ?> </div>
            
        

    <div class="container left"></div>
    <div class="container mid" id="NumbersinWord"> </div>
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

<div class="mobile_dn_preview">

	<div class="mobile_dn_preview_address">
				<div class="mobile_dn_preview_title"> Company Addres: </div>
				<div> <?php echo $companyName ?> </div>
        <div> <?php echo $branch ?>  </div>
        <div> <?php echo $Street ?>  </div>
        <div> <?php echo $City ?>  </div>
        <div> <?php echo $postcode ?>, <?php echo $State ?> </div>
        <div> <?php echo $country ?> </div>
	</div>

	<div class="mobile_dn_preview_title">  Debit Note details:	</div>
	<div> Debit Note: <?php echo $debitNoteNo ?> </div>
	<div>	Debit Note Issue Date: <?php echo $issueDate ?> </div>
	<div> Policy Dates: <?php echo $renewalDate ?> - <?php echo $endDate ?> </div>

	<div class="mobile_dn_preview_particular">
		<div class="mobile_dn_preview_title"> Particulars: </div>
		<?php
			for ($i=0;$i<sizeof($ref_array);$i++){ 
				?>
				<div class="mobile_dn_preview_ref_card">
					<div class="mobile_dn_preview_ref_card_title"> Class: </div>
                    <div> <?php echo $class_array[$i] ?> </div>
					<div class="mobile_dn_preview_ref_card_title"> Reference: </div>
                    <div> <?php echo $ref_array[$i] ?>  </div>
					<div class="mobile_dn_preview_ref_card_title"> Details: </div>
                    <div> <?php echo $misc_array[$i] ?> </div>
					<div class="mobile_dn_preview_ref_card_title"> Amount: </div>
                    <div> <?php echo $amount_array[$i] ?> </div>
				</div>
    <?php }
		?> 

	<div> Total amount of Debit Note: RM <?php echo $totalSum ?> </div>
		


</div>

<?php
    }
    else {
        echo "You are not authorized to access this page. ";
    }
?>

<script>
    var totalsum = document.getElementById("totalSUm").innerHTML;
    document.getElementById("NumbersinWord").innerHTML = "Ringgit Malaysia " + numToWords(parseInt(totalsum)) + "only";
</script>

