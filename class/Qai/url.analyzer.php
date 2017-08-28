<?php
/**
 * @author Piazzi Raffaele
 * @date 31 dec 2016
 * @release 1.0
 * @license Creative Commons, http://creativecommons.org/licenses/by-nd/4.0/deed.en
 * @title url.analyzer
 * @provider ibm
 * @key url, original (optional)
 * 
 * ******* DOCUMENTATION *******
 * 
 * Ibm --> https://www.ibm.com/watson/developercloud/alchemy-language.html
 * 
 * ********** EXAMPLE **********
 * 
 * Qdb::out( '*url.analyzer',
 *    array( 'ibm' ),
 *    array(
 *           'url' => 'https://lite-post.net'
 *    )
 * );
 */
namespace Quantico;

class Qai extends Qout
{
    protected static function query($valass, $opz){ require_once 'class/Qurl.php'; $val = false;
        foreach($valass as $provider) { $provider = strtolower($provider);
            if($provider == 'ibm') { $val[$provider] = array();
                if(!isset($opz['url']) || !$opz['url']) $val[$provider]['error'] = 'key <<< url >>> is required';
                if(!isset($val[$provider]['error'])) { 
                    
                    $out = Qurl::query(
                        'https://alchemy-language-demo.mybluemix.net/api/entities',
                        'https://alchemy-language-demo.mybluemix.net/', false,
                        $opz['url'].'&sentiment=1&linkedData=1&relevance=1&emotion=1&subType=1'
                    );
                    
                    if(isset($opz['original']) && $opz['original']) $val[$provider]['success'] = $out;
                    else { $out = json_decode($out);
                        if(isset($out->error)) $val[$provider]['error'] = $out->error->error;
                        else { $x = -1;
                            foreach($out->entities as $data) { $x++;
                                $val[$provider]['success'][$x]['name'] = $data->text;
                                $val[$provider]['success'][$x]['type'] = $data->type;
                                $val[$provider]['success'][$x]['relevance'] = $data->relevance;
                                if(isset($data->sentiment)) $val[$provider]['success'][$x]['sentiment'] = $data->sentiment->type;
                                if(isset($data->emotions)) {
                                    $val[$provider]['success'][$x]['anger']   = $data->emotions->anger;
                                    $val[$provider]['success'][$x]['disgust'] = $data->emotions->disgust;
                                    $val[$provider]['success'][$x]['fear']    = $data->emotions->fear;
                                    $val[$provider]['success'][$x]['joy']     = $data->emotions->joy;
                                    $val[$provider]['success'][$x]['sadness'] = $data->emotions->sadness;
                                }
                            }   $val[$provider]['language'] = $out->language;
                        }
                    }
                }
            }
        } if($val) return $val; else return false;
    }        
}