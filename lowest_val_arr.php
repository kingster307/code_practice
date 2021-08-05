<?php

// ==================
// problem
// ==================
// given 3 arr with elements in ascending order find the lowest common value between them
// can only use array_search
// return false if none found
// ================================

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