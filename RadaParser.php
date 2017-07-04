<?php 

require_once __DIR__.'/vendor/autoload.php';

use Sunra\PhpSimple\HtmlDomParser;

class RadaParser
{
    private static $instance;
    
    private function __construct()
    {}
    
    public static function getInstance() {
        if( self::$instance == null ) {
            self::$instance = new RadaParser();
        }
        
        return self::$instance;
    }
    
    public function parsing( $count = 250 ) {
        $dom = HtmlDomParser::file_get_html( 'http://rada.gov.ua/news/hpz8' );
        
        $pages = $dom->find('[href^="http://iportal.rada.gov.ua/news/hpz8/page/"]');
        
        $pageCount = explode('/', $pages[count($pages) - 2]->href);
        $pageCount = $pageCount[count($pageCount)-1];
        echo $pageCount;
    }
}