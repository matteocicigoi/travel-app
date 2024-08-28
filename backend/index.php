<?php
$fileName = 'database.json';
require(__DIR__ . '/functions.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

// createProfile
if(isset($_GET['method']) && $_GET['method'] == 'createProfile'){
    $data = getFile($fileName);
    $profileID = getRandomString();
    $data->{$profileID} = [];
    saveFile($fileName, $data);
    echo json_encode(['profileID' => $profileID]);
    exit;
}

//createTrip
if(isset($_GET['method']) && $_GET['method'] == 'createTrip'){
    if(!isset($_GET['profileID']) || empty($_GET['profileID'])){
        echo json_encode(['error' => 'Missing profileID']);
        exit;
    }
    $data = getFile($fileName);
    $profileID = $_GET['profileID'];
    $tripID = count($data->{$profileID});
    $data->{$profileID}[] = ["name" => "Viaggio-" . ($tripID + 1), "days" => []];
    saveFile($fileName, $data);
    echo json_encode(['tripID' => $tripID]);
    exit;
}

//createDay
if(isset($_GET['method']) && $_GET['method'] == 'createDay'){
    if(!isset($_GET['profileID']) || empty($_GET['profileID']) || !isset($_GET['tripID']) || !is_numeric($_GET['tripID']) || !isset($_GET['day']) || empty($_GET['day'])){
        echo json_encode(['error' => 'Missing profileID/tripID/day']);
        exit;
    }
    $data = getFile($fileName);
    $profileID = $_GET['profileID'];
    $tripID = $_GET['tripID'];
    $day = $_GET['day'];
    $dayID = count($data->{$profileID}[$tripID]->days);
    $data->{$profileID}[$tripID]->days[] = ["title" => "Giorno-" . ($dayID + 1), "day" => $day, "stops" => []];
    saveFile($fileName, $data);
    echo json_encode(['day' => $day, 'dayID' => $dayID]);
    exit;
}

//createStop
if(isset($_GET['method']) && $_GET['method'] == 'createStop'){
    if(!isset($_GET['profileID']) || empty($_GET['profileID']) || !isset($_GET['tripID']) || !is_numeric($_GET['tripID']) || !isset($_GET['dayID']) || !is_numeric($_GET['dayID'])){
        echo json_encode(['error' => 'Missing profileID/tripID/day']);
        exit;
    }
    $data = getFile($fileName);
    $profileID = $_GET['profileID'];
    $tripID = $_GET['tripID'];
    $dayID = $_GET['dayID'];
    $stopID = count($data->{$profileID}[$tripID]->days[$dayID]->stops);
    $data->{$profileID}[$tripID]->days[$dayID]->stops[] = ["title" => "Tappa-" . ($stopID + 1), "description" => null, "rating" => null, "images" => [], "coordinates" => []];
    saveFile($fileName, $data);
    echo json_encode(['stopID' => $stopID]);
    exit;
}

//renameTripTitle
if(isset($_GET['method']) && $_GET['method'] == 'renameTripTitle'){
    if(!isset($_GET['profileID']) || empty($_GET['profileID']) || !isset($_GET['tripID']) || !is_numeric($_GET['tripID']) || !isset($_GET['newName']) || empty($_GET['newName'])){
        echo json_encode(['error' => 'Missing profileID/tripID/newName']);
        exit;
    }
    $data = getFile($fileName);
    $profileID = $_GET['profileID'];
    $tripID = $_GET['tripID'];
    $newName = $_GET['newName'];
    $data->{$profileID}[$tripID]->name = $newName;
    saveFile($fileName, $data);
    echo json_encode(['result' => 'success']);
    exit;
}

//renameDayTitle
if(isset($_GET['method']) && $_GET['method'] == 'renameDayTitle'){
    if(!isset($_GET['profileID']) || empty($_GET['profileID']) || !isset($_GET['tripID']) || !is_numeric($_GET['tripID']) || !isset($_GET['dayID']) || !is_numeric($_GET['dayID']) || !isset($_GET['newTitle']) || empty($_GET['newTitle'])){
        echo json_encode(['error' => 'Missing profileID/tripID/dayID/newDay']);
        exit;
    }
    $data = getFile($fileName);
    $profileID = $_GET['profileID'];
    $tripID = $_GET['tripID'];
    $dayID = $_GET['dayID'];
    $newTitle = $_GET['newTitle'];
    $data->{$profileID}[$tripID]->days[$dayID]->title = $newTitle;
    saveFile($fileName, $data);
    echo json_encode(['result' => 'success']);
    exit;
}

//changeDay
if(isset($_GET['method']) && $_GET['method'] == 'changeDay'){
    if(!isset($_GET['profileID']) || empty($_GET['profileID']) || !isset($_GET['tripID']) || !is_numeric($_GET['tripID']) || !isset($_GET['dayID']) || !is_numeric($_GET['dayID']) || !isset($_GET['newDay']) || empty($_GET['newDay'])){
        echo json_encode(['error' => 'Missing profileID/tripID/dayID/newDay']);
        exit;
    }
    $data = getFile($fileName);
    $profileID = $_GET['profileID'];
    $tripID = $_GET['tripID'];
    $dayID = $_GET['dayID'];
    $newDay = $_GET['newDay'];
    $data->{$profileID}[$tripID]->days[$dayID]->day = $newDay;
    saveFile($fileName, $data);
    echo json_encode(['result' => 'success']);
    exit;
}

//changeStopInfo
if(isset($_GET['method']) && $_GET['method'] == 'changeStopInfo'){
    if(!isset($_GET['profileID']) || empty($_GET['profileID']) || !isset($_GET['tripID']) || !is_numeric($_GET['tripID']) || !isset($_GET['dayID']) || !is_numeric($_GET['dayID']) || !isset($_GET['stopID']) || !is_numeric($_GET['stopID'])){
        echo json_encode(['error' => 'Missing profileID/tripID/dayID/newDay/stopID']);
        exit;
    }
    $data = getFile($fileName);
    $profileID = $_GET['profileID'];
    $tripID = $_GET['tripID'];
    $dayID = $_GET['dayID'];
    $stopID = $_GET['stopID'];
    if(isset($_GET['newTitle']))$data->{$profileID}[$tripID]->days[$dayID]->stops[$stopID]->title = $_GET['newTitle'];
    if(isset($_GET['newDescription']))$data->{$profileID}[$tripID]->days[$dayID]->stops[$stopID]->description = $_GET['newDescription'];
    if(isset($_GET['newRating']) && is_numeric($_GET['newRating']) && $_GET['newRating'] >= 0 && $_GET['newRating'] <= 5)$data->{$profileID}[$tripID]->days[$dayID]->stops[$stopID]->rating = $_GET['newRating'];
    if(isset($_GET['newCoordinates'])){
        $coordinates = explode('b', $_GET['newCoordinates'] , 2);
        if(isset($coordinates[0]) && is_numeric($coordinates[0]) && isset($coordinates[1]) && is_numeric($coordinates[1])){
            $data->{$profileID}[$tripID]->days[$dayID]->stops[$stopID]->coordinates = [$coordinates[0], $coordinates[1]];
        }elseif($_GET['newCoordinates'] == 'b'){
            $data->{$profileID}[$tripID]->days[$dayID]->stops[$stopID]->coordinates = [];
        }
    }
    saveFile($fileName, $data);
    echo json_encode(['result' => 'success']);
    exit;
}

//deleteStop
if(isset($_GET['method']) && $_GET['method'] == 'deleteStop'){
    if(!isset($_GET['profileID']) || empty($_GET['profileID']) || !isset($_GET['tripID']) || !is_numeric($_GET['tripID']) || !isset($_GET['dayID']) || !is_numeric($_GET['dayID']) || !isset($_GET['stopID']) || !is_numeric($_GET['stopID'])){
        echo json_encode(['error' => 'Missing profileID/tripID/dayID']);
        exit;
    }
    $data = getFile($fileName);
    $profileID = $_GET['profileID'];
    $tripID = $_GET['tripID'];
    $dayID = $_GET['dayID'];
    $stopID = $_GET['stopID'];
    unset($data->{$profileID}[$tripID]->days[$dayID]->stops[$stopID]);
    $data->{$profileID}[$tripID]->days[$dayID]->stops = array_values($data->{$profileID}[$tripID]->days[$dayID]->stops);
    saveFile($fileName, $data);
    echo json_encode(['result' => 'success']);
    
    exit;
}

//deleteDay
if(isset($_GET['method']) && $_GET['method'] == 'deleteDay'){
    if(!isset($_GET['profileID']) || empty($_GET['profileID']) || !isset($_GET['tripID']) || !is_numeric($_GET['tripID']) || !isset($_GET['dayID']) || !is_numeric($_GET['dayID'])){
        echo json_encode(['error' => 'Missing profileID/tripID/dayID']);
        exit;
    }
    $data = getFile($fileName);
    $profileID = $_GET['profileID'];
    $tripID = $_GET['tripID'];
    $dayID = $_GET['dayID'];
    unset($data->{$profileID}[$tripID]->days[$dayID]);
    $data->{$profileID}[$tripID]->days = array_values($data->{$profileID}[$tripID]->days);
    saveFile($fileName, $data);
    echo json_encode(['result' => 'success']);
    
    exit;
}

//deleteTrip
if(isset($_GET['method']) && $_GET['method'] == 'deleteTrip'){
    if(!isset($_GET['profileID']) || empty($_GET['profileID']) || !isset($_GET['tripID']) || !is_numeric($_GET['tripID'])){
        echo json_encode(['error' => 'Missing profileID/tripID']);
        exit;
    }
    $data = getFile($fileName);
    $profileID = $_GET['profileID'];
    $tripID = $_GET['tripID'];
    unset($data->{$profileID}[$tripID]);
    saveFile($fileName, $data);
    echo json_encode(['result' => 'success']);
    
    exit;
}

//getProfile
if(isset($_GET['method']) && $_GET['method'] == 'getProfile'){
    if(!isset($_GET['profileID']) || empty($_GET['profileID'])){
        echo json_encode(['error' => 'Missing profileID']);
        exit;
    }
    $data = getFile($fileName);
    $profileID = $_GET['profileID'];
    if(isset($data->{$profileID})){
        echo json_encode(['profile' => $data->{$profileID}]);
    }else{
        echo json_encode(['error' => 'true']);
    }
    exit;
}

?>