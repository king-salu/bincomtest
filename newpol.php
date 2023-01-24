<?php
include('./init00.php');



$_state_dd = '25';
if (isset($_REQUEST['state_dd'])) $_state_dd = $_REQUEST['state_dd'];

$_lga_dd   = '';
if (isset($_REQUEST['lga_dd'])) $_lga_dd = $_REQUEST['lga_dd'];

$_ward_dd   = '';
if (isset($_REQUEST['ward_dd'])) $_ward_dd = $_REQUEST['ward_dd'];

$_poll_name = '';
if (isset($_REQUEST['pollunitname'])) $_poll_name = $_REQUEST['pollunitname'];

$_act = '';
if (isset($_REQUEST['act'])) $_act = $_REQUEST['act'];

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
    $query = "SELECT ward_id as id,ward_name as info FROM `ward` where lga_id='$_lga_dd'";
    $ward_list = $connect->execute_query($query);
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
    <title>New Polling Data</title>
</head>

<body>
    <h1>New Polling Unit</h1>
    <form name='puform' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method='post'>
        <div>
            <label for=" state_dd">State</label>
            <?php createDropBox('state_dd', 'state_dd', $state_list, $_state_dd); ?>
            <br />
            <br />
            <label for="lga_dd">LGAs</label>
            <?php createDropBox('lga_dd', 'lga_dd', $lga_list, $_lga_dd); ?>
            <br />
            <br />
            <label for="ward_dd">Wards</label>
            <?php createDropBox('ward_dd', 'ward_dd', $ward_list, $_ward_dd); ?>
            <br />
            <br />
            <label for="ward_dd">Polling Unit Name</label>
            <input type="text" required name='pollunitname' />
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
            <button type="submit" id='generate'>Save</button>
        </div>
    </form>
</body>

</html>