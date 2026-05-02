<?php

if (!function_exists('formatNPWP')) {
    function formatNPWP($npwp)
    {
        $npwp = preg_replace('/[^0-9]/', '', $npwp);

        if (strlen($npwp) == 15) {
            return substr($npwp, 0, 2) . '.' .
                substr($npwp, 2, 3) . '.' .
                substr($npwp, 5, 3) . '.' .
                substr($npwp, 8, 1) . '-' .
                substr($npwp, 9, 3) . '.' .
                substr($npwp, 12, 3);
        }

        return $npwp;
    }
}
