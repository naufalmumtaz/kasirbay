<?php

namespace App\Helper;

class Helpers {
    public static function rupiah_format($rupiah) {
        return "Rp " . number_format($rupiah,2,',','.');
    }
}
