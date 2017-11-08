<?php

namespace Quantico;

class Qnow extends Qout
{
    private static function aggiorna($val,$k,$kv) { if(is_array($val) && $k) { $pos = array_keys($val,$k); foreach($pos as $p) $val[$p] = $kv; return $val; } else return false; }
    
    protected static function adesso($val){ global $Qdatabase; global $Qpostime; $per = $Qdatabase.$Qpostime; $keyper = [];
        if(is_array($val)) $key = SYS::u($val); else $key = array($val); 
        foreach($key as $k) { 
            if($k[10] != ':') { 
                $z = substr($k,0,3).'/'.substr($k,3,$k[12]); 
                $per = "$Qdatabase$Qpostime/$z"; 
                $pern = "$per/keyn.php"; 
                $perv = "$per/keyv.php";
                if(isset($keyper[$z.'v'])) { $ok = true; 
                    while($ok){ $j = array_search($k,$keyper[$z.'v']); 
                        if($j > 1) { 
                            $kv = $keyper[$z.'n'][$j]; 
                            $z = substr($kv,0,3).'/'.substr($kv,3,$kv[12]); 
                            if(!isset($keyper[$z.'v'])) { $val = Qnow::aggiorna($val,$k,$kv); 
                                $per = "$Qdatabase$Qpostime/$z"; 
                                $pern = "$per/keyn.php"; 
                                $perv = "$per/keyv.php"; 
                                if(file_exists($pern)){ 
                                    $keyper[$z.'n'] = file($pern); 
                                    $keyper[$z.'v'] = file($perv); 
                                } else $ok = false; 
                            } else $val = Qnow::aggiorna($val,$k,$kv); $k = $kv; 
                        } else $ok = false; 
                    }
                } else { 
                    if(file_exists($pern)){ $ok = true; 
                        $keyper[$z.'n'] = file($pern); 
                        $keyper[$z.'v'] = file($perv);
                        while($ok){ $j = array_search($k,$keyper[$z.'v']); 
                            if($j > 1) { 
                                $kv = $keyper[$z.'n'][$j]; 
                                $z = substr($kv,0,3).'/'.substr($kv,3,$kv[12]); 
                                if(!isset($keyper[$z.'v'])) { 
                                    if(is_array($val)) $val = Qnow::aggiorna($val,$k,$kv); 
                                    $per = "$Qdatabase$Qpostime/$z"; 
                                    $pern = "$per/keyn.php"; 
                                    $perv = "$per/keyv.php"; 
                                    if(file_exists($pern)){ 
                                        $keyper[$z.'n'] = file($pern); 
                                        $keyper[$z.'v'] = file($perv); 
                                    } else $ok = false; 
                                } else $val = Qnow::aggiorna($val,$k,$kv); $k = $kv; 
                            } else $ok = false; 
                        }
                    }
                }
            }
        } if(is_array($val)) return $val; else return $k;
    }
}