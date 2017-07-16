<?php
/**
 * @author Piazzi Raffaele
 * @date 31 dec 2016
 * @release 1.0
 * @license Creative Commons, http://creativecommons.org/licenses/by-nd/4.0/deed.en
 * @title url.feed
 * @provider ibm
 * @key url, original (optional)
 * 
 * ******* DOCUMENTATION *******
 * 
 * Ibm --> https://www.ibm.com/watson/developercloud/alchemy-language.html
 * 
 * ********** EXAMPLE **********
 * 
 * Qdb::out( '*url.feed',
 *    array( 'ibm' ),
 *    array(
 *           'url' => 'https://lite-post.net'
 *    )
 * );
 */
class Qai extends Qout
{
    protected static function query($valass, $opz){ require_once('class/Qurl.php'); $val = false;
        foreach($valass as $provider) { $provider = strtolower($provider);
            if($provider == 'ibm') { $val[$provider] = array();
                if(!isset($opz['url']) || !$opz['url']) $val[$provider]['error'] = 'key <<< url >>> is required';
                if(!isset($val[$provider]['error'])) { $out = Qurl::query('https://alchemy-language-demo.mybluemix.net/api/feeds','https://alchemy-language-demo.mybluemix.net/',false,$opz['url']);
                    if(isset($opz['original']) && $opz['original']) $val[$provider]['success'] = $out;
                    else { $out = json_decode($out);
                        if(isset($out->error)) $val[$provider]['error'] = $out->error->error;
                        else $val[$provider]['success']['feed'] = $out->feeds;
                    }
                }
            }
        } if($val) return $val; else return false;
    }        
}

?>