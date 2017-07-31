<?php
/**
 * @author Piazzi Raffaele
 * @date 31 dec 2016
 * @release 1.0
 * @license Creative Commons, http://creativecommons.org/licenses/by-nd/4.0/deed.en
 * @title text.profile
 * @provider ibm
 * @key text, to (optional), from (optional), original (optional)
 * 
 * ******* DOCUMENTATION *******
 * 
 * Ibm --> https://www.ibm.com/watson/developercloud/personality-insights.html
 * 
 * ********** EXAMPLE **********
 * 
 * Qdb::out( '*text.profile',
 *    array( 'ibm' ),
 *    array(
 *           'text' => 'Google, headquartered in Mountain View, unveiled the new Android phone at the Consumer Electronic Show. Sundar Pichai said in his keynote that users love their new Android phones.',
 *           'from' => 'en',
 *           'to'   => 'it'
 *    )
 * );
 */
namespace Quantico;

class Qai extends Qout
{
    protected static function query($valass, $opz){ require_once 'class/Qurl.php'; $val = false;
        foreach($valass as $provider) { $provider = strtolower($provider);
            if($provider == 'ibm') { $data = array('source_type' => 'text','include_raw' => false); $val[$provider] = array();
                if(isset($opz['to']) && $opz['to']) $data['accept_language'] = $opz['to'];
                if(isset($opz['from']) && $opz['from']) $data['language'] = $opz['from'];
                if(isset($opz['text']) && $opz['text']) $data['text'] = urlencode($opz['text']); else $val[$provider]['error'] = 'key <<< text >>> is required';
                if(!isset($val[$provider]['error'])) { 
                    
                    $out = Qurl::query(
                        'https://personality-insights-livedemo.mybluemix.net/api/profile/text',
                        'https://personality-insights-livedemo.mybluemix.net/', $data
                    );
                    
                    if(isset($opz['original']) && $opz['original']) $val[$provider]['success'] = $out;
                    else { $out = json_decode($out);
                        if(isset($out->error)) $val[$provider]['error'] = $out->error->error;
                        else { $val[$provider]['success']['word'] = $out->word_count;
                            if(isset($out->word_count_message)) $val[$provider]['success']['message'] = $out->word_count_message;
                            foreach($out->raw_v3_response->personality as $data) { $val[$provider]['success']['personality'][strtolower($data->name)] = array('score' => $data->percentile);
                                foreach($data->children as $msg) $val[$provider]['success']['personality'][strtolower($data->name)][strtolower($msg->name)] = $msg->percentile;
                            }
                            foreach($out->raw_v3_response->needs as $data) $val[$provider]['success']['needs'][strtolower($data->name)] = $data->percentile;
                            foreach($out->raw_v3_response->values as $data) $val[$provider]['success']['values'][strtolower($data->name)] = $data->percentile;
                            
                            foreach($out->raw_v3_response->consumption_preferences as $data) {
                                foreach($data->consumption_preferences as $msg) $val[$provider]['success']['consumption'][strtolower($data->name)][strtolower($msg->name)] = $msg->score;
                            }
                            $val[$provider]['language'] = $out->processed_lang;
                        }
                    }
                }     
            }
        } if($val) return $val; else return false;
    }        
}

?>