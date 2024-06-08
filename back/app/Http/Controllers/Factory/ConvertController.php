<?php

namespace App\Http\Controllers\Factory;

use App\Models\ApartmentType;
use App\Models\Card;
use App\Models\DayConvert;
use App\Models\GenderWord;
use App\Models\KeyWord;
use App\Models\MonthConvert;
use App\Models\Notary;
use App\Models\Text;
use App\Models\User;
use App\Models\WorkDay;
use App\Models\YearConvert;
use App\Models\Contract;
use App\Models\Client;

class ConvertController extends GeneratorController
{
    public $non_break_space;

    public function __construct($space = ' ')
    {
        $this->non_break_space = $space;
    }

    public function test_price_convert($number)
    {
        echo $this->convert_price_int_part_to_string($number, 'grn');
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
        } elseif ($thousands) {
            $str = GenderWord::where('alias', "thousand_four_infinity")->value('many');
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
        $price_thousand = number_format(floor($price / 100), 0, ".",  "$this->non_break_space" );

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

        $result = str_replace("  ", " ", $result);

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

        $decimal_space = intval(round(($space - intval($space)) * 100,  1));

        if ($decimal_space % 10 == 0) {
            $decimal_space = intval(round(($space - intval($space)) * 10,  1));
            $integer_space = intval(floor($space));

            $str = null;

            if ($decimal_space == '0') {
                // сказали убрать описание десятых при нуле
                //            $str = GenderWord::where('alias', "null")->value('male') . " " . KeyWord::where('key', 'decimal')->value('title_r');
                $str = null;
            } elseif ($decimal_space == '1') {
                $str = GenderWord::where('alias', "number_one")->value('female') . " " . KeyWord::where('key', 'decimal')->value('title_n');
            } elseif ($decimal_space == '2') {
                $str = GenderWord::where('alias', "number_two")->value('female') . " " . KeyWord::where('key', 'decimal')->value('title_r');
            } elseif ($decimal_space >= '3' && $decimal_space <= '4') {
                $str = \App\Models\NumericConvert::where('original', $decimal_space)->value('title') . " " . KeyWord::where('key', 'decimal')->value('title_r');
            } else {
                $str = \App\Models\NumericConvert::where('original', $decimal_space)->value('title') . " " .  KeyWord::where('key', 'decimal')->value('title_r');
            }

            $result = trim($str . " " . $result);
        } else {
            /* старт сотень */
            $number = $decimal_space % 100;
            if ($number) {
                if ($number < 11 || $number > 19) {
                    $number = $decimal_space % 10;
                }
                if ($number == '1') {
                    $str = GenderWord::where('alias', "number_one")->value('female') . " " . KeyWord::where('key', 'hundreds')->value('title_n');
                } elseif ($number == '2'){
                    $str = GenderWord::where('alias', "number_two")->value('female') . " " . KeyWord::where('key', 'hundreds')->value('title_z');
                } else {
                    $str = \App\Models\NumericConvert::where('original', $number)->value('title') . " " . KeyWord::where('key', 'hundreds')->value('title_r');
                }

                $result = $str . " " . $result;
            }

            $decimal_part = $decimal_space - $number;

            $number = $decimal_part % 100;
            if ($number) {
                $str = \App\Models\NumericConvert::where('original', $number)->value('title');
                $result = $str . " " . $result;
            }
            $decimal_part = $decimal_part - $number;

            $number = $decimal_part % 1000;
            if ($number) {
                $str = \App\Models\NumericConvert::where('original', $number)->value('title');
                $result = trim($str . " " . $result);
            }
            /* кінець сотень */
        }

//        $decimal_space = intval(round(($space - intval($space)) * 10,  1));
        $integer_space = intval(floor($space));

//        $str = null;

//        if ($decimal_space == '0') {
//            // сказали убрать описание десятых при нуле
////            $str = GenderWord::where('alias', "null")->value('male') . " " . KeyWord::where('key', 'decimal')->value('title_r');
//            $str = null;
//        } elseif ($decimal_space == '1') {
//            $str = GenderWord::where('alias', "number_one")->value('female') . " " . KeyWord::where('key', 'decimal')->value('title_n');
//        } elseif ($decimal_space == '2') {
//            $str = GenderWord::where('alias', "number_two")->value('female') . " " . KeyWord::where('key', 'decimal')->value('title_r');
//        } elseif ($decimal_space >= '3' && $decimal_space <= '4') {
//            $str = \App\Models\NumericConvert::where('original', $decimal_space)->value('title') . " " . KeyWord::where('key', 'decimal')->value('title_r');
//        } else {
//            $str = \App\Models\NumericConvert::where('original', $decimal_space)->value('title') . " " .  KeyWord::where('key', 'decimal')->value('title_r');
//        }
//
//        $result = trim($str . " " . $result);

        /* старт сотень */
        $str = null;
        $number = $integer_space % 100;

        if ($number < 11 || $number > 19) {
            $number = $integer_space % 10;
        }

        if ($decimal_space) {
    //        if ($number == '0') {
    //            $str = GenderWord::where('alias', "null")->value('male') . " " . KeyWord::where('key', 'point')->value('title_r');
    //        } elseif ($number == '1') {
            if ($number == '1') {
                $str = GenderWord::where('alias', "number_one")->value('female') . " " . KeyWord::where('key', 'point')->value('title_n');
            } elseif ($number == '2') {
                $str = GenderWord::where('alias', "number_two")->value('female') . " " . KeyWord::where('key', 'point')->value('title_r');
            } elseif ($number >= '3' && $number <= '4') {
                $str = \App\Models\NumericConvert::where('original', $number)->value('title') . " " . KeyWord::where('key', 'point')->value('title_r');
            } else {
                $str = \App\Models\NumericConvert::where('original', $number)->value('title') . " " .  KeyWord::where('key', 'point')->value('title_r');
            }
        } else {
            if ($number == '1') {
                $str = GenderWord::where('alias', "number_one")->value('male');
            } elseif ($number == '2') {
                $str = GenderWord::where('alias', "number_two")->value('male');
            } elseif ($number >= '3' && $number <= '4') {
                $str = \App\Models\NumericConvert::where('original', $number)->value('title');
            } else {
                $str = \App\Models\NumericConvert::where('original', $number)->value('title');
            }
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

        $space = str_replace('.', ',', $space);
        $result = "$space (" . trim($result) .")";

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

    public function get_short_name($person)
    {
        $str = null;

        if ($person) {
            if ($person->name_n && $person->patronymic_n) {
                $name = $person->name_n;
                $patronymic = $person->patronymic_n;
            } elseif ($person->name && $person->patronymic) {
                $name = $person->name;
                $patronymic = $person->patronymic;
            } elseif ($person->name_n &&$person->patronymic_n == null) {
                $name = $person->surname_n;
                $patronymic = $person->name_n;
            } elseif ($person->name &&$person->patronymic == null) {
                $name = $person->surname;
                $patronymic = $person->name;
            }
            $str = mb_substr($name, 0, 1) . mb_substr($patronymic, 0, 1);
        }


        return $str;
    }

    public function get_full_name($person)
    {
        $str = null;

        if ($person) {
            if ($person->surname_n) {
                $str = $person->surname_n . " " . $person->name_n . " " . $person->patronymic_n;
            } elseif ($person->surname) {
                $str = $person->surname . " " . $person->name . " " . $person->patronymic;
            }
        }

        return trim($str);
    }

    public function get_surname_and_initials_n($person)
    {
        $str = null;

        if ($person) {
            if (isset($person->surname_n))
                $str = $person->surname_n . $this->non_break_space . $person->short_name . $person->short_patronymic;
        }

        return $str;
    }

    public function get_surname_and_initials_r($person)
    {
        $str = null;

        if ($person) {
            if (isset($person->surname_r))
                $str = $person->surname_r . $this->non_break_space . $person->short_name . $person->short_patronymic;
        }

        return $str;
    }

    public function get_surname_and_initials_d($person)
    {
        $str = null;

        if ($person) {
            if (isset($person->surname_d))
                $str = $person->surname_d . $this->non_break_space . $person->short_name . $person->short_patronymic;
        }

        return $str;
    }

    public function get_surname_and_initials_o($person)
    {
        $str = null;

        if ($person) {
            if (isset($person->surname_o))
                $str = $person->surname_o . $this->non_break_space . $person->short_name . $person->short_patronymic;
        }

        return $str;
    }

    public function get_initials_and_surname_n($person)
    {
        $str = null;

        if ($person) {
            if (isset($person->surname_n)) {
                if ($person->short_name) {
                    $str = $person->short_name . $person->short_patronymic . $this->non_break_space . $person->surname_n;
                } else {
                    if ($person->name_n)
                        $str .= mb_substr($person->name_n, 0, 1) . ".";
                    if ($person->patronymic_n)
                        $str .= mb_substr($person->patronymic_n, 0, 1) . ".";
                    $str .= $this->non_break_space . $person->surname_n;
                }
            }
        }

        return $str;
    }

    public function get_client_surname_and_initials_n($person)
    {
        $str = null;

        if ($person) {
            if (isset($person->surname_n)) {
                if ($person->short_name) {
                    $str = $person->short_name . $person->short_patronymic . $this->non_break_space . $person->surname_n;
                } else {
                    $str .= $person->surname_n . $this->non_break_space;
                    if ($person->name_n)
                        $str .= mb_substr($person->name_n, 0, 1) . ".";
                    if ($person->patronymic_n)
                        $str .= mb_substr($person->patronymic_n, 0, 1) . ".";
                }
            }
        }

        return $str;
    }

    public function get_initials_and_surname_o($person)
    {
        $str = null;

        if ($person) {
            if (isset($person->surname_o))
                $str = $person->short_name . $person->short_patronymic . $this->non_break_space . $person->surname_o;
        }

        return $str;
    }

    public function building_address_type_title_number($building)
    {
        $str = null;

        if ($building) {
            $str = $building->address_type->short . $this->non_break_space . $building->title . $this->non_break_space . $building->number;
        }

        return $str;
    }

    /*
     * вул. Миру 14, кв. 1
     * */
    public function immovable_building_address($immovable)
    {
        $str = null;

        if ($immovable && isset($immovable->developer_building))  {
            $str = $immovable->developer_building->address_type->short . $this->non_break_space . $immovable->developer_building->title . $this->non_break_space . $immovable->developer_building->number . ", " . $immovable->immovable_type->short . $this->non_break_space . $immovable->immovable_number;
        }

        return $str;
    }


    public function get_client_full_address_n($c)
    {
        $full_address = null;

        if ($c) {
            $full_address .= $this->generate_full_address_n($c);
        }

        if ($c->actual_address) {
            $actual_address = ", фактичне місце проживання: ";
            $actual_address .= $this->generate_full_address_n($c->actual_address);
            $full_address .= $actual_address;
        }

        return $full_address;
    }

    public function generate_full_address_n($c)
    {
        $region = null;
        $region_type = null;
        $region_title = null;

        $district = null;
        $district_type = null;
        $district_title = null;

        $city = null;
        $city_type = null;
        $city_title = null;

        $address = null;
        $address_type = null;
        $address_title = null;

        $building_type = null;
        $building_num = null;
        $building = null;

        if ($c->city && $c->city->region_root == false && $c->city->region) {
            $region_type = trim(KeyWord::where('key', 'region')->value('title_n'));
            $region_title = trim($c->city->region->title_n);
            $region = "$region_title $region_type,";
        }

        if ($c->city && $c->city->district && ($c->city->district_root == false || $c->city->district_root == true && $c->city->city_type->title_n != 'місто')) {
            $district_type = trim(KeyWord::where('key', 'district')->value('title_n'));
            $district_title = trim($c->city->district->title_n);
            $district = "$district_title $district_type,";
        }

        if ($c->city && $c->city->city_type) {
            $city_type = trim($c->city->city_type->title_n);
            $city_title = trim($c->city->title);
            $city = "$city_type $city_title,";
        }

        if ($c->address && $c->address_type && $c->address_type->title_n && $c->building) {
            $address_title = trim($c->address);
            $address_type = trim($c->address_type->title_n);
            $address = "$address_type $address_title,";

            $building_type = trim(KeyWord::where('key', 'building')->value('title_n'));
            $building_num = trim($c->building);

            $building_part = null;
            if ($c->building_part_id) {
                $building_part = ", " . $c->building_part->short . $this->non_break_space . trim($c->building_part_num);
            }

            $apartment_full = null;
            if ($c->apartment_num) {
                $apartment_full = ", " . trim(ApartmentType::where('id', $c->apartment_type_id)->value('title_n')) . $this->non_break_space . trim($c->apartment_num);
            }
            elseif ($c->apartment_type_id) {
                $apartment_full = ", " . trim(ApartmentType::where('id', $c->apartment_type_id)->value('title_n'));
            }

            $building = "$building_type $building_num" . $building_part . $apartment_full;
        }

        $full_address = "$region $district $city $address $building";
        $full_address = trim(str_replace("  ", " ", $full_address));

        return $full_address;
    }

    public function client_full_address_short($c)
    {
        $full_address = null;

        if ($c) {
            $full_address .= $this->generate_client_full_address_short($c);
        }

        if ($c->actual_address) {
            $actual_address = ", фактичне місце проживання: ";
            $actual_address .= $this->generate_client_full_address_short($c->actual_address);
            $full_address .= $actual_address;
        }

        return $full_address;
    }

        public function client_native_address_short($c)
    {
        $full_address = null;

        if ($c) {
            $full_address .= $this->generate_client_full_address_short($c);
        }

        if ($c->actual_address) {
            $actual_address = "";
            $actual_address .= $this->generate_client_full_address_short($c->actual_address);
            $full_address .= $actual_address;
        }

        return $full_address;
    }


    public function generate_client_full_address_short($c)
    {
        $region = null;
        $region_type = null;
        $region_title = null;

        $district = null;
        $district_type = null;
        $district_title = null;

        $city = null;
        $city_type = null;
        $city_title = null;

        $address = null;
        $address_type = null;
        $address_title = null;

        $building_type = null;
        $building_num = null;
        $building = null;

        if ($c->city && $c->city->region_root == false && $c->city->region) {
            $region_title = trim($c->city->region->title_n);
            $region_type = trim(KeyWord::where('key', 'region')->value('short'));
            $region = "$region_title $region_type,";
        }

        // при старом может быть главным городом, при новом надо выводить с районом BUG
        if($c->district_id && $c->district && $c->city && $c->city->district_root == false) {
            $district_title = trim($c->district->title_n);
            $district_type = trim(KeyWord::where('key', 'district')->value('short'));
            $district = "$district_title $district_type,";
        } elseif ($c->city && $c->city->district_root == false && $c->city->district) {
            $district_title = trim($c->city->district->title_n);
            $district_type = trim(KeyWord::where('key', 'district')->value('short'));
            $district = "$district_title $district_type,";
        }

        if ($c->city && $c->city->city_type) {
            $city_type = trim($c->city->city_type->short);
            $city_title = trim($c->city->title);
            $city = $city_type . $this->non_break_space . "$city_title,";
        }

        if ($c->address && $c->address_type && $c->address_type->short && $c->building) {
            $address_type = trim($c->address_type->short);
            $address_title = trim($c->address);
            $address = $address_type . $this->non_break_space . "$address_title,";

            $building_type = trim(KeyWord::where('key', 'building')->value('short'));
            $building_num = trim($c->building);

            $building_part = null;

            if ($c->building_part_id) {
                $building_part = ", " . $c->building_part->short . $this->non_break_space . trim($c->building_part_num);
            }

            $apartment_full = null;
            if ($c->apartment_num) {
                $apartment_full = ", " . trim(ApartmentType::where('id', $c->apartment_type_id)->value('short')) . $this->non_break_space . trim($c->apartment_num);
            }
            elseif ($c->apartment_type_id) {
                $apartment_full = ", " . trim(ApartmentType::where('id', $c->apartment_type_id)->value('short'));
            }

            $building = $building_type . $this->non_break_space . $building_num . $building_part . $apartment_full;
        }

        $full_address = "$region $district $city $address $building";
        $full_address = trim(str_replace("  ", " ", $full_address));



        return $full_address;
    }

    /*
     * вулиці Миру, 14 (чотирнадцять)
     * */
    public function building_street_and_num($immovable)
    {
        $result = '';

        $imm_addr_type_r = $immovable->developer_building->address_type->title_r;
        $imm_addr_title = $immovable->developer_building->title;

        $imm_build_num = $immovable->developer_building->number;
        $imm_build_num_str = $this->building_num_to_str($immovable->developer_building->number);

        $result = "$imm_addr_type_r $imm_addr_title, $imm_build_num ($imm_build_num_str)";

        return $result;
    }

    /*
     * вулиця Миру 14 (чотирнадцять), село Новосілки, Києво-Святошинський район, Київська область
     * */
    public function building_full_address_by_type($immovable, $type = null)
    {
        $address = null;

        $building_num_str = $this->building_num_to_str($immovable->developer_building->number);

        $imm_num = $immovable->immovable_number;

        if ($immovable->immovable_number && is_string($immovable->immovable_number)) {
            $imm_num_str = $this->number_to_string(intval($immovable->immovable_number));
            $letter = str_replace(intval($immovable->immovable_number), '', $immovable->immovable_number);
            $letter = str_replace('-', '', $letter);
            $imm_num_str = $imm_num_str . " літера «" . $letter . "»";
        } else {
            $imm_num_str = $this->number_to_string($immovable->immovable_number);
        }

        $imm_build_num = $immovable->developer_building->number;
        $imm_build_num_str = $building_num_str;
        $imm_addr_type_r = $immovable->developer_building->address_type->title_n;
        $imm_addr_title = $immovable->developer_building->title;
        $imm_city_type_m = $immovable->developer_building->city->city_type->title_n;
        $imm_city_title_n = $immovable->developer_building->city->title;
        $imm_dis_title_r = $immovable->developer_building->city->district->title_n;
        $imm_reg_title_r = $immovable->developer_building->city->region->title_n;
        $building_type = Text::where('alias', 'building')->value('value');

        if ($type == null || $type == 'asc') {
            $address = "$imm_addr_type_r $imm_addr_title "
                . "$imm_build_num ($imm_build_num_str), "
                . "$imm_city_type_m $imm_city_title_n, "
                . "$imm_dis_title_r " . trim(KeyWord::where('key', 'district')->value('title_n')) . ", "
                . "$imm_reg_title_r " . trim(KeyWord::where('key', 'region')->value('title_n')) . " "
                . "";
        } elseif ($type == 'desc') {
            $address =
                ""
                . "$imm_reg_title_r " . trim(KeyWord::where('key', 'region')->value('title_n')) . ", "
                . "$imm_dis_title_r " . trim(KeyWord::where('key', 'district')->value('title_n')) . ", "
                . "$imm_city_type_m $imm_city_title_n, "
                . "$imm_addr_type_r $imm_addr_title, "
                . "$building_type $imm_build_num ($imm_build_num_str)"
                . "";
        }

        return $address;
    }

    public function building_street_type_and_title_n($immovable)
    {
        $address = null;
        
        $imm_addr_type_n = $immovable->developer_building->address_type->title_n;
        $imm_addr_title = $immovable->developer_building->title;

        $address = "$imm_addr_type_n $imm_addr_title";

        // 2-Б (два літера «Б») по вулиці Миру у селі Новосілки, Києво-Святошинського району Київської області

        return $address;
    }
    
    public function building_street_type_and_title_r($immovable)
    {
        $address = null;
        
        $imm_addr_type_r = $immovable->developer_building->address_type->title_r;
        $imm_addr_title = $immovable->developer_building->title;

        $address = "$imm_addr_type_r $imm_addr_title";

        // 2-Б (два літера «Б») по вулиці Миру у селі Новосілки, Києво-Святошинського району Київської області

        return $address;
    }

    /*
     * 14 (чотирнадцять) по вулиці Миру у селі Новосілки, Києво-Святошинського району Київської області
     * */
    public function building_full_address_main($immovable)
    {
        $address = null;

        $building_num_str = $this->building_num_to_str($immovable->developer_building->number);

        $imm_num = $immovable->immovable_number;

        if ($immovable->immovable_number && is_string($immovable->immovable_number)) {
            $imm_num_str = $this->number_to_string(intval($immovable->immovable_number));
            $letter = str_replace(intval($immovable->immovable_number), '', $immovable->immovable_number);
            $letter = str_replace('-', '', $letter);
            $imm_num_str = $imm_num_str . " літера «" . $letter . "»";
        } else {
            $imm_num_str = $this->number_to_string($immovable->immovable_number);
        }

        $imm_build_num = $immovable->developer_building->number;
        $imm_build_num_str = $building_num_str;
        $imm_addr_type_r = $immovable->developer_building->address_type->title_r;
        $imm_addr_title = $immovable->developer_building->title;
        $imm_city_type_m = $immovable->developer_building->city->city_type->title_m;
        $imm_city_title_n = $immovable->developer_building->city->title;
        $imm_dis_title_r = $immovable->developer_building->city->district->title_r;
        $imm_reg_title_r = $immovable->developer_building->city->region->title_r;
        $building_type = Text::where('alias', 'building')->value('value');

        $address = ""
            . "$imm_build_num ($imm_build_num_str) "
            . "по $imm_addr_type_r $imm_addr_title "
            . "у $imm_city_type_m $imm_city_title_n, "
            . "$imm_dis_title_r " . trim(KeyWord::where('key', 'district')->value('title_r')) . " "
            . "$imm_reg_title_r " . trim(KeyWord::where('key', 'region')->value('title_r')) . " "
            . "";

        // 2-Б (два літера «Б») по вулиці Миру у селі Новосілки, Києво-Святошинського району Київської області

        return $address;
    }

    /*
     * вул. Миру 14 (чотирнадцять), с. Новосілки, Києво-Святошинський р-н, Київська обл.
     * */
    public function building_full_address_by_type_short($immovable, $type = null)
    {
        $address = null;

        $building_num_str = $this->building_num_to_str($immovable->developer_building->number);

        $imm_num = $immovable->immovable_number;

        if ($immovable->immovable_number && is_string($immovable->immovable_number)) {
            $imm_num_str = $this->number_to_string(intval($immovable->immovable_number));
            $letter = str_replace(intval($immovable->immovable_number), '', $immovable->immovable_number);
            $letter = str_replace('-', '', $letter);
            $imm_num_str = $imm_num_str . " літера «" . $letter . "»";
        } else {
            $imm_num_str = $this->number_to_string($immovable->immovable_number);
        }

        $imm_build_num = $immovable->developer_building->number;
        $imm_build_num_str = $building_num_str;
        $imm_addr_type_short = $immovable->developer_building->address_type->short;
        $imm_addr_title = $immovable->developer_building->title;
        $imm_city_type_short = $immovable->developer_building->city->city_type->short;
        $imm_city_title = $immovable->developer_building->city->title;
        $imm_dis_title_n = $immovable->developer_building->city->district->title_n;
        $imm_reg_title_n = $immovable->developer_building->city->region->title_n;
        $building_type = Text::where('alias', 'building')->value('value');

        if ($type == null || $type == 'asc') {
            $address = "$imm_addr_type_short $imm_addr_title "
                . "$imm_build_num ($imm_build_num_str), "
                . "$imm_city_type_short $imm_city_title, "
                . "$imm_dis_title_n " . trim(KeyWord::where('key', 'district')->value('short')) . ", "
                . "$imm_reg_title_n " . trim(KeyWord::where('key', 'region')->value('short')) . " "
                . "";
        } elseif ($type == 'desc') {
            $address =
                ""
                . "$imm_reg_title_n " . trim(KeyWord::where('key', 'region')->value('short')) . ", "
                . "$imm_dis_title_n " . trim(KeyWord::where('key', 'district')->value('short')) . ", "
                . "$imm_city_type_short $imm_city_title, "
                . "$imm_addr_type_short $imm_addr_title, "
                . "$building_type $imm_build_num ($imm_build_num_str)"
                . "";
        }

        return $address;
    }


    /*
     * Київська область, Києво-Святошинський район, село Новосілки, вул. Миру, буд. 14, кв. 1
     * */
    public function building_full_address_with_imm_for_taxes($immovable)
    {
        $address = null;

        $imm_reg_title_n = $immovable->developer_building->city->region->title_n;
        $imm_region_type_n = trim(KeyWord::where('key', 'region')->value('title_n'));
        $imm_dis_title_n = $immovable->developer_building->city->district->title_n;
        $imm_district_type_n = trim(KeyWord::where('key', 'district')->value('title_n'));
        $imm_city_type_n = $immovable->developer_building->city->city_type->title_n;
        $imm_city_title_n = $immovable->developer_building->city->title;
        $imm_addr_short = $immovable->developer_building->address_type->short;
        $imm_addr_title = $immovable->developer_building->title;
        $imm_building_type = trim(KeyWord::where('key', 'building')->value('short'));
        $imm_build_num = $immovable->developer_building->number;
        $imm_type_short = $immovable->immovable_type->short;
        $imm_num = $immovable->immovable_number;

        $address = "$imm_reg_title_n $imm_region_type_n, $imm_dis_title_n $imm_district_type_n, $imm_city_type_n $imm_city_title_n, $imm_addr_short\xc2\xa0$imm_addr_title, $imm_building_type\xc2\xa0$imm_build_num, $imm_type_short\xc2\xa0$imm_num";

        return $address;
    }

    public function building_short_address_for_taxes($immovable)
    {
        $imm_addr_short = $immovable->developer_building->address_type->short;
        $imm_addr_title = $immovable->developer_building->title;
        $imm_build_num = $immovable->developer_building->number;
        $imm_type_short = $immovable->immovable_type->short;
        $imm_num = $immovable->immovable_number;

        $address = "$imm_addr_short\xc2\xa0$imm_addr_title $imm_build_num $imm_type_short\xc2\xa0$imm_num";

        return $address;
    }


    /*
     * с. Новосілки, вул. Миру, буд. 14, кв. 1
     * */
    public function building_city_address_number_immovable($immovable)
    {
        $address = null;

//        $imm_reg_title_n = $immovable->developer_building->city->region->title_n;
//        $imm_region_type_n = trim(KeyWord::where('key', 'region')->value('title_n'));
//        $imm_dis_title_n = $immovable->developer_building->city->district->title_n;
//        $imm_district_type_n = trim(KeyWord::where('key', 'district')->value('title_n'));
        $imm_city_type_n = $immovable->developer_building->city->city_type->short;
        $imm_city_title_n = $immovable->developer_building->city->title;
        $imm_addr_short = $immovable->developer_building->address_type->short;
        $imm_addr_title = $immovable->developer_building->title;
        $imm_building_type = trim(KeyWord::where('key', 'building')->value('short'));
        $imm_build_num = $immovable->developer_building->number;
        $imm_type_short = $immovable->immovable_type->short;
        $imm_num = $immovable->immovable_number;

        $address = "$imm_city_type_n $imm_city_title_n, $imm_addr_short\xc2\xa0$imm_addr_title, $imm_building_type\xc2\xa0$imm_build_num, $imm_type_short\xc2\xa0$imm_num";

        return $address;
    }

    public function building_num_to_str($num)
    {
        $result = [];

        $num_arr = explode('/', $num);

        if (count($num_arr) == 2) {
            $result[] = $this->number_to_string(intval($num_arr[0]));
//            $result[] = str_replace(intval($num_arr[0]), '', $num_arr[0]) . ' дріб';
            $result[] = 'дріб';
            $result[] = $this->number_to_string($num_arr[1]);

            return implode(' ', $result);
        }

        $num_arr = explode('-', $num);

        if (count($num_arr) == 2) {

            $result[] = $this->number_to_string($num_arr[0]);
            $result[] = "літера «" . $num_arr[1] . "»";

            return implode(' ', $result);
        }

        if (strlen(intval($num)) < strlen($num)) {
            $result[] = $this->number_to_string(intval($num));
            $result[] = "літера «" . str_replace(intval($num), '', $num) . "»";

            return implode(' ', $result);
        }

        $result = trim($this->number_to_string($num));

        return $result;
    }

    public function number_with_string($number)
    {
        $number_str = $this->number_to_string($number);

        $result = "$number ($number_str)";

        return $result;
    }

    public function immovable_number_with_string($number)
    {
        $number_str = $this->building_num_to_str($number);

        $result = "$number ($number_str)";

        return $result;
    }

    public function get_immovable_floor($floor)
    {
        return KeyWord::where('key', 'floor_' . $floor)->value('title_d');
    }

    public function get_full_name_n($client)
    {
        $full_name = $client->surname_n . " " . $client->name_n . " " . $client->patronymic_n;

        if (!$client->patronymic_n)
            $full_name = mb_strtoupper($full_name);

        return trim($full_name);
    }

    public function get_full_name_r($client)
    {
        $full_name = $client->surname_r . " " . $client->name_r . " " . $client->patronymic_r;

        if (!$client->patronymic_r)
            $full_name = mb_strtoupper($full_name);

        return trim($full_name);
    }

    public function get_full_name_d($client)
    {
        $full_name = $client->surname_d . " " . $client->name_d . " " . $client->patronymic_d;

        if (!$client->patronymic_d)
            $full_name = mb_strtoupper($full_name);

        return trim($full_name);
    }

    public function get_full_name_o($client)
    {
        $full_name = $client->surname_o . " " . $client->name_o . " " . $client->patronymic_o;

        if (!$client->patronymic_o)
            $full_name = mb_strtoupper($full_name);

        return trim($full_name);
    }


    public function get_full_name_n_for_sing_area($client)
    {
        if ($client->representative && $client->representative->confidant) {
            $full_name = $client->surname_r . " " . $client->name_r . " " . $client->patronymic_r;
        } else {
            $full_name = $client->surname_n . " " . $client->name_n . " " . $client->patronymic_n;
        }

        if (!$client->patronymic_n)
            $full_name = mb_strtoupper($full_name);

        if ($client->representative && $client->representative->confidant) {
            $sign_title = Text::where('alias', 'representative_sign')->value('value');
            $full_name = "$sign_title $full_name";
        }

        return trim($full_name);
    }

    public function get_full_name_n_upper($client)
    {
        $full_name = "$client->surname_n $client->name_n $client->patronymic_n";
        $full_name = mb_strtoupper($full_name);

        return trim($full_name);
    }

    public function get_staff_full_name($staff)
    {
        $full_name = "$staff->surname $staff->name $staff->patronymic";

        return trim($full_name);
    }

    public function get_full_name_r_upper($client)
    {
        $full_name = "$client->surname_r $client->name_r $client->patronymic_r";
        $full_name = mb_strtoupper($full_name);

        return trim($full_name);
    }

    public function get_client_citizenship_n($client)
    {
        $result = '';

        if ($client->citizenship)
        {
            if ($client->gender == "male") {
                $citizen = KeyWord::where('key', "citizen_male")->value('title_n');
            } else {
                $citizen = KeyWord::where('key', "citizen_female")->value('title_n');
            }

            $country = $client->citizenship->title_r;
            $result = "$citizen $country" . " ";
        }

        return $result;
    }

    public function get_client_citizenship_r($client)
    {
        $result = '';

        if ($client->citizenship)
        {
            if ($client->gender == "male") {
                $citizen = KeyWord::where('key', "citizen_male")->value('title_r');
            } else {
                $citizen = KeyWord::where('key', "citizen_female")->value('title_r');
            }

            $country = $client->citizenship->title_r;
            $result = "$citizen $country" . " ";
        }

        return $result;
    }

    public function next_three_work_banking_days($date)
    {
        $week = WorkDay::orderBy('num')->pluck('bank_day', 'num')->toArray();

        $days = 0;
        if ($date) {
            $i = 0;
            while($i < 3) {
                $days++;
                $tmp = clone $date;
                if ($week[$tmp->addDays($days)->format('w')]) {
                    $i++;
                }

            }
        }

        return $days;
    }

    public function day_double_vertical_quotes_month_year($date)
    {
        $title = "«##» ###### ####";

        if ($date) {
            $day = $date->format('d');
            $month = MonthConvert::where('original', $date->format('m'))->orWhere('original', strval(intval($date->format('m'))))->value('title_r');
            $year = $date->format('Y');

            $title = '"' . $day . '"' . $this->non_break_space . $month . $this->non_break_space . $year;
        }

        return $title;
    }

    public function phone_number($phone)
    {
        $phone = str_replace("(", " (", $phone);
        $phone = str_replace(")", ") ", $phone);
        $phone = str_replace("-", " ", $phone);

        return $phone;
    }

    public function phone_number_short($phone)
    {
        $phone = str_replace("(", "", $phone);
        $phone = str_replace(")", "", $phone);
        $phone = str_replace("-", "", $phone);

        return $phone;
    }

    public function get_id_in_pad_format($id)
    {
        $id = str_pad($id, 8, '0', STR_PAD_LEFT);

        return $id;
    }

    public function mb_ucfirst($string)
    {
        if ($string) {
            $string = explode(" ", $string);
            $string[0] = mb_convert_case($string[0], MB_CASE_TITLE, 'UTF-8');
            $string = implode(" ", $string);
        }

        return $string;
    }
}

