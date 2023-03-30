<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <php?
    $userArr = array("startAge"=>43, "endAge" =>80, "teeth"=>15);

    function calcActTime($actArr) {
	    $years = $actArr["endAge"] - $actArr["startAge"];
        $overallTimeInMins = $years * 365 * $actArr["teeth"];
        $remTimeInMins = $overallTimeInMins % 60;
        $overallTimeInHours = ($overallTimeInMins-$remTimeInMins)/60;
        $remTimeInHours = $overallTimeInHours % 24;
        $overallTimeInDays = ($overallTimeInHours-$remTimeInHours)/24;
    
        echo "<div>You will have spent approximately: ".$overallTimeInDays." days, ".$remTimeInHours." hours, and ".$remTimeInMins." minutes brushing your teeth, by the time you are ".$actArr["endAge"]."!</div>";
}

calcActTime($userArr);
    
    ?>
    
</body>
</html>