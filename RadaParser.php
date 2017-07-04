<?php 

require_once __DIR__.'/vendor/autoload.php';

use Sunra\PhpSimple\HtmlDomParser;

class RadaParser
{
    private static $instance;
    private static $month = [
            'січня' => 1,
            'лютого' => 2,
            'березня' => 3,
            'квітня' => 4,
            'травня' => 5,
            'червня' => 6,
            'липня' => 7,
            'серпня' => 8,
            'вересня' => 9,
            'жовтня' => 10,
            'листопада' => 11,
            'грудня' => 12,
        ];
    
    private function __construct()
    {}
    
    public static function getInstance() {
        if( self::$instance == null ) {
            self::$instance = new RadaParser();
        }
        
        return self::$instance;
    }
    
    public function parsingAll( $count = 50 ) {
        
        $dom = HtmlDomParser::file_get_html( 'http://rada.gov.ua/news/hpz8' );
        $pages = $dom->find('[href^="http://iportal.rada.gov.ua/news/hpz8/page/"]');
        
        $pageCount = explode('/', $pages[count($pages) - 2]->href);
        $pageCount = $pageCount[count($pageCount)-1];
        
        $page = 1;
        $id = 1;
        
        $items = [];
        
        do {
            
            $dom = HtmlDomParser::file_get_html( 'http://iportal.rada.gov.ua/news/hpz8/page/'.$page );
            $page++;
            
            $dateList = $dom->find('#list_archive .date');
            $itemListLink = $dom->find('#list_archive .news_item a');
            $itemListTitle = $dom->find('#list_archive .news_item p');
            $i = -1;
            
            foreach ( $dateList as $key => $item ) {
                $title = $itemListTitle[++$i]->innertext;
                $date = $item->innertext;
                $result = explode( 'Рішення-' ,$itemListTitle[++$i]->innertext )[1];
                
                $vote_events[] = [
                        'vote_event_id' => $id++,
                        'title' => $title,
                        'date' => $this->ukrainianDateParser($date, 'c'),
                        'debate_url' => 'http://w1.c1.rada.gov.ua/pls/radan_gs09/ns_el_h2?data='
                                        .$this->ukrainianDateParser($date, 'dmY')
                                        .'&nom_s=3',
                        'sourse_url' => $itemListLink[$key]->href,
                        'result' => $result=='Прийнято'?'accepted':'not accepted'
                    ];
                    
                
                if ( count( $vote_events ) >= $count ){
                    break;
                }
            }
                
        } while ( $page <= $pageCount && count( $vote_events ) <= $count );
        /*
        foreach( $vote_events as $item ) {
            
            $votesPage = HtmlDomParser::file_get_html( $item['sourse_url'] );
            $fractions = $votesPage->find('.fr li');
            
            var_dump($votesPage);
                die();
            
            foreach ( $fractions as $fr ) {
                
                $frBlock = HtmlDomParser::str_get_html( $fr->tag );
                $fractionName = $frBlock->find('b');
                
            }
            
            $votes = [
                'vote_event_id' => $item['vote_event_id'],
                'voter' => 'voter',
                'option' => 'yes',
                'group_id' => 'party'
            ];
        }*/
        
        $items = [ 
            'vote_events' => $vote_events
        ];
        
        $items = json_encode($items);
        
        echo $items;
    }
    
    private function ukrainianDateParser( $dateString, $format ) {
        // Input: 22 ЧЕРВНЯ 2017, 18:02
        
        $dateTimeArray  = explode ( ',&nbsp;', $dateString );
        
        
        $date = trim( $dateTimeArray[0] );
        $time = trim( $dateTimeArray[1] );
 
        $date = explode( '&nbsp;', $date );
        $time = explode( ':', $time );
        
        $date[1] = self::$month[mb_strtolower( $date[1] )];
        
        return date( $format, mktime( $time[0], $time[1], 0, $date[1], $date[0], $date[2] ) );
    }
}