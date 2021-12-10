<?php
//get file contents
$file = fopen("beerFile.json", "r") or die("Unable to open file!");
$fileText = fread($file, filesize("beerFile.json"));
fclose($file);

//convert json to array
$beers = json_decode($fileText, true);
//print_r($beers);

$brands = array();
$names =  array();
$ranks =  array();

//split up array into separate arrays
for ($count = 0; $count < count($beers); $count++) {
  $brands[$count] = $beers[$count]["brand"];
  $names[$count] =  $beers[$count]["name"];
  $ranks[$count] =  $beers[$count]["rank"];
}

//print_r($brands);
//print_r($names);
//print_r($ranks);

// GET handling:

$getStr;
if ($_GET["name"]) {$getStr = $_GET["name"];}
$getStr = "IPA";

$matchIndexes = array();
$jsonArr = array();
$specialEnd = array("Voodoo Ranger", "120 Minute IPA", "Two Hearted Ale");

//get indexes of names with GET requested string
for ($count = 0; $count < count($names); $count++) {

  //records indexes with matches
  if (strpos($names[$count], $getStr) !== false) {
    $matchIndexes[] = $count;
  }

  //checks if name is in the IPA endpoint
  else {

    //iterates though the special IPA cases
    foreach ($specialEnd as $end) {

      //checks if name is a special case, then records it if true
      if ($end == $names[$count] and $getStr == "IPA") {
        $matchIndexes[] = $count;
      }
    }
  }
}

//print_r($matchIndexes);
//place names values from matches indexes into jsonArr
foreach ($matchIndexes as $index) {
  
  if ("Voodoo Ranger" == $names[$index] ||
      "120 Minute IPA" == $names[$index] ||
      "Two Hearted Ale" == $names[$index] ) 
  {
    $jsonArr[] = $beers[$index];
  }
  else {
    $jsonArr[] = $names[$index];
  }
}
//print_r($jsonArr);

//outJson is the response JSON to the GET request
$outJson = json_encode($jsonArr);
echo $outJson;

// POST handling:

$postStr;
if ($_POST["brewery"]) {$postStr = $_POST["brewery"];}
$postStr = "Bell’s Brewery";

$matchIndexes = array();
$jsonArr = array();

//get indexes of names with POST requested string
for ($count = 0; $count < count($brands); $count++) {

  //records indexes with matches
  if (strpos($brands[$count], $postStr) !== false) {
    $matchIndexes[] = $count;
  }
}

//place names values from matches indexes into jsonArr
foreach ($matchIndexes as $index) {
  $jsonArr[] = $beers[$index];
}

//print_r($jsonArr);

//outJson is the response JSON to the POST request
$outJson = json_encode($jsonArr);
echo $outJson;

//$file2 = fopen("out.json", "w") or die("Unable to open file!");
//fwrite($file2, $outJson);
//fclose($file2);
?>