<?php
/**
 * @author Piazzi Raffaele
 * @date 6 gen 2017
 * @release 1.0
 * @license Creative Commons, http://creativecommons.org/licenses/by-nd/4.0/deed.en
 * @title image.analyzer
 * @provider google
 * @key image, original (optional)
 * 
 * ******* DOCUMENTATION *******
 * 
 * Google --> https://cloud.google.com/vision/
 * 
 * ********** EXAMPLE **********
 * 
 * Qdb::out( '*image.analyzer',
 *    array( 'google' ),
 *    array(
 *           'image' => $_FILES['fileToUpload']['tmp_name']
 *              or
 *           'image' => 'http://www.quanticodb.com/logo.jpg'
 *              or
 *           'image' => 'local_image_example.jpg'
 *    )
 * );
 */
class Qai extends Qout
{
    protected static function query($valass, $opz){ require_once('class/Qurl.php'); $val = false;
        foreach($valass as $provider) { $provider = strtolower($provider);
            if($provider == 'google') { $val[$provider] = array();
                if(!isset($opz['image']) || !$opz['image']) $val[$provider]['error'] = 'key <<< image >>> is required';
                if(!isset($val[$provider]['error'])) { $file = file_get_contents($opz['image']);
                    $data = array(
                        "requests" => array (
                            "features" => array(
                                array("type" => "TYPE_UNSPECIFIED", "maxResults" => 50),
                                array("type" => "LANDMARK_DETECTION", "maxResults" => 50),
                                array("type" => "FACE_DETECTION", "maxResults" => 50),
                                array("type" => "LOGO_DETECTION", "maxResults" => 50),
                                array("type" => "LABEL_DETECTION", "maxResults" => 50),
                                array("type" => "TEXT_DETECTION", "maxResults" => 50),
                                array("type" => "SAFE_SEARCH_DETECTION", "maxResults" => 50),
                                array("type" => "IMAGE_PROPERTIES", "maxResults" => 50)
                            ),
                            "image" => array("content" => base64_encode($file))
                        )
                    ); $out = Qurl::query('https://vision.googleapis.com/v1/images:annotate?key=AIzaSyBzeghi0W7mGczap8SC8AmNudYOlwfU-KE','https://cloud.google.com/vision/',$data);
                    if(isset($opz['original']) && $opz['original']) $val[$provider]['success'] = $out;
                    else { $out = json_decode($out);
                        if(isset($out->responses[0]->error)) $val[$provider]['error'] = $out->responses[0]->error->message;
                        else {
                            if(isset($out->responses[0]->safeSearchAnnotation)) {
                                $val[$provider]['success']['safe'] = $out->responses[0]->safeSearchAnnotation;
                            }
                            if(isset($out->responses[0]->labelAnnotations)) { $x = -1;
                                foreach($out->responses[0]->labelAnnotations as $data) { $x++;
                                    $val[$provider]['success']['label'][$x] = array(
                                        'name'  => $data->description,
                                        'score' => $data->score
                                    );
                                }
                            }
                            if(isset($out->responses[0]->logoAnnotations)) { $x = -1;
                                foreach($out->responses[0]->logoAnnotations as $data) { $x++;
                                    $val[$provider]['success']['logo'][$x] = array(
                                        'name'     => $data->description,
                                        'score'    => $data->score,
                                        'position' => array(
                                            array($data->boundingPoly->vertices[0]->x, $data->boundingPoly->vertices[0]->y),
                                            array($data->boundingPoly->vertices[1]->x, $data->boundingPoly->vertices[1]->y),
                                            array($data->boundingPoly->vertices[2]->x, $data->boundingPoly->vertices[2]->y),
                                            array($data->boundingPoly->vertices[3]->x, $data->boundingPoly->vertices[3]->y)
                                        )
                                    );
                                }
                            }
                            if(isset($out->responses[0]->textAnnotations)) { $x = -1;
                                foreach($out->responses[0]->textAnnotations as $data) { $x++;
                                    $val[$provider]['success']['text'][$x] = array(
                                        'name'     => $data->description,
                                        'position' => array(
                                            array($data->boundingPoly->vertices[0]->x, $data->boundingPoly->vertices[0]->y),
                                            array($data->boundingPoly->vertices[1]->x, $data->boundingPoly->vertices[1]->y),
                                            array($data->boundingPoly->vertices[2]->x, $data->boundingPoly->vertices[2]->y),
                                            array($data->boundingPoly->vertices[3]->x, $data->boundingPoly->vertices[3]->y)
                                        )
                                    ); if(isset($data->locale)) $val[$provider]['success']['text'][$x]['language'] = $data->locale;
                                }
                            }
                            if(isset($out->responses[0]->imagePropertiesAnnotation->dominantColors->colors)) { $x = -1;
                                foreach($out->responses[0]->imagePropertiesAnnotation->dominantColors->colors as $data) { $x++;
                                    $val[$provider]['success']['color'][$x] = array(
                                        'rgb' => array($data->color->red, $data->color->green, $data->color->blue),
                                        'score' => $data->score,
                                        'pixel' => $data->pixelFraction
                                    );
                                }
                            }
                        }
                    }
                }
            }
        } if($val) return $val; else return false;
    }        
}

?>