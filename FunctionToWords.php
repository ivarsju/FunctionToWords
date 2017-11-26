<?php

$numb = array('nulle', 'viens', 'divi', 'trīs', 'četri', 'pieci', 'seši', 'septiņi', 'astoņi', 'deviņi', 'desmit');
$tens = array('', 'vien', 'div', 'trīs', 'četr', 'piec', 'seš', 'septiņ', 'astoņ', 'deviņ');
$bigones = array(100 => 'simti', 1000 => 'tūkstoši', 1000000 => 'miljoni', 1000000000 => 'miljardi');

function toWords($num)
{
    global $numb, $tens, $bigones, $santimes; 
    $num      = number_format($num, 2, '.', '');
    $numParts = explode('.', $num);
    $lsString = '';
    
    //apstrādā centus
    if ($numParts[1] > 0) {
        $santString = tenWords($numParts[1]) .
            (($numParts[1] % 10 == 1 && $numParts[1] != 11) ? 'cents ' : 'centi ');
    } else {
        $santString = 'nulle centi'; 
    }
    
    //apstrādā eiro
    
    $thousands = floor($numParts[0] / 1000);
    if (99 < $thousands) {
        return ('ERROR: Nevar konvertēt lielāku summu par 99 999.99');
    }
    
    if (!empty($thousands)) {
        $lsString = tenWords($thousands) .
            (($thousands % 10 == 1 && $thousands != 11) ? ' tūkstotis ' : 'tūkstoši ');
    }
    
    $hundreds = floor(substr($numParts[0], -3) / 100);
    
    if (!empty($hundreds)) {
        $lsString .= $numb[intval($hundreds)] .
            ($hundreds % 10 == 1 ? ' simts ' : ' simti ');
    }
    
    if (strlen($numParts[0]) == 1) {
        $tenLats = substr($numParts[0], -1);
    } else {
        $tenLats = substr($numParts[0], -2);
    }
    
    if ($tenLats > 0 || empty($lsString)) {
        $lsString .= tenWords($tenLats);
    }
    
    $lsString .= (($tenLats % 10 == 1 && $tenLats != 11) ? 'eiro' : 'eiro');
    
    $text = $lsString . ' ' . $santString;
    
    return $text; 
}

function tenWords($num)
{
    global $tens, $numb; 
    if ($num > 19) { 
        $firstDigit = substr($num, 0, 1); 
        $secondDigit = substr($num, 1, 1); 
        if ($secondDigit == 0)
            return $tens[$firstDigit] . 'desmit ';
        else
            return $tens[$firstDigit] . 'desmit ' . $numb[$secondDigit] . ' ';
    } elseif ($num <= 19 AND $num > 10) { 
        return $tens[$num % 10] . 'padsmit '; 
    } elseif ($num <= 10) { 
        return $numb[intval($num)] . ' '; 
    }
}
?>