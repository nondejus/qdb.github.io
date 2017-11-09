<?php

namespace Quantico;

class Qmxf extends Qmix
{
    protected static function mixflusso($keyval, $key, $keyk, $keyl, $numkey, $numkeyass, $dati, $ccc, $opz, $valass, $valok)
    {
        $numkeyass[1] = SYS::sort($numkeyass[1]); $w = 0; $ky = [];
         
        if(is_array($numkeyass[1])) { 
            foreach($numkeyass[1] as $key) { $ok = true; $dati = Qout::analisi($key); 
                if($dati[1][0] == '#' || $dati[1][0] == '@') $k = explode(' ',substr($dati[1],1)); 
                else { if($dati[1][0] == '_') $k = explode(' ',substr($dati[1],1)); else $k = explode(' ',$dati[1]); $ok = true; } 
                foreach($k as $x) { $y = explode('.',$x); foreach($y as $z) if(!in_array($z."\n",QKEYBASE)) { $ok = false; break; }} 
                if($ok) { $keyval['K'][$w] = $dati[1]; $ky[$w] = $key; $w++; } else Qerror(0,1,$dati[1]); 
            } $ky = array_reverse($ky); $x = $w;
        } else { 
            $keyval['K'][0] = $numkeyass[1]; $ky[0] = $key; $x = 1; 
        } if(!isset($keyval[0])) return false; 
        
        $dat = []; $si = false;
        foreach($ky as $key) { $x--; $y = $keyval['K'][$x]; 
            if($key[0] == '#' || $key[0] == '@') { 
                for($a=0; $a<$keyk; $a++) { 
                    $val = Qout::Qdbout($numkey[1].' '.$key,$keyval[$a],$opz); 
                    if($val) { 
                        if($opz === _T1_ || $opz === _T2_) { 
                            for($b=0; $b<$val['N']; $b++) { 
                                $keyval["$y.t.$a"][$b] = $val["t.$b"]; 
                                unset($val["t.$b"]); 
                            }
                        } 
                        $keyval["$y.$a"] = $val; 
                        unset($keyval["$y.$a"]['N']); 
                        unset($keyval["$y.$a"]['T']); 
                        $keyval["N.$y.$a"] = $val['N']; 
                        $keyval["T.$y.$a"] = $val['T']; 
                        if(isset($dat["N.$y"])) $dat["N.$y"]++; else $dat["N.$y"] = 1; 
                    }
                }
            } else { $si = true; 
                if($valass == null || $valass === _T1_ || $valass === _T2_) { 
                    if(strpos($valok,'#') > 1) { 
                        for($a=0; $a<$keyk; $a++) { $w = 0; 
                            if($opz) { 
                                for($b=0; $b<$keyval["N.#$numkey[1].$a"]; $b++) { 
                                    $val = Qout::Qdbout("$numkey[1] $key",$keyval["#$numkey[1].$a"][$b],$opz); 
                                    $keyval["$y.$a"][$b] = $val[$key]; 
                                    $keyval["$y.t.$a"][$b] = $val["t.$key"]; 
                                    if($keyval["$y.$a"][$b] != '') $w++; 
                                } 
                                $keyval["N.$y.$a"] = $w; 
                            } else { 
                                for($b=0; $b<$keyval["N.#$numkey[1].$a"]; $b++) { 
                                    $keyval["$y.$a"][$b] = Qout::Qdbout("$numkey[1] $key",$keyval["#$numkey[1].$a"][$b]); 
                                    if($keyval["$y.$a"][$b] != '') $w++; 
                                } 
                                $keyval["N.$y.$a"] = $w; 
                            }
                        } 
                        $keyval["N.$y"] = $keyval["N.#$numkey[1]"]; 
                    } else { $w = 0; 
                        for($a=0; $a<$keyk; $a++) { 
                            if($opz) { 
                                if($ccc) $val = Qout::Qdbout("@$numkey[1] $key",$keyval[$a],$opz); else $val = Qout::Qdbout("$numkey[1] $key",$keyval[$a],$opz); 
                                $keyval[$y][$a] = $val[$y]; 
                                $keyval["t.$y"][$a] = $val["t.$y"]; 
                            } else { 
                                if($ccc) $keyval[$y][$a] = Qout::Qdbout("@$numkey[1] $key",$keyval[$a]); else $keyval[$y][$a] = Qout::Qdbout("$numkey[1] $key",$keyval[$a]); 
                            } 
                            if($keyval[$y][$a] != '') $w++; 
                        } 
                        $keyval["N.$y"] = $w; 
                    }
                } else { $w = 0; 
                    for($a=0; $a<$keyk; $a++) { 
                        if($opz) { 
                            $val = Qout::Qdbout("$numkey[1] $key",$keyval[$a],$opz); 
                            $keyval[$y][$a] = $val[$y]; 
                            $keyval["t.$y"][$a] = $val["t.$y"]; 
                        } else $keyval[$y][$a] = Qout::Qdbout("$numkey[1] $key",$keyval[$a]); 
                        if($keyval[$y][$a] != '') $w++; 
                    } 
                    $keyval["N.$y"] = $w; 
                }
            }
        } if($si) { 
            for($a=0; $a<$keyk; $a++) { 
                if($opz) unset($keyval["#$numkey[1].t.$a"]); 
                unset($keyval["#$numkey[1].$a"]); 
                unset($keyval["N.#$numkey[1].$a"]); 
                unset($keyval["T.#$numkey[1].$a"]); 
            } 
            unset($keyval["N.#$numkey[1]"]); 
        }
        
        if($dat) $keyval = array_merge($keyval,$dat); 
        $keyval['N'] = $keyk; 
        $keyval['T'] = $keyl; 
        if($numkeyass[14]) $numkeyass[1] = $numkeyass[14]; else $numkeyass[18] = $ky;
         
        if($keyval['N'] > 0) {
            if($numkey[14]) $numkey[14] = false; $Qdb = new SYS; 
            return $Qdb->_flusso($numkeyass,$keyval,$keyval['T'],$keyval['N'],0,$numkey); 
        } return false;
    }
}