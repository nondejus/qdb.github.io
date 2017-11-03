<?php

namespace Quantico;

class Qto extends Qout
{
    private static function ora($ora, $val, $v=false) {
        
        $t = explode('-',$val); if($v) $val = $v;
        $o = explode('.',$val);
        $v = [0,0,0,23,59,59]; $val = false; 
        
        if(!strpos($o[0], '-')) { 
            if(count($t) == 1) $t = explode('-', date('d-m-Y', $ora)); 
            if(isset($o[0]) && is_numeric($o[0])) { $v[0] = $o[0]; $v[3] = $v[0]; } 
            if(isset($o[1]) && is_numeric($o[1])) { $v[1] = $o[1]; $v[4] = $v[1]; } 
            if(isset($o[2]) && is_numeric($o[2])) { $v[2] = $o[2]; $v[5] = $v[2]; }
        } 
        if(isset($t[0]) && isset($t[1]) && isset($t[2]) && is_numeric($t[0]) && is_numeric($t[1]) && is_numeric($t[2])) { 
            if(strlen($t[0]) > 0 && strlen($t[1]) > 0 && strlen($t[2]) == 4) { 
                $val[0] = mktime($v[0], $v[1], $v[2], $t[1], $t[0], $t[2]); 
                $val[1] = mktime($v[3], $v[4], $v[5], $t[1], $t[0], $t[2]); 
                $val[2] = $t[0].$t[1].$t[2]; 
            } 
            elseif(strlen($t[0]) == 4 && strlen($t[1]) > 0 && strlen($t[2]) > 0) { 
                $val[0] = mktime($v[0], $v[1], $v[2], $t[1], $t[2], $t[0]); 
                $val[1] = mktime($v[3], $v[4], $v[5], $t[1], $t[2], $t[0]); 
                $val[2] = $t[2].$t[1].$t[0]; 
            } 
            return $val; 
        } 
        return false; 
    }
    // $val[3] = Tempo PARTENZA     $val[4] = Tempo ARRIVO     $val[5] = STATO ---> true = MAX:min | false = min:MAX
    protected static function range($val, $key, $a, $b) { 
        
        if(!$val[10]) $val[1] = substr($key,0,$a); 
        $val[8] = trim(substr($key, $a+1, $b-$a-1)); 
        $d = explode(':',$val[8]); $ora = SYS::time(); 
        
        if(count($d) == 1) {
            if(strpos($val[8],'=')) return true;
            else { $val[5] = true;
                if(strpos($val[8],'-')) {
                    $v = Qto::ora($ora,$val[8]);
                    $val[3] = $v[0];
                    $val[4] = $v[1];
                } else { $val[4] = $ora;
                    $o = explode('.',$val[8]);
                    if(isset($o[2])) $val[3] = $ora - $o[0]*3600 - $o[1]*60 - $o[2];
                    elseif(isset($o[1])) $val[3] = $ora - $o[0]*60 - $o[1];
                    elseif(isset($o[0])) $val[3] = $ora - $o[0];
                }
            }
        } elseif(count($d) == 2) {
            $e1 = explode('=',$d[0]);
            $e2 = explode('=',$d[1]);
            if(count($e1) == 1 && count($e2) == 1) {
                $v1 = Qto::ora($ora,$d[0]); $val[3] = $v1[0]; $t1 = $v1[2];
                $v2 = Qto::ora($ora,$d[1]); $val[4] = $v2[1]; $t2 = $v1[2];
                if($val[4] < $val[3]) { 
                    $val[5] = true; 
                    $val[3] = $v2[0]; 
                    $val[4] = $v1[1]; 
                }
            } elseif(count($e1) == 2 && count($e2) == 2) {
                if(strpos($e1[0],'-')) {
                    $v1 = Qto::ora($ora,$e1[0],$e1[1]);
                    $val[3] = $v1[0];
                }
                if(strpos($e1[1],'-')) {
                    $v1 = Qto::ora($ora,$e1[1],$e1[0]);
                    $val[3] = $v1[0];
                }
                if(strpos($e2[0],'-')) {
                    $v2 = Qto::ora($ora,$e2[0],$e2[1]);
                    $val[4] = $v2[1];
                }
                if(strpos($e2[1],'-')) {
                    $v2 = Qto::ora($ora,$e2[1],$e2[0]);
                    $val[4] = $v2[1];
                }
                if($val[4] < $val[3]) { 
                    $val[5] = true; 
                    $val[3] = $v2[0]; 
                    $val[4] = $v1[1]; 
                }
            }
        } else return false; 
        return $val;
    }
}