<?php
/**
 * @author   Sergei Semenyuk <sergio.semenyuk@gmail.com>
 * @access   public
 */

include_once('GooglePlaceApi.php');

header('Content-Type: application/json');

$object = new GooglePlaceApi();
echo $places = $object->findPlaces();
