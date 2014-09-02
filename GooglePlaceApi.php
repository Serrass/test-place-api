<?php
/**
 * Class GooglePlaceApi is a sample class for
 *
 * example how to work with Google Place API
 *
 *
 *
 *  $object = new GooglePlaceApi();
 *  echo $places = $object->findPlaces();
 *
 *
 * @author   Sergei Semenyuk <sergio.semenyuk@gmail.com>
 * @access   public
 */

class GooglePlaceApi {

    /**
     * @var array
     */
    public $places = array();

    /**
     * @var array
     */
    protected $_errorMesasges = array(
         'ZERO_RESULTS'     => 'the search is successful, but the results were not found.',
         'OVER_QUERY_LIMIT' => 'Over quota',
         'REQUEST_DENIED'   => 'Request has been rejected, usually due to the absence of the parameter sensor.',
         'INVALID_REQUEST'  => 'There is no mandatory parameter query, such as the location or radius.',
         'NO_QUERY'         => 'Please enter query'
    );

    /**
     * @var string
     */
    protected $_apiUrl = 'https://maps.googleapis.com/maps/api/place';

    /**
     * @var mixed|string
     */
    protected $_query = '';

    /**
     * @var string
     */
    private $_apiKey = 'AIzaSyD0_tK6lSxzE_67pR-nzL6aY1doOqHX_e8';

    /**
     * constructor - creates a GooglePlaceApi object,
     * set content-type to application/json
     *
     */
    public function __construct()
    {
    }

    /**
     *  _curlCall Executes a curl call to the specified url with the specified data to post and returns the result.
     *
     * @return mixed
     */
    protected function _curlCall()
    {

        $urlToCall = $this->_apiUrl . '/textsearch/json'. '?query=' . $this->_query.'&key='.$this->_apiKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlToCall);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $body = curl_exec($ch);
        curl_close($ch);

        return $body;
    }

    /**
     * findPlaces formats the results
     *
     * @return string
     */
    public function findPlaces()
    {
        if (!empty($_GET['query'])) {
            $this->_query = str_replace (' ','+',$_GET['query']);
        } else {
            return json_encode(array('error' => $this->_errorMesasges['NO_QUERY']));
        }

        $result = json_decode($this->_curlCall());
        if ($result->status == 'OK') {
            foreach($result->results as $index => $place) {
                $this->places[$index]['name'] = $place->name;
                $this->places[$index]['formatted_address'] = $place->formatted_address;
            }
            $return = $this->places;
        } else {
            if (isset($this->_errorMesasges[$result->status])) {
                $return = array('Error' => $this->_errorMesasges[$result->status]);
            } else {
                $return = array('Error' => 'Something went wrong!');
            }
        }
        return json_encode($return);
    }
}