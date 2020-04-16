<?php

/**
 * 
 */
class CovidDailyReport{

    private $_fips; 
    private $_admin2; 
    private $_province_state; 
    private $_country_region; 
    private $_last_update; 
    private $_lat; 
    private $_long_; 
    private $_confirmed; 
    private $_deaths;
    private $_recovered; 
    private $_active; 
    private $_combined_key;




    /**
     * 
     */
	public function __construct($arr){
        $num = count($arr);

       if( $num == 6 ){
           /*
            [0] => ﻿Province/State        [1] => Country/Region
            [2] => Last Update        [3] => Confirmed
            [4] => Deaths        [5] => Recovered
           */
          $this->_province_state = $arr[0];
          $this->_country_region = $arr[1];
          $this->_last_update = $this->format_date( $arr[2] );
          $this->_confirmed = $arr[3];
          $this->_deaths = $arr[4];
          $this->_recovered = $arr[5];
       }

       if( $num == 8){
           /*
            [0] => Province/State         [1] => Country/Region
            [2] => Last Update            [3] => Confirmed
            [4] => Deaths                 [5] => Recovered
            [6] => Latitude               [7] => Longitude
            */
            $this->_province_state = $arr[0];
            $this->_country_region = $arr[1];
            $this->_last_update = $this->format_date( $arr[2] );
            $this->_confirmed = $arr[3];
            $this->_deaths = $arr[4];
            $this->_recovered = $arr[5];
            $this->_lat = $arr[6];
            $this->_long_ = $arr[7];

        }


       if( $num == 12){
            /*
            [0] => FIPS                 [1] => Admin2
            [2] => Province_State       [3] => Country_Region
            [4] => Last_Update          [5] => Lat
            [6] => Long_                [7] => Confirmed
            [8] => Deaths               [9] => Recovered
            [10] => Active              [11] => Combined_Key
            */

            $this->_fips = $arr[0];
            $this->_admin2 = $arr[1];
            $this->_province_state = $arr[2];
            $this->_country_region = $arr[3];
            $this->_last_update = $this->format_date( $arr[4] );
            $this->_lat = $arr[5];
            $this->_long_ = $arr[6];            
            $this->_confirmed = $arr[7];
            $this->_deaths = $arr[8];
            $this->_recovered = $arr[9];
            $this->active = $arr[10];
            $this->_combined_key = $arr[11];

        }
    }
    

    private function format_date( $param ){
        if(! $date = DateTime::createFromFormat ( "m/d/Y H:i" , $param ) ){
            $date = DateTime::createFromFormat ( "Y-m-d?H:i:s" , $param ) ;
        }
        return $date->format('2020-m-d H:i');  
    }
    /**
     * 
     */
    public function getInsertQuery($tableName){
        $query = "INSERT INTO $tableName 
                  VALUES (
                  '$this->_fips', 
                  '" . SQLite3::escapeString($this->_admin2) . "',
                  '" . SQLite3::escapeString($this->_province_state) . "',
                  '" . SQLite3::escapeString($this->_country_region) . "',
                  '$this->_last_update', 
                  '$this->_lat', 
                  '$this->_long_', 
                  '$this->_confirmed', 
                  '$this->_deaths', 
                  '$this->_recovered', 
                  '$this->_active', 
                  '" . SQLite3::escapeString($this->_combined_key) . "'
                  )";

                  //echo $query;
        return $query;
    }

}

?>