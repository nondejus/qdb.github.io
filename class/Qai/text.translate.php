<?php
/**
 * @author Piazzi Raffaele
 * @date 27 dec 2016
 * @release 1.0
 * @license Creative Commons, http://creativecommons.org/licenses/by-nd/4.0/deed.en
 * @title text.translate
 * @provider google, microsoft, ibm
 * @key text, to, from (optional), original (optional)
 * 
 * ******* DOCUMENTATION *******
 * 
 * Google    --> https://cloud.google.com/translate/
 * Microsoft --> https://www.microsoft.com/cognitive-services/en-us/translator-api
 * Ibm       --> https://www.ibm.com/watson/developercloud/language-translator.html
 * 
 * ********** EXAMPLE **********
 * 
 * Qdb::out( '*text.translate',
 *    array( 'google', 'microsoft', 'ibm' ),
 *    array(
 *           'text' => 'Google, headquartered in Mountain View, unveiled the new Android phone at the Consumer Electronic Show.  Sundar Pichai said in his keynote that users love their new Android phones.',
 *           'from' => 'en',
 *           'to'   => 'it'
 *    )
 * );
 */
class Qai extends Qout
{
    protected static function query($valass, $opz){ $val = false;
        foreach($valass as $provider) { $provider = strtolower($provider); $x = 4;
            if($provider == 'google') { $val[$provider] = array(); $url = 'https://translate.googleapis.com/translate_a/single?client=gtx&';
                if(isset($opz['from']) && $opz['from']) $url .= 'sl='.$opz['from'].'&'; else { $url .= 'sl=auto&'; $x = 8; }
                if(isset($opz['to']) && $opz['to']) $url .= 'tl='.$opz['to'].'&dt=t&q='; else $val[$provider]['error'] = 'key <<< to >>> is required';
                if(isset($opz['text']) && $opz['text']) $url .= urlencode($opz['text']); else $val[$provider]['error'] = 'key <<< text >>> is required';
                if(!isset($val[$provider]['error'])) { $out = file_get_contents($url);
                    if(isset($opz['original']) && $opz['original']) $val[$provider]['success'] = $out;
                    else { $out = substr($out,4); $pos = explode('"',$out);
                        $val[$provider]['success'] = ''; for($a=0; $a<count($pos)-$x; $a += 4) $val[$provider]['success'] .= $pos[$a];
                        $val[$provider]['language'] = $pos[count($pos)-2];
                    }
                }     
            }
            if($provider == 'microsoft') { $val[$provider] = array(); $url = 'http://api.microsofttranslator.com/v2/ajax.svc/TranslateArray?appId=%22TvD4RoLnNaGt21F3u70Grmx3xTrUGmgN1fGyJUqkLbfo*%22';
                if(isset($opz['from']) && $opz['from']) $url .= '&from=%22'.$opz['from'].'%22&'; else $url .= '&from=%22%22&';
                if(isset($opz['to']) && $opz['to']) $url .= 'to=%22'.$opz['to'].'%22&'; else $val[$provider]['error'] = 'key <<< to >>> is required';
                if(isset($opz['text']) && $opz['text']) $url .= 'texts=[%22'.urlencode($opz['text']).'%22]'; else $val[$provider]['error'] = 'key <<< text >>> is required';
                if(!isset($val[$provider]['error'])) { $out = file_get_contents($url);
                    if(isset($opz['original']) && $opz['original']) $val[$provider]['success'] = $out;
                    else { $pos = strpos($out,'"TranslatedText":'); $end = strpos($out,'","TranslatedTextSentenceLengths":'); $x = $pos + 18;
                        $val[$provider]['success'] = substr($out,$x,$end-$x); $pos = strpos($out,'"From":'); if($pos) $val[$provider]['language'] = substr($out,$pos+8,2);
                    }
                }     
            }
            if($provider == 'ibm') { $val[$provider] = array(); $url = 'https://watson-api-explorer.mybluemix.net/language-translator/api/v2/translate?';
                if(isset($opz['from']) && $opz['from']) $url .= 'source='.$opz['from'].'&'; 
                elseif(isset($val['google']['language'])) $url .= 'source='.$val['google']['language'].'&';
                elseif(isset($val['microsoft']['language'])) $url .= 'source='.$val['microsoft']['language'].'&';
                else $val[$provider]['error'] = 'key <<< from >>> is required';
                if(isset($opz['to']) && $opz['to']) $url .= 'target='.$opz['to'].'&text='; else $val[$provider]['error'] = 'key <<< to >>> is required';
                if(isset($opz['text']) && $opz['text']) $url .= urlencode($opz['text']); else $val[$provider]['error'] = 'key <<< text >>> is required';
                if(!isset($val[$provider]['error'])) { 
                    $val[$provider]['success'] = file_get_contents($url);
                    $val[$provider]['language'] = $opz['from'];
                }
            }
        } if($val) return $val; else return false;
    }        
}

?>