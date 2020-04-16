<?php

/**
 * classe de gestion des operations bancaires
 */
class CovidDataOperator{


    private static $_CREATE_TABLE_REPORTS_QUERY =
        "CREATE TABLE reports (
            FIPS TEXT,
            Admin2 TEXT,
            Province_State TEXT,
            Country_Region TEXT,
            Last_Update TEXT,
            Lat REAL,
            Long_ REAL,
            Confirmed INTEGER,
            Deaths INTEGER,
            Recovered INTEGER,
            Active INTEGER,
            Combined_Key TEXT
        )";

    private static $_CREATE_TABLE_TREATED_FILES_QUERY =
    "CREATE TABLE treated_files (
        file	TEXT
    )";


    private static $_CREATE_LAST_DATA_BY_COUNTRY_QUERY =
    "create table last_data_by_country as
            select Country_Region, strftime('%Y-%m-%d', last_update) as last_update,Lat as lat, Long_ as lng, sum(Confirmed) as confirmed, sum(Deaths) as deaths, sum(Recovered) as recovered, sum(Active) as active
            from reports 
            where false
            group by Country_Region";


    private $_database;
    private $_inputDir;

    private $_DBG = true;
    private $_REPORT;

    /**
     * constructeur
     */
	public function __construct($db, $file){
        $this->_database = $db;
        $this->_inputDir = $file;
    }

    /**
     * 
     */
    public function createDatabase(){
        fopen($this->_database, 'w+');
        $db = new SQLite3( $this->_database );
        
        try {
            $results = $db->query( self::$_CREATE_TABLE_REPORTS_QUERY );
            $results = $db->query( self::$_CREATE_TABLE_TREATED_FILES_QUERY );
            $results = $db->query( self::$_CREATE_LAST_DATA_BY_COUNTRY_QUERY );

        } catch (Exception $e){}
        
        $this->_REPORT = "Database created";
        $db->close();
    }

    /**
     * 
     */ 
    public function setDebug( $dbg ){
        $this->_DBG = $dbg;
    }

    public function printReport(){
        echo "-- " . $this->_REPORT ."\n";
    }
    /**
     * 
     */
    public function dropData(){
        $db = new SQLite3( $this->_database );
        
        try {
            $results = $db->query("delete from reports");
            $results = $db->query("delete from treated_files");
            $results = $db->query("delete from last_data_by_country");


        } catch (Exception $e){}
        
        $this->_REPORT = "Data dropped";
        $db->close();
    }

    public function processReportsDirectory(){
        $db = new SQLite3( $this->_database );

        if ($handle = opendir( $this->_inputDir )) {
            while (false !== ($entry = readdir($handle))) {
                $path_parts = pathinfo( $entry );
                if ( strcmp( $path_parts['extension'], "csv") ==0 ) {
                    $results = $db->querySingle("select count(*) from treated_files where file = '$entry'" );
                    if( !$results){
                        echo "$entry\n";
                        $this->insertOperationsIntoDb( $entry );
    
                    }
                }
            }
            closedir($handle);
        }
    }


    /**
     * 
     */
    public function insertOperationsIntoDb( $inputFile ){
        $db = new SQLite3( $this->_database );
        $cpt = 0;


        if (($handle = fopen( $this->_inputDir .'/' .$inputFile , "r")) !== FALSE) {
            $data = fgetcsv($handle, 1000, ",");
            //print_r($data);
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                try {
                    $report = new CovidDailyReport($data);
                    $query = $report->getInsertQuery("reports") . "\n";
                    $results = $db->query($query);
                    $cpt++;
                    if($this->_DBG) 
                        print_r($query);
                } catch (Exception $e){ 
                    if($this->_DBG){
                        echo $e ;
                        print_r ($data);
                    } 
                }
            }

            $results = $db->query("insert into treated_files VALUES ( '$inputFile' )");

            fclose($handle);
        }
        
        $this->_REPORT = $cpt . " reports inserted";

        $db->close();
    }


    public function postProcess(){
        $db = new SQLite3( $this->_database );
        $results = $db->query("update reports set Country_Region ='China' where Country_Region ='Mainland China'");
        $results = $db->query("update reports set Active = Confirmed - Deaths - Recovered");
        $this->_REPORT = "post process done";


        $db->close();

    }


    public function buildConsolidatedData(){
        $db = new SQLite3( $this->_database );
        $results = $db->query("delete from last_data_by_country");

        $results = $db->query("
                    insert into last_data_by_country
                    select Country_Region, strftime('%Y-%m-%d', last_update) as last_update,Lat as lat, Long_ as lng, sum(Confirmed) as confirmed, sum(Deaths) as deaths, sum(Recovered) as recovered, sum(Active) as active
                    from reports 
                    where 
                        strftime('%Y-%m-%d', last_update) = (
                            select max(strftime('%Y-%m-%d', last_update)) from reports
                        )
                    group by Country_Region
                    order by confirmed desc");

        $db->close();

    }

}


?>