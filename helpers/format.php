<?php

/**
 * Format Class
 */
class Format
{

    public function formatDate($date)
    {
        return date('F j, Y, g:i a', strtotime($date));
    }
    public function formatDateNew($date)
    {
        return date('g:i A\, d-m-Y', strtotime($date));
    }
    public function formatDateReview($timestamp)
    {
        return date('g:i A\, d-m-Y', $timestamp);
    }
    //Rút ngắn tiêu đề
    public function textShorten($text, $limit = 400)
    {
        if (strlen($text) >= $limit) {
            $text = $text . " ";
            $text = substr($text, 0, $limit);
            $text = substr($text, 0, strrpos($text, ' '));
            $text = $text . ".....";
            return $text;
        } else {
            return $text;
        }
    }

    public function validation($data)
    {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function format_currency($n = 0)
    {
        $n = (string)$n;
        $n = strrev($n);
        $res = '';
        for ($i = 0; $i < strlen($n); $i++) {
            if ($i % 3 == 0 && $i != 0) {
                $res .= '.';
            }
            $res .= $n[$i];
        }
        $res = strrev($res);
        return $res;
    }
}
