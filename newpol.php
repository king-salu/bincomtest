<?php
include('./init00.php');



$_state_dd = '25';
if (isset($_REQUEST['state_dd'])) $_state_dd = $_REQUEST['state_dd'];

$_lga_dd   = '';
if (isset($_REQUEST['lga_dd'])) $_lga_dd = $_REQUEST['lga_dd'];

$_ward_dd   = '';
if (isset($_REQUEST['ward_dd'])) $_ward_dd = $_REQUEST['ward_dd'];

$_pollunit_dd = '';
if (isset($_REQUEST['pollunit_dd'])) $_pollunit_dd = $_REQUEST['pollunit_dd'];

$_act = '';
if (isset($_REQUEST['act'])) $_act = $_REQUEST['act'];

//Save 
if ($_act == 'save') {

    $query = '';
    foreach($_REQUEST as $partysn=>$partyscore) {
        $partysplit = explode('_',$partysn);
        if ($partysplit[0] == 'party' && $partyscore > 0) {
            $partyabrv = trim($partysplit[1]);
            if ($query == '') {
                $query = "INSERT INTO `announced_pu_results`(`polling_unit_uniqueid`, `party_abbreviation`, `party_score`, `entered_by_user`, `date_entered`) VALUES ";
            }
            else $query .= ', ';
            $query .= "('$_pollunit_dd','$partyabrv','$partyscore','Bincom_Test','".date('Y-m-d H:i:s')."')";
        }
    }

    //echo $query;
    if ($query != '') {
        $connect->execute_uquery($query);
    }
}

//get States
$query = "SELECT state_id as code, state_name as info FROM `states`;";
$state_list = $connect->execute_query($query);

//get lgas
$lga_list = array();
if ($_state_dd != 'NONE' && $_state_dd != '') {
    $query = "SELECT lga_id as code ,lga_name as info FROM `lga` WHERE state_id = '$_state_dd';";
    $lga_list = $connect->execute_query($query);
}

//get wards
$ward_list = array();
if ($_lga_dd != 'NONE' && $_lga_dd != '') {
    $query = "SELECT ward_id as code,ward_name as info FROM `ward` where lga_id='$_lga_dd';";
    $ward_list = $connect->execute_query($query);
}

//get polling unit List
$polln_list = array();
if ($_ward_dd != 'NONE' && $_ward_dd != '') {
    $query = "SELECT uniqueid as code, polling_unit_name as info FROM `polling_unit` WHERE ward_id='$_ward_dd';";
    $polln_list = $connect->execute_query($query);
}

//get party List
$party_list = array();
$query = "SELECT * FROM `party`";
$party_list = $connect->execute_query($query);




?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>New Polling Result</title>
</head>

<body>
    <h1>New Polling Unit Results</h1>
    <form name='newpuform' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method='post'>
        <div>
            <label for=" state_dd">State</label>
            <?php createDropBox('state_dd', 'state_dd', $state_list, $_state_dd,'code','info',false,true); ?>
            <br />
            <br />
            <label for="lga_dd">LGAs</label>
            <?php createDropBox('lga_dd', 'lga_dd', $lga_list, $_lga_dd,'code','info',false,true); ?>
            <br />
            <br />
            <label for="ward_dd">Wards</label>
            <?php createDropBox('ward_dd', 'ward_dd', $ward_list, $_ward_dd,'code','info',false,true); ?>
            <br />
            <br />
            <label for="pollunit_dd">Polling Unit</label>
            <?php createDropBox('pollunit_dd', 'pollunit_dd', $polln_list, $_pollunit_dd,'code','info',false,true); ?>
            <br />
            <br />
            <?php
            if (!empty($party_list)) {
                foreach ($party_list as $party) {
                    $party_sn = "party_{$party['partyid']}";
                    $partyname = $party['partyname'];
                    echo "<label for='$party_sn'>$partyname</label>
                                <input type='number' name='$party_sn' id='$party_sn' value=0 /> <br/>";
                }
            }
            ?>
            <button type="submit" id='save'>Save</button>
        </div>
    </form>
</body>

<script src="./js/newpol.js" type="text/javascript"></script>

</html>