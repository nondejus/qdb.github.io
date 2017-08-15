<?php

namespace Quantico;

function Qerror($type, $id, $val=NULL, $valass=NULL, $key=NULL, $keyass=NULL)
{
    $Qdb[0] = 'Q\DB::key -> ERROR | :::';
    $Qdb[1] = 'Q\DB::in -> ERROR | :::';
    $Qdb[2] = 'Q\DB::out -> ERROR | :::';
    $Qdb[3] = 'Q\DB::del -> ERROR | :::';
    $Qdb[4] = 'Q\DB::ver -> ERROR | :::';
    $Qdb[5] = 'Q\DB -> AUTO Recovery | :::';
    
    $msg[0] = "$Qdb[$type] File Not Found ::: | $val";
    $msg[1] = "$Qdb[$type] Not Found ::: | $val";
    $msg[2] = "$Qdb[$type] Not be Entered because it is Lower than the Other Values ::: | $val";
    $msg[3] = "$Qdb[$type] The Value is an Array ::: | $val";
    $msg[4] = "$Qdb[$type] This KEY is an Array ::: |";
    $msg[5] = "$Qdb[$type] The Value KEY Not Exist ::: | $val";
    $msg[6] = "$Qdb[$type] $val ::: | The Value of this Multiple KEY can Only be Numeric or Alhanumeric !!! NO MIX !!!";
    $msg[7] = "$Qdb[$type] The Primary KEY ---> $keyass: $valass ---> already has the associated table ---> $key: $val ::: |";
    $msg[8] = "$Qdb[$type] has two possible solutions: NOTHING or an Array (KEY => value) ::: | #$val";
    $msg[9] = "$Qdb[$type] The Value of KEY is Not Entered ::: | $val";
    $msg[10] = "$Qdb[$type] KEY in the Array can Not be Numeric ::: |";
    $msg[11] = "$Qdb[$type] The Value of KEY is Not Correctly ::: | $val";
    $msg[12] = "$Qdb[$type] $val ---> Can Only have Numeric Values possibly with Automatic ID using the command Q\DB::in('#$val') ::: |";
    $msg[13] = "$Qdb[$type] $val ---> This KEY is not present in this File: $valass ::: |";
    $msg[14] = "$Qdb[$type] $val ::: | File Error";
    $msg[15] = "$Qdb[$type] $val ::: | Encrypted File Corrupt: Position ( $valass ) & File: $key";
    $msg[16] = "$Qdb[$type] 258 Secrets KEY are Corrupt ::: |";
    $msg[17] = "$Qdb[$type] $val ::: | $valass";
    $msg[18] = "$Qdb[$type] FAILED ::: | QuanticoDB is !!! BLOCKED !!!";
    $msg[20] = "$Qdb[$type] Protect KEY Database is INCORRECT ::: |";
    $msg[30] = "$Qdb[$type] This Syntax is Incorrect ::: | $val";
    
    file_put_contents(dirname(__DIR__).'/Quantico_errors.log', date('[d-M-Y H:i:s', SYS::time()).' UTC] '.$msg[$id].chr(13).chr(10), FILE_APPEND);
    
    return false;
}

?>