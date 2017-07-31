<?php
/**
 * @author Piazzi Raffaele
 * @date 31 dec 2016
 * @release 1.0
 * @license Creative Commons, http://creativecommons.org/licenses/by-nd/4.0/deed.en
 * @title twitter.profile
 * @provider ibm
 * @key twitter, from (optional), to (optional), original (optional)
 * 
 * ******* DOCUMENTATION *******
 * 
 * Ibm --> https://www.ibm.com/watson/developercloud/personality-insights.html
 * 
 * ********** EXAMPLE **********
 * 
 * Qdb::out( '*twitter.profile',
 *    array( 'ibm' ),
 *    array(
 *           'twitter' => 'Oprah'
 *           'from'    => 'en',
 *           'to'      => 'it',
 *    )
 * );
 */
namespace Quantico;

class Qai extends Qout
{
    protected static function query($valass, $opz){ require_once 'class/Qurl.php'; $val = false;
        foreach($valass as $provider) { $provider = strtolower($provider);
            if($provider == 'ibm') { $data = array('source_type' => 'twitter','include_raw' => false); $val[$provider] = array();
                if(isset($opz['from']) && $opz['from']) $data['language'] = $opz['from'];
                if(isset($opz['to']) && $opz['to']) $data['accept_language'] = $opz['to'];
                if(isset($opz['twitter']) && $opz['twitter']) $data['userId'] = urlencode($opz['twitter']); else $val[$provider]['error'] = 'key <<< twitter >>> is required';
                if(!isset($val[$provider]['error'])) { 
                    
                    $out = Qurl::query(
                        'https://personality-insights-livedemo.mybluemix.net/api/profile/twitter',
                        'https://personality-insights-livedemo.mybluemix.net/', $data
                    );
                    
                    if(isset($opz['original']) && $opz['original']) $val[$provider]['success'] = $out;
                    else { $out = json_decode($out);
                        if(isset($out->error)) $val[$provider]['error'] = $out->error->error;
                        else { $val[$provider]['success']['id'] = $out->id; $val[$provider]['success']['word'] = $out->word_count;
                            if(isset($out->word_count_message)) $val[$provider]['success']['message'] = $out->word_count_message;
                            foreach($out->raw_v3_response->personality as $data) { $val[$provider]['success']['personality'][strtolower($data->name)] = array('score' => $data->percentile);
                                foreach($data->children as $msg) $val[$provider]['success']['personality'][strtolower($data->name)][strtolower($msg->name)] = $msg->percentile;
                            }
                            foreach($out->raw_v3_response->needs as $data) $val[$provider]['success']['needs'][strtolower($data->name)] = $data->percentile;
                            foreach($out->raw_v3_response->values as $data) $val[$provider]['success']['values'][strtolower($data->name)] = $data->percentile;
                            foreach($out->raw_v3_response->behavior as $data) $val[$provider]['success']['behavior'][strtolower($data->name)] = $data->percentage;
                            
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