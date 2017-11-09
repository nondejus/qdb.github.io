<?php

namespace Quantico;

class Qfls extends Qout
{
    protected static function flusso($numkey, $keyval, $tot, $n, $opz=0, $numkeyass=0)
    {
        $ok = true; $si = false;
        if(!isset($numkey[13])) $numkey[13] = null; 
        if(!isset($numkey[14])) $numkey[14] = null; 
        if(!isset($numkey[17])) $numkey[17] = null;

        if(is_array($numkeyass)) { 
            if($numkeyass[14] || $numkeyass[17]) { 
                if(!$opz) { $ok = false; 
                    if(is_array($numkey[18])) $numkey[18][] = $numkeyass[1]; else $numkey[18]= array($numkeyass[1]); 
                    for($a=0; $a<18; $a++) $numkey[$a] = $numkeyass[$a]; 
                    for($a=0; $a<$n; $a++) $keyval[$numkey[1]][$a] = $keyval[$a]; 
                    if(isset($keyval['t.0'])) { for($a=0; $a<$n; $a++) $keyval['t.'.$numkey[1]][$a] = $keyval[$a]; }
                } else $numkey = $numkeyass; 
            } else { 
                if($numkey[9]) { 
                    if(!$numkey[18] || is_array($numkey[18])) $ok = false; 
                    if($numkey[17]) $ok = true; 
                }
            }
        } 
        
        if($numkey[14] == '' && $numkey[16] == '') { 
            if(is_array($numkey[18])) { $t = $numkey[18]; 
                foreach($t as $x) { $y = Qout::analisi($x); 
                    if($y[14]) { $ok = false; if($y[18]) { $numkey[18] = true; $ok = true; } else $numkey[18] = false; $numkey[14] = $y[14]; $numkey[1] = $y[1]; } 
                    if($y[17]) { $numkey[1] = $y[16]; $numkey[16] = $y[16]; $numkey[17] = $y[17]; $ok = true; $si = true; break; }
                }
            }
        }
         
        if($numkey[14]) {
            if($opz == 1) { 
                if($numkey[1][0] == '@') { 
                    for($a=0; $a<$n; $a++) $keyval[$numkey[1]][$a] = $keyval['p.'.$a]; 
                } else { 
                    for($a=0; $a<$n; $a++) $keyval[$numkey[1]][$a] = $keyval[$a]; 
                }
            } 
            elseif($opz == 2) { 
                if($numkey[1][0] == '#' || $numkey[1][0] == '@') { 
                    for($a=0; $a<$n; $a++) $keyval[$numkey[1]][$a] = $keyval[$a]; 
                }
            } else { 
                if($numkey[1][0] == '#' || $numkey[1][0] == '@') { 
                    for($a=0; $a<$n; $a++) { 
                        if(isset($keyval['N.'.$numkey[1].'.'.$a])) { 
                            for($b=0; $b<$keyval['N.'.$numkey[1].'.'.$a]; $b++) $keyval[$numkey[1]][] = $keyval[$numkey[1].'.'.$a][$b]; 
                        }
                    }
                }
            } $kk['K'][0] = $numkey[1];
            if(!isset($keyval[$numkey[1]])) return false;
            
            if(isset($numkey[20])) { $x = []; 
                foreach($keyval[$numkey[1]] as $a) { $a = SYS::trak($a,true); if(is_array($a)) $x = array_merge($x,$a); else $x[] = $a; } 
                $keyval[$numkey[1]] = $x; 
            } 
            for($a=0, $u=count($keyval[$numkey[1]]); $a<$u; $a++) if($keyval[$numkey[1]][$a] === false || $keyval[$numkey[1]][$a] === null) $keyval[$numkey[1]][$a] = ''; 
            $k = array_count_values($keyval[$numkey[1]]); $av = array_keys($k); $an = array_values($k); $n = 0; 
            for($a=0, $u=count($av); $a<$u; $a++) { $kk[$numkey[1]][$a] = $av[$a]; $kk['N.'.$numkey[1]][$a] = $an[$a]; $n += $an[$a]; }

            if($numkey[17]) { 
                if($numkey[18] && $ok) { // ======================================================================================= !KEY+! , !KEY-!
                    if($numkey[17] == 1) array_multisort($kk['N.'.$numkey[1]],SORT_ASC,SORT_NUMERIC,$kk[$numkey[1]]); // ========== +
                    elseif($numkey[17] == 2) array_multisort($kk['N.'.$numkey[1]],SORT_DESC,SORT_NUMERIC,$kk[$numkey[1]]); // ===== -
                } else { // ======================================================================================================= !KEY+  , !KEY-
                    if($numkey[17] == 1) array_multisort($kk[$numkey[1]],SORT_ASC,SORT_FLAG_CASE,$kk['N.'.$numkey[1]]); // ======== +
                    elseif($numkey[17] == 2) array_multisort($kk[$numkey[1]],SORT_DESC,SORT_FLAG_CASE,$kk['N.'.$numkey[1]]); // === -
                }
            } 
            $kk['T.'.$numkey[1]] = $n; 
            $kk['N'] = count($av); 
            $kk['T'] = $tot; 
            if($kk['T'] > 0) return $kk;
        }
        else
        { 
            if($numkey[17] == '' && is_array($numkey[13])) { 
                foreach($numkey[13] as $a) { $b = $a[strlen($a)-1]; 
                    if($b == '+') { $numkey[17] = 1; $numkey[16] = substr($a,0,-1); $j = array_search($a,$numkey[18]); 
                        if($j !== false) $numkey[18][$j] = $numkey[16]; break; 
                    } 
                    elseif($b == '-') { $numkey[17] = 2; $numkey[16] = substr($a,0,-1); $j = array_search($a,$numkey[18]); 
                        if($j !== false) $numkey[18][$j] = $numkey[16]; break; 
                    }
                } 
                if(!isset($keyval[$numkey[16]])) return Qerror(2, 30, $a); 
            } 
            if($numkey[17]) { $t = false; $x = -1; 
                if($opz) { 
                    for($a=0; $a<$n; $a++) $keyval[$numkey[1]][$a] = $keyval[$a]; 
                    if(isset($keyval['-.0'])) $numkey[18] = array('-','p'); else $numkey[18] = []; 
                } else { 
                    if(is_array($numkey[18])) { $b = $numkey[16]; 
                        if($si) { if($numkey[17] == 1) $b .= '+'; else $b .= '-'; } $j = array_search($b,$numkey[18]); 
                        if($j !== false) unset($numkey[18][$j]); $numkey[18] = SYS::sort($numkey[18]); 
                    }
                } 
                if(isset($keyval['t.0']) || $numkey[0] == '@2') { $t = true; if($opz) $numkey[18][] = 't'; } for($a=0; $a<$n; $a++) $keyval['Q'][$a] = $a;
                if(isset($keyval[$numkey[16]])) $si = $numkey[16]; elseif(isset($keyval[$numkey[1]])) $si = $numkey[1]; else return false;
                
                if($t && !$opz) { // ==================================================================================================== KEY+ , KEY- (tempo)
                    if($numkey[17] == 1) array_multisort($keyval[$si],SORT_ASC,SORT_FLAG_CASE,$keyval['Q'],$keyval["t.$si"]); // ======== + 
                    elseif($numkey[17] == 2) array_multisort($keyval[$si],SORT_DESC,SORT_FLAG_CASE,$keyval['Q'],$keyval["t.$si"]); // === - 
                } else { // ============================================================================================================= KEY+ , KEY-
                    if($numkey[17] == 1) array_multisort($keyval[$si],SORT_ASC,SORT_FLAG_CASE,$keyval['Q']); // ========================= +
                    elseif($numkey[17] == 2) array_multisort($keyval[$si],SORT_DESC,SORT_FLAG_CASE,$keyval['Q']); // ==================== -
                }
                 
                if($numkey[0] != '@1' && $numkey[0] != '@2') { 
                    foreach($keyval['Q'] as $a) { $x++; $kk[$x] = $keyval[$a]; if($t && !$opz) $kk["t.$x"] = $keyval["t.$a"]; }
                } 
                if($opz) { 
                    foreach($numkey[18] as $k) { $x = -1; foreach($keyval['Q'] as $a) { $x++; $kk["$k.$x"] = $keyval["$k.$a"]; }}
                } else { if(isset($keyval['K'])) $kk['K'] = SYS::u($keyval['K']); 
                    if($ok) { $kk[$si] = $keyval[$si]; if($t) $kk["t.$si"] = $keyval["t.$si"]; $kk["N.$si"] = $keyval["N.$si"]; }
                    if(isset($kk['K'])) { 
                        foreach($kk['K'] as $k) { $x = -1; 
                            foreach($keyval['Q'] as $a) { $x++; 
                                if($k[0] == '#' || $k[0] == '@') { 
                                    if(isset($keyval["$k.$a"])) { 
                                        $kk["$k.$x"] = $keyval["$k.$a"]; 
                                        if($t) $kk["$k.t.$x"] = $keyval["$k.t.$a"]; 
                                        $kk["N.$k.$x"] = $keyval["N.$k.$a"]; 
                                        $kk["T.$k.$x"] = $keyval["T.$k.$a"]; 
                                    }
                                } else { 
                                    if($si != $k) { $kk[$k][$x] = $keyval[$k][$a]; if($t) $kk["t.$k"][$x] = $keyval["t.$k"][$a]; }
                                }
                            } if(isset($keyval["N.$k"])) $kk["N.$k"] = $keyval["N.$k"]; else $kk["N.$k"] = 0; 
                        }
                    }
                } 
                $kk['N'] = $n; 
                $kk['T'] = $tot; 
                if($kk['T'] > 0) return $kk; 
            } 
            $keyval['N'] = $n; // $keyval['P'] = SYS::$partial; 
            $keyval['T'] = $tot; 
            if($keyval['T'] > 0) return $keyval; 
        }
        return false;
    }
}