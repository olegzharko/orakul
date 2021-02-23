<?php

namespace App\Http\Controllers\Factory;

use Illuminate\Http\Request;

use App\Models\DayConvert;
use App\Models\GenderWord;
use App\Models\KeyWord;
use App\Models\MonthConvert;
use App\Models\YearConvert;
use App\Nova\NumericConvert;

class ConvertController extends GeneratorController
{
    public function __construct()
    {

    }

    public function test_price_convert()
    {
        $i = 1;
        while($i < 10) {
            $this->convert_price_int_part_to_string(rand(0, 1), 'dollar');
            $i++;
        }
    }

    public function convert_price_int_part_to_string($start_value, $currency)
    {
        $gender = null;
        $result  = null;
        $str = null;
        $price = null;

        $price = intval($start_value / 100);

        $hundreds = $price % 1000;
        $price = intval($price / 1000);

        $thousands = $price % 1000;
        $price = intval($price / 1000);

        $million = $price % 1000;
        $price = intval($price / 1000);

        $gender = $this->get_currency_gender($currency);

        /* старт сотень */
        $number = $hundreds % 100;
        if ($number) {
            if ($number < 11 || $number > 19) {
                $number = $hundreds % 10;
            }
            if ($number == '1') {
                $str = GenderWord::where('alias', "number_one")->value($gender);
            } elseif ($number == '2'){
                $str = GenderWord::where('alias', "number_two")->value($gender);
            } else {
                $str = \App\Models\NumericConvert::where('original', $number)->value('title');
            }

            $result = $str . " " . $result;
        }

        $currency_title = $this->get_currency_title($number, $currency);

        $hundreds = $hundreds - $number;

        $number = $hundreds % 100;
        if ($number) {
            $str = \App\Models\NumericConvert::where('original', $number)->value('title');
            $result = $str . " " . $result;
        }
        $hundreds = $hundreds - $number;

        $number = $hundreds % 1000;
        if ($number) {
            $str = \App\Models\NumericConvert::where('original', $number)->value('title');
            $result = $str . " " . $result;
        }
        /* кінець сотень */

        /* старт тисячі */
        $number = $thousands % 100;
        if ($number) {
            if ($number < 11 || $number > 19) {
                $number = $thousands % 10;
            }

            if ($number == '1') {
                $str = GenderWord::where('alias', "number_one")->value('female') . " " . KeyWord::where('key', 'thousand')->value('title_n');
            } elseif ($number == '2') {
                $str = GenderWord::where('alias', "number_two")->value('female') . " " . KeyWord::where('key', 'thousand')->value('title_r');
            } elseif ($number >= '3' && $number <= '4') {
                $str = \App\Models\NumericConvert::where('original', $number)->value('title') . " " . KeyWord::where('key', 'thousand')->value('title_r');
            } else {
                $str = \App\Models\NumericConvert::where('original', $number)->value('title') . " " . GenderWord::where('alias', "thousand_four_infinity")->value('many');
            }

            $result = $str . " " . $result;
        }
        $thousands = $thousands - $number;

        $number = $thousands % 100;
        if ($number) {
            $str = \App\Models\NumericConvert::where('original', $number)->value('title');
            $result = $str . " " . $result;
        }
        $thousands = $thousands - $number;

        $number = $thousands % 1000;
        if ($number) {
            $str = \App\Models\NumericConvert::where('original', $number)->value('title');
            $result = $str . " " . $result;
        }
        /* кінець тисячі */

        /* старт мільйонів */
        $number = $million % 100;
        if ($number) {
            if ($number < 11 || $number > 19) {
                $number = $million % 10;
            }

            if ($number == '1') {
                $str = GenderWord::where('alias', "number_one")->value('male') . " " . KeyWord::where('key', 'million')->value('title_n');
            } elseif ($number == '2') {
                $str = GenderWord::where('alias', "number_two")->value('male') . " " . KeyWord::where('key', 'million')->value('title_r');
            } elseif ($number >= '3' && $number <= '4') {
                $str = \App\Models\NumericConvert::where('original', $number)->value('title') . " " . KeyWord::where('key', 'million')->value('title_r');
            } else {
                $str = \App\Models\NumericConvert::where('original', $number)->value('title') . " " . GenderWord::where('alias', "million_four_infinity")->value('many');
            }

            $result = $str . " " . $result;
        }
        $million = $million - $number;

        $number = $million % 100;
        if ($number) {
            $str = \App\Models\NumericConvert::where('original', $number)->value('title');
            $result = $str . " " . $result;
        }
        $million = $million - $number;

        $number = $million % 1000;
        if ($number) {
            $str = \App\Models\NumericConvert::where('original', $number)->value('title');
            $result = $str . " " . $result;
        }
        /* кінець мільйонів */

        $result = trim($result);
        $result = "($result) $currency_title";

        echo $start_value . "  " . $result . "<br>";

        return $result;
    }

    public function convert_price_cent_part_to_string($start_value, $currency)
    {
        $gender = null;
        $result  = null;
        $str = null;
        $price = null;

        $price = $start_value;
        $gender = $this->get_currency_gender($currency);

        $cents =  $start_value % 100;
        $number = $cents % 100;
        if ($number) {
            if ($number < 11 || $number > 19) {
                $number = $cents % 10;
            }
            if ($number == '1') {
                $str = GenderWord::where('alias', "number_one")->value($gender);
            } elseif ($number == '2'){
                $str = GenderWord::where('alias', "number_two")->value($gender);
            } else {
                $str = \App\Models\NumericConvert::where('original', $number)->value('title');
            }

            $result = $str . " " . $result;
        }
        $cents = $cents - $number;

        if ($currency == 'dollar')
            $currency_title = $this->get_currency_title($number, 'cent');
        else
            $currency_title = $this->get_currency_title($number, 'kop');

        $number = $cents % 100;
        if ($number) {
            $str = \App\Models\NumericConvert::where('original', $number)->value('title');
            $result = $str . " " . $result;
        }

        echo $start_value . "    " . $result . "<br>";

        $result = trim($result);
        if ($result)
            $result = "($result) $currency_title";
        else
            $result = "$currency_title";

        return $result;
    }

    public function get_currency_gender($currency)
    {
        $gender = "female";

        if ($currency == 'dollar') {
            $gender = "male";
        } elseif ($currency == 'grn') {
            $gender = "female";
        }

        return $gender;
    }

    public function get_number_format_thousand($price)
    {
        $price_thousand = null;
        $price_thousand = number_format(floor($price / 100), 0, ".",  " " );

        return $price_thousand;
    }

    public function get_number_format_decimal($price)
    {
        $price_decimal = null;
        $price_decimal = sprintf("%02d", number_format($price % 100));

        return $price_decimal;
    }


    public function get_convert_price($price, $type)
    {
        $result = null;

        $integer = $this->get_number_format_thousand($price);
        $str = trim($this->convert_price_int_part_to_string($price, $type));

        $main_part = "$integer $str";


        $integer = $this->get_number_format_decimal($price);
        $str = trim($this->convert_price_cent_part_to_string($price, $type));

        if ($str)
            $second_part = "$integer $str";
        else
            $second_part = "$integer";


        $result = $main_part . " " . $second_part;

        return $result;
    }

    public function exchange_price($price)
    {
        $result = null;

        $integer = $this->get_number_format_thousand($price);
        $str = trim($this->convert_price_int_part_to_string($price, 'ukrainian_grn'));

        $main_part = "$integer $str";

        $integer = $this->get_number_format_decimal($price);
        $str = trim($this->convert_price_cent_part_to_string($price, 'grn'));

        if ($str)
            $second_part = "$integer $str";
        else
            $second_part = "$integer";


        $result = $main_part . " " . $second_part;

        return $result;
    }

    public function get_currency_title($number, $title)
    {
        $currency = KeyWord::where('key', $title);

        if ($number == '1') {
            $result = $currency->value('title_n');
        } elseif ($number >= '2' && $number <= '4') {
            $result = $currency->value('title_z');
        } else {
            $result = $currency->value('title_r');
        }

        return $result;
    }

    public function get_convert_space($space)
    {
        $result = null;

        $decimal_space = intval(round(($space - intval($space)) * 10,  1));
        $integer_space = intval(floor($space));

        $str = null;

        if ($decimal_space == '0') {
            $str = GenderWord::where('alias', "null")->value('male') . " " . KeyWord::where('key', 'decimal')->value('title_r');
        } elseif ($decimal_space == '1') {
            $str = GenderWord::where('alias', "number_one")->value('female') . " " . KeyWord::where('key', 'decimal')->value('title_n');
        } elseif ($decimal_space == '2') {
            $str = GenderWord::where('alias', "number_two")->value('female') . " " . KeyWord::where('key', 'decimal')->value('title_z');
        } elseif ($decimal_space >= '3' && $decimal_space <= '4') {
            $str = \App\Models\NumericConvert::where('original', $decimal_space)->value('title') . " " . KeyWord::where('key', 'decimal')->value('title_r');
        } else {
            $str = \App\Models\NumericConvert::where('original', $decimal_space)->value('title') . " " .  KeyWord::where('key', 'decimal')->value('title_r');
        }

        $result = trim($str . " " . $result);

        /* старт сотень */
        $str = null;
        $number = $integer_space % 100;

        if ($number < 11 || $number > 19) {
            $number = $integer_space % 10;
        }
        if ($number == '0') {
            $str = GenderWord::where('alias', "null")->value('male') . " " . KeyWord::where('key', 'point')->value('title_r');
        } elseif ($number == '1') {
            $str = GenderWord::where('alias', "number_one")->value('female') . " " . KeyWord::where('key', 'point')->value('title_n');
        } elseif ($number == '2') {
            $str = GenderWord::where('alias', "number_two")->value('female') . " " . KeyWord::where('key', 'point')->value('title_r');
        } elseif ($number >= '3' && $number <= '4') {
            $str = \App\Models\NumericConvert::where('original', $number)->value('title') . " " . KeyWord::where('key', 'point')->value('title_r');
        } else {
            $str = \App\Models\NumericConvert::where('original', $number)->value('title') . " " .  KeyWord::where('key', 'point')->value('title_r');
        }

        $result = $str . " " . $result;

        $integer_space = $integer_space - $number;

        $number = $integer_space % 100;
        if ($number) {
            $str = \App\Models\NumericConvert::where('original', $number)->value('title');
            $result = $str . " " . $result;
        }
        $integer_space = $integer_space - $number;

        $number = $integer_space % 1000;
        if ($number) {
            $str = \App\Models\NumericConvert::where('original', $number)->value('title');
            $result = $str . " " . $result;
        }

        $result = "$space ($result)";

        return $result;
    }

    public function number_to_string($value)
    {
        $result  = null;
        $str = null;

        $hundreds = $value % 1000;
        $value = intval($value / 1000);

        $thousands = $value % 1000;
        $value = intval($value / 1000);

        $gender = "male";

        /* старт сотень */
        $number = $hundreds % 100;
        if ($number) {
            if ($number < 11 || $number > 19) {
                $number = $hundreds % 10;
            }
            if ($number == '1') {
                $str = GenderWord::where('alias', "number_one")->value($gender);
            } elseif ($number == '2'){
                $str = GenderWord::where('alias', "number_two")->value($gender);
            } else {
                $str = \App\Models\NumericConvert::where('original', $number)->value('title');
            }

            $result = $str . " " . $result;
        }

        $hundreds = $hundreds - $number;

        $number = $hundreds % 100;
        if ($number) {
            $str = \App\Models\NumericConvert::where('original', $number)->value('title');
            $result = $str . " " . $result;
        }
        $hundreds = $hundreds - $number;

        $number = $hundreds % 1000;
        if ($number) {
            $str = \App\Models\NumericConvert::where('original', $number)->value('title');
            $result = $str . " " . $result;
        }
        /* кінець сотень */

        /* старт тисячі */
        $number = $thousands % 100;
        if ($number) {
            if ($number < 11 || $number > 19) {
                $number = $thousands % 10;
            }

            if ($number == '1') {
                $str = GenderWord::where('alias', "number_one")->value('female') . " " . KeyWord::where('key', 'thousand')->value('title_n');
            } elseif ($number == '2') {
                $str = GenderWord::where('alias', "number_two")->value('female') . " " . KeyWord::where('key', 'thousand')->value('title_r');
            } elseif ($number >= '3' && $number <= '4') {
                $str = \App\Models\NumericConvert::where('original', $number)->value('title') . " " . KeyWord::where('key', 'thousand')->value('title_r');
            } else {
                $str = \App\Models\NumericConvert::where('original', $number)->value('title') . " " . GenderWord::where('alias', "thousand_four_infinity")->value('many');
            }

            $result = $str . " " . $result;
        }
        $thousands = $thousands - $number;

        $number = $thousands % 100;
        if ($number) {
            $str = \App\Models\NumericConvert::where('original', $number)->value('title');
            $result = $str . " " . $result;
        }
        $thousands = $thousands - $number;

        $number = $thousands % 1000;
        if ($number) {
            $str = \App\Models\NumericConvert::where('original', $number)->value('title');
            $result = $str . " " . $result;
        }
        /* кінець тисячі */

        $result = trim($result);
        return $result;
    }

    public function date_to_string($document, $date)
    {
        $document->str_day = null;
        $document->str_month = null;
        $document->str_year = null;

        if ($date) {
            $num_day = $date->format('d');
            $num_month = $date->format('m');
            $num_year = $date->format('Y');

            $document->str_day = DayConvert::convert($num_day);
            $document->str_month = MonthConvert::convert($num_month);
            $document->str_year = YearConvert::convert($num_year);
        }
    }
}

