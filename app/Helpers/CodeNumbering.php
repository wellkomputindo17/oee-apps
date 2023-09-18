<?php

namespace App\Helpers;

class CodeNumbering
{
    public static function custom_code($table, $field)
    {
        $month = date('m');
        $year = date('y');
        $format = "PRD-{$month}{$year}";

        $count_invoice = $table::select("{$field}")->where("{$field}", 'like', "%{$format}%")->count() + 1;
        if (strlen($count_invoice) <= 1) {
            $format .= "000" . $count_invoice;
        } else if (strlen($count_invoice) <= 2) {
            $format .= "00" . $count_invoice;
        } else if (strlen($count_invoice) <= 3) {
            $format .= "0" . $count_invoice;
        } else {
            $format .= (string)$count_invoice;
        }

        return $format;
    }

    public static function custom_code_do($table, $field)
    {
        $month = date('m');
        $year = date('y');
        $format = "{$month}{$year}";

        $count_invoice = $table::select("{$field}")->where("{$field}", 'like', "%{$format}%")->withTrashed()->count() + 1;
        if (strlen($count_invoice) <= 1) {
            $format .= "000" . $count_invoice;
        } else if (strlen($count_invoice) <= 2) {
            $format .= "00" . $count_invoice;
        } else if (strlen($count_invoice) <= 3) {
            $format .= "0" . $count_invoice;
        } else {
            $format .= (string)$count_invoice;
        }

        return $format;
    }
}
