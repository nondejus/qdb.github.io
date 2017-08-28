<?php
/**
 * @author Piazzi Raffaele
 * @date 30 dec 2016
 * @release 1.0
 * @license Creative Commons, http://creativecommons.org/licenses/by-nd/4.0/deed.en
 * @title text.emotion
 * @provider google, ibm
 * @key text, original (optional)
 * 
 * ******* DOCUMENTATION *******
 * 
 * Google --> https://cloud.google.com/natural-language/
 * Ibm    --> https://www.ibm.com/watson/developercloud/tone-analyzer.html
 * 
 * ********** EXAMPLE **********
 * 
 * Qdb::out( '*text.emotion',
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
                        'https://language.googleapis.com/v1beta1/documents:analyzeSentiment?key=AIzaSyDsLFHoWogarw6iNFSm_EDEKt-vVz2vago',
                        'https://cloud.google.com/natural-language/', $data
                    );
                                                      
                    if(isset($opz['original']) && $opz['original']) $val[$provider]['success'] = $out;
                    else { $out = json_decode($out);
                        if(isset($out->error)) $val[$provider]['error'] = 'language not supported';
                        else { $x = -1;
                            foreach($out->sentences as $data) { $x++;
                                $val[$provider]['success'][$x]['text'] = $data->text->content;
                                $val[$provider]['success'][$x]['polarity'] = $data->sentiment->polarity;
                                $val[$provider]['success'][$x]['magnitude'] = $data->sentiment->magnitude;
                                $val[$provider]['success'][$x]['score'] = $data->sentiment->score;
                            }   
                            $val[$provider]['success']['polarity'] = $out->documentSentiment->polarity;
                            $val[$provider]['success']['magnitude'] = $out->documentSentiment->magnitude;
                            $val[$provider]['success']['score'] = $out->documentSentiment->score;
                            $val[$provider]['language'] = $out->language;
                        }
                    }
                }     
            }
            if($provider == 'ibm') { $val[$provider] = array();
                if(!isset($opz['text']) || !$opz['text']) $val[$provider]['error'] = 'key <<< text >>> is required';
                if(!isset($val[$provider]['error'])) { 
                    
                    $out = Qurl::query(
                        'https://tone-analyzer-demo.mybluemix.net/api/tone',
                        'https://tone-analyzer-demo.mybluemix.net/', $opz['text']
                    );
                    
                    if(isset($opz['original']) && $opz['original']) $val[$provider]['success'] = $out;
                    else { $out = json_decode($out);
                        if(isset($out->error)) $val[$provider]['error'] = 'language not supported';
                        else { $x = -1;
                            foreach($out->sentences_tone as $data) { $x++;
                                $val[$provider]['success'][$x]['text'] = $data->text;
                                $val[$provider]['success'][$x]['emotion'] = array(
                                    'anger'   => $data->tone_categories[0]->tones[0]->score,
                                    'disgust' => $data->tone_categories[0]->tones[1]->score,
                                    'fear' =>    $data->tone_categories[0]->tones[2]->score,
                                    'joy' =>     $data->tone_categories[0]->tones[3]->score,
                                    'sadness' => $data->tone_categories[0]->tones[4]->score
                                );
                                $val[$provider]['success'][$x]['language'] = array(
                                    'analytical' => $data->tone_categories[1]->tones[0]->score,
                                    'confident'  => $data->tone_categories[1]->tones[1]->score,
                                    'tentative ' => $data->tone_categories[1]->tones[2]->score
                                );
                                $val[$provider]['success'][$x]['social'] = array(
                                    'openness'          => $data->tone_categories[2]->tones[0]->score,
                                    'conscientiousness' => $data->tone_categories[2]->tones[1]->score,
                                    'extraversion'      => $data->tone_categories[2]->tones[2]->score,
                                    'agreeableness'     => $data->tone_categories[2]->tones[3]->score,
                                    'emotional'         => $data->tone_categories[2]->tones[4]->score
                                );
                            }
                            $val[$provider]['success']['emotion'] = array(
                                'anger'   => $out->document_tone->tone_categories[0]->tones[0]->score,
                                'disgust' => $out->document_tone->tone_categories[0]->tones[1]->score,
                                'fear' =>    $out->document_tone->tone_categories[0]->tones[2]->score,
                                'joy' =>     $out->document_tone->tone_categories[0]->tones[3]->score,
                                'sadness' => $out->document_tone->tone_categories[0]->tones[4]->score
                            );
                            $val[$provider]['success']['language'] = array(
                                'analytical' => $out->document_tone->tone_categories[1]->tones[0]->score,
                                'confident'  => $out->document_tone->tone_categories[1]->tones[1]->score,
                                'tentative ' => $out->document_tone->tone_categories[1]->tones[2]->score
                            );
                            $val[$provider]['success']['social'] = array(
                                'openness'          => $out->document_tone->tone_categories[2]->tones[0]->score,
                                'conscientiousness' => $out->document_tone->tone_categories[2]->tones[1]->score,
                                'extraversion'      => $out->document_tone->tone_categories[2]->tones[2]->score,
                                'agreeableness'     => $out->document_tone->tone_categories[2]->tones[3]->score,
                                'emotional'         => $out->document_tone->tone_categories[2]->tones[4]->score
                            );
                        }
                    }
                }
            }
        } if($val) return $val; else return false;
    }        
}