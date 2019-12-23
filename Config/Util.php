<?php

class Util{

    public static function convert_from_latin1_to_utf8_recursively($dat)
    {
    if (is_string($dat)) {
        return utf8_encode($dat);
    } elseif (is_array($dat)) {
        $ret = [];
        foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);

        return $ret;
    } elseif (is_object($dat)) {
        foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

        return $dat;
    } else {
        return $dat;
    }
    }
}

?>