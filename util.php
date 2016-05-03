<?php

class Util {

    public static escape($str, $type='url') {
        switch ($type) {
            case 'url':
                return urlencode($str);
            default:
                throw new Exception('Unsupported escape type');
        }
    }

}

?>
