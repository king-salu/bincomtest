<?php
include('./init00.php');



$_state_dd = '25';
if (isset($_REQUEST['state_dd'])) $_state_dd = $_REQUEST['state_dd'];

$_lga_dd   = '';
if (isset($_REQUEST['lga_dd'])) $_lga_dd = $_REQUEST['lga_dd'];

// $_ward_dd   = '';
// if (isset($_REQUEST['ward_dd'])) $_ward_dd = $_REQUEST['ward_dd'];

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

$gen_result = array();
if ($_act == 'generate') {
    if ($_lga_dd != 'NONE' && $_lga_dd != '') {
        $query = "SELECT * FROM `announced_pu_results` WHERE `polling_unit_uniqueid` IN 
        (select uniqueid from `polling_unit` where lga_id='$_lga_dd');";
        $gen_result = $connect->execute_query($query);
    }
}





echo "<pre>";
print_r($_REQUEST);
print_r($gen_result);
echo "</pre>";


?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Home || Polling Results</title>
</head>

<body>
    <h1>Polling Unit Result Sum</h1>
    <form name='puform' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method='post'>
        <div>
            <label for=" state_dd">State</label>
            <?php createDropBox('state_dd', 'state_dd', $state_list, $_state_dd); ?>
            <br />
            <br />
            <label for="lga_dd">LGAs</label>
            <?php createDropBox('lga_dd', 'lga_dd', $lga_list, $_lga_dd); ?>
            <!-- <br />
            <br />
            <label for="ward_dd">Wards</label>
            <?php createDropBox('ward_dd', 'ward_dd', [], $_ward_dd); ?> -->
            <br />
            <br />
            <button type="submit" id='generate'>Generate Stats</button>
        </div>
    </form>

    <div>
        <?php
        if ($_act == 'generate') {
            $score_total = 0;
            $_html = "";
            if (!empty($gen_result)) {


                foreach ($gen_result as $result) {
                    $party = $result['party_abbreviation'];
                    $party_score = $result['party_score'];
                    $score_total += $result['party_score'];
                    $_html .= "<tr>
                                                <td>{$party}</td>
                                                <td>" . number_format($party_score, 2) . "</td>
                                            </tr>";
                }
            }
        ?>
            <h2>Generated Stats</h2>
            <table>
                <tbody>
                    <tr>
                        <td colspan="2">
                            <h3>
                                <script>
                                    const lga = document.getElementById('lga_dd');
                                    const info = lga.options[lga.selectedIndex].text;
                                    document.write(info);
                                    //console.log(info);
                                </script>
                                <?= "= $score_total" ?>
                            </h3>
                        </td>
                    </tr>
                    <?= $_html ?>
                </tbody>
            </table>
        <?php }
        ?>
    </div>
</body>

<script src="./js/index.js" type="text/javascript"></script>

</html>