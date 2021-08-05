<?php

// ==================
// problem
// ==================
// given 3 arr with elements in ascending order find the lowest common value between them
// can only use array_search
// return false if none found
// ================================

// use random number generator for driver
// generates arrays of random numbers and lengths
$useRand = true;
// echo out array elements when using randNumber gen
$debug = false;
// set to true to compare v2 to original output
$test = true;

// ==========
// Driver
// ==========

// get array values from static || dynamic source 
[$ar1, $ar2, $ar3] = ($useRand ? getRandomArr() : [[1, 2, 4, 6, 7], [1, 2, 3, 4, 5, 6, 7, 8, 78], [3, 12, 78]]);

if($test) {
    // number of times to run test 
    $timesToRunTest = 10000; 
    // loop through && run tests 
    for($x=0;$x<$timesToRunTest;$x++)
    {
        // compare values
        if (smallest_common_number($ar1, $ar2, $ar3) !== smallest_common_number_v2($ar1, $ar2, $ar3))
        {
            // if failed once then exit loop 
            echo "Test Failed :(\n";
            exit; 
        }
    }
    // all tests passed
    echo "test success!!!!\n"; 
} 
// gets results && echos them    
$res = smallest_common_number($ar1, $ar2, $ar3);
$res2 = smallest_common_number_v2($ar1, $ar2, $ar3);
echo "Smallest Common Elements is " . ($res === false ? "non existent :) aka false" : $res) . "\n";
echo "Smallest Common Elements v2 is " . ($res2 === false ? "non existent :) aka false" : $res2) . "\n";

// gets array of random length & random elements of set range
function getRandomArr(int $minLen = 0, int $maxLen = 100, int $minVal = -10, int $maxVal = 100): array
{
    // get global var | probably better practice to pass in via param #tooCoolForSchool
    global $debug;

    // set configs
    $config = ["min" => $minLen, "max" => $maxLen, "minVal" => $minVal, "maxVal" => $maxVal];

    // init arr
    $arr1 = [];
    $arr2 = [];
    $arr3 = [];

    // loop once for each unique array
    for ($x = 1; $x < 4; $x++) {
        // generate random length
        $len = rand($config["min"], $config["max"]);
        // create each random number of specific arr for a random length
        for ($y = 0; $y < $len; $y++) {
            ${"arr" . $x}[$y] = rand($config["minVal"], $config["maxVal"]);
        }
        // sort fails if length 0
        if ($len > 0) {
            // sort arr in ascending order
            sort(${"arr" . $x});
        }
        // debug output 
        if ($debug) {
            echo "\n array #" . $x . "\n";
            print_r(${"arr" . $x});
        }
    }
    // return arrays
    return [$arr1, $arr2, $arr3];
}

function smallest_common_number(array $arr1, array $arr2, array $arr3) : int | bool
{
    // find lengths
    $arr1Count = count($arr1);
    $arr2Count = count($arr2);
    $arr3Count = count($arr3);

    // check if not empty arr
    if ($arr1Count === 0 || $arr2Count === 0 || $arr3Count === 0) {
        return false;
    }

    $arr1Index = 0;
    $arr2Index = 0;
    $arr3Index = 0;

    // loop through all
    while ($arr1Index < $arr1Count && $arr2Index < $arr2Count && $arr3Index < $arr3Count) {
        // if element matches then return element
        if ($arr1[$arr1Index] === $arr2[$arr2Index] && $arr2[$arr2Index] === $arr3[$arr3Index]) {
            return $arr1[$arr1Index];
            // else compare arr 1 element to arr 2
        } elseif ($arr1[$arr1Index] < $arr2[$arr2Index]) {
            $arr1Index++;
            // else compare 2 to 3
        } elseif ($arr2[$arr2Index] < $arr3[$arr3Index]) {
            $arr2Index++;
            // else increment arr 3
        } else {
            $arr3Index++;
        }
    }
    // return false by default
    return false;
}

// array_search version 
function smallest_common_number_v2(array $arr1, array $arr2, array $arr3) : int | bool
{
    global $debug; 
    // find smallest array 
    $findSmallestArr = function () use ($arr1, $arr2, $arr3, $debug) : array {
        // dump all counts to array 
        $counts = [count($arr1), count($arr2), count($arr3)]; 
        // init lowest to first count 
        $lowest = $counts[0];
        // associated w/ array name 
        $idNum = 1;  
        // find lowest in arr 
        for($x=0;$x<count($counts) -1;$x++){
            // if($x+1 < count)
            if($counts[$x + 1] < $counts[$x]){
             $lowest = $counts[$x+1];
             $idNum = $x+2;
            }
        }
        if($debug){
            echo "--------\n";
            print_r($counts);
            echo "--------\n";
        }
        return [$lowest, $idNum];
    };
    
    // extract data from function 
    [$lowest, $arrId] = $findSmallestArr();

    // default arrays to search to 0 
    $searchArr1 = 0;
    $searchArr2 = 0; 

    // find arrays to search shortest array against 
    if($arrId === 1){
    $searchArr1 = 2;
    $searchArr2 = 3;
    }elseif($arrId === 2){
    $searchArr1 = 1; 
    $searchArr2 = 3; 
    }else{
    $searchArr1 = 1;
    $searchArr2 = 2;
    }

    // search array 
    $searchArr = function ($x, $y, $index) use ($arr1, $arr2, $arr3, $arrId) {
        $keya = array_search(${"arr" . $arrId}[$index], ${"arr" . $x});
        $keyb = array_search(${"arr" . $arrId}[$index], ${"arr" . $y});
        if($keya!==false && $keyb!==false){
            return ${"arr" . $arrId}[$index];
        }
        return false;
    };

    // loop through all items of lowest count array 
    for($x=0;$x<$lowest; $x++)
    {
        $res = $searchArr($searchArr1, $searchArr2, $x);
        // if not false then lowest match found 
        if( $res !== false)
        {
            return $res;
        }
    }   
    return false;
}