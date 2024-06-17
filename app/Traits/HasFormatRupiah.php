<?php

namespace App\Traits;


trait HasFormatRupiah {


    public function formatRupiah($field, $prefix = 'Rp. ')
    {
        if (isset($this->attributes[$field])) {
            $nominal = $this->attributes[$field];
            return $prefix . number_format($nominal, 0, ',', '.');
        } else {
            return $prefix . '0';
        }
    }
}

?>
