<?php
/**
 * @author   Sergei Semenyuk <sergio.semenyuk@gmail.com>
 * @access   public
 */

include_once('GooglePlaceApi.php');

$object = new GooglePlaceApi();
echo $places = $object->findPlaces();
