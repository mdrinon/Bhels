<?php
require '../vendor/autoload.php'; // include Composer's autoloader

// connecting to MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->bheldb->faqs_bot;

// getting user message through ajax
$getMesg = $_POST['text'];

// checking user query to database query
$check_data = array('queries' => new MongoDB\BSON\Regex($getMesg, 'i'));
$run_query = $collection->findOne($check_data);

// if user query matched to database query we'll show the reply otherwise it go to else statement
if($run_query){
    // fetching reply from the database according to the user query
    $replay = $run_query['replies'];
    echo $replay;
}else{
    echo "Sorry can't be able to understand you!";
}
?>