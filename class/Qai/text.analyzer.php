<?php
/**
 * @author Piazzi Raffaele
 * @date 31 dec 2016
 * @release 1.0
 * @license Creative Commons, http://creativecommons.org/licenses/by-nd/4.0/deed.en
 * @title text.analyzer
 * @provider google, ibm
 * @key text, original (optional)
 * 
 * ******* DOCUMENTATION *******
 * 
 * Google --> https://cloud.google.com/natural-language/
 * Ibm    --> https://www.ibm.com/watson/developercloud/alchemy-language.html
 * 
 * ********** EXAMPLE **********
 * 
 * Qdb::out( '*text.analyzer',
 *    array( 'google', 'ibm' ),
 *    array(
 *           'text' => 'Google, headquartered in Mountain View, unveiled the new Android phone at the Consumer Electronic Show.  Sundar Pichai said in his keynote that users love their new Android phones.'
 *    )
 * );
 */
namespace Quantico;

class Qai extends Qout
{
    protected static function query($valass, $opz){ require_once 'class/Qurl.php'; $val = false;
        foreach($valass as $provider) { $provider = strtolower($provider);
            if($provider == 'google') { $val[$provider] = array();
                if(!isset($opz['text']) || !$opz['text']) $val[$provider]['error'] = 'key <<< text >>> is required';
                if(!isset($val[$provider]['error'])) { $data = array("document" => array ("type" => "PLAIN_TEXT", "content" => $opz['text']), "encodingType" => "UTF16");
                    
                    $out = Qurl::query(
                        'https://language.googleapis.com/v1beta1/documents:analyzeEntities?key=AIzaSyDsLFHoWogarw6iNFSm_EDEKt-vVz2vago',
                        'https://cloud.google.com/natural-language/', $data
                    );
                                                      
                    if(isset($opz['original']) && $opz['original']) $val[$provider]['success'] = $out;
                    else { $out = json_decode($out);
                        if(isset($out->error)) $val[$provider]['error'] = 'language not supported';
                        else { $x = -1;
                            foreach($out->entities as $data) { $x++;
                                $val[$provider]['success'][$x]['name'] = $data->name;
                                $val[$provider]['success'][$x]['type'] = $data->type;
                                $val[$provider]['success'][$x]['content'] = $data->mentions[0]->type;
                                $val[$provider]['success'][$x]['frequency'] = $data->salience;
                            }   $val[$provider]['language'] = $out->language;
                        }
                    }
                }
            }
            if($provider == 'ibm') { $val[$provider] = array();
                if(!isset($opz['text']) || !$opz['text']) $val[$provider]['error'] = 'key <<< text >>> is required';
                if(!isset($val[$provider]['error'])) {
                    
                    $out = Qurl::query(
                        'https://alchemy-language-demo.mybluemix.net/api/entities',
                        'https://alchemy-language-demo.mybluemix.net/',
                        $opz['text'].'&sentiment=1&linkedData=1&relevance=1&emotion=1&subType=1'
                    );
                    
                    if(isset($opz['original']) && $opz['original']) $val[$provider]['success'] = $out;
                    else { $out = json_decode($out);
                        if(isset($out->error)) $val[$provider]['error'] = $out->error->error;
                        else { $x = -1;
                            foreach($out->entities as $data) { $x++;
                                $val[$provider]['success'][$x]['name'] = $data->text;
                                $val[$provider]['success'][$x]['type'] = $data->type;
                                $val[$provider]['success'][$x]['relevance'] = $data->relevance;
                            }   $val[$provider]['language'] = $out->language;
                        }
                    }
                }
            }
        } if($val) return $val; else return false;
    }        
}
