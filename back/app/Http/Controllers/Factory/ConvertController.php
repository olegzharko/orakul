<?php

namespace App\Http\Controllers\Factory;

use App\Models\ApartmentType;
use App\Models\DayConvert;
use App\Models\GenderWord;
use App\Models\KeyWord;
use App\Models\MonthConvert;
use App\Models\YearConvert;

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
            $str = \App\Models\NumericConvert::where('original', $number)->value('title') . " " . KeyWord::where('key', 'thousand')->value('title_r');
            $result = $str . " " . $result;
        }
        $thousands = $thousands - $number;

        $number = $thousands % 1000;
        if ($number) {
            $str = \App\Models\NumericConvert::where('original', $number)->value('title') . " " . GenderWord::where('alias', "thousand_four_infinity")->value('many');
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

        // echo $start_value . "  " . $result . "<br>";

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

        // echo $start_value . "    " . $result . "<br>";

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

    public function get_short_name($person)
    {
        $str = null;

        if ($person) {
            if ($person->name_n || $person->patronymic_n) {
                $name = $person->name_n;
                $patronymic = $person->patronymic_n;
            } elseif ($person->name || $person->patronymic) {
                $name = $person->name;
                $patronymic = $person->patronymic;
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

    public function get_surname_and_initials($person)
    {
        $str = null;

        if ($person) {
            if (isset($person->surname_n))
                $str = $person->surname_n . " " . $person->short_name . $person->short_patronymic;
        }

        return $str;
    }

    public function get_full_address($building)
    {
        $str = null;

        if ($building) {
            $str = $building->address_type->short . " " .  $building->title . " " . $building->number;
        }

        return $str;
    }

    public function get_client_full_address($c)
    {
        $region = null;
        $region_type_short = null;
        $region_title = null;

        $district = null;
        $district_type_short = null;
        $district_title = null;

        $city = null;
        $city_type_short = null;
        $city_title = null;

        $address = null;
        $address_type_short = null;
        $address_title = null;

        $building_type_short = null;
        $building_num = null;
        $building = null;

        if ($c->city && $c->city->region) {
            $region_type_short = trim(KeyWord::where('key', 'region')->value('title_n'));
            $region_title = trim($c->city->region->title_n);
            $region = "$region_title $region_type_short, ";
        }

        if ($c->city && $c->city->district) {
            $district_type_short = trim(KeyWord::where('key', 'district')->value('title_n'));
            $district_title = trim($c->city->district->title_n);
            $district = "$district_title $district_type_short, ";
        }



        if ($c->city && $c->city->city_type) {
            $city_type_short = trim($c->city->city_type->short);
            $city_title = trim($c->city->title);
            $city = "$city_type_short $city_title, ";
        }

        if ($c->address && $c->address_type && $c->address_type->short && $c->building ) {
            $address_title = trim($c->address);
            $address_type_short = trim($c->address_type->short);
            $address = "$address_type_short $address_title, ";

            $building_type_short = trim(KeyWord::where('key', 'building')->value('short'));
            $building_num = trim($c->building);

            $apartment_full = $c->apartment_num ? ", " . trim(ApartmentType::where('id', $c->apartment_type_id)->value('short')) . " " . trim($c->apartment_num) : null;

            $building = "$building_type_short $building_num" . "$apartment_full";
        }

        $full_address = ""
            . "$region"
            . "$district"
            . "$city"
            . "$address"
            . "$building";
        $full_address = trim($full_address);

        return $full_address;
    }

    public function building_address($immovable)
    {
        $result = '';

        $imm_addr_type_r = $immovable->developer_building->address_type->title_r;
        $imm_addr_title = $immovable->developer_building->title;

        $imm_build_num = $immovable->developer_building->number;
        $imm_build_num_str = $this->building_num_str($immovable->developer_building->number);

        $result = "$imm_addr_type_r $imm_addr_title $imm_build_num ($imm_build_num_str)";

        return $result;
    }

    public function building_num_str($num)
    {
        $resutl = [];

        $num_arr = explode('/', $num);

        if (count($num_arr) == 2) {
            $resutl[] = $this->number_to_string(intval($num_arr[0]));
            $resutl[] = str_replace(intval($num_arr[0]), '', $num_arr[0]) . ' дріб ';
            $resutl[] = $this->number_to_string($num_arr[1]);

            return implode(' ', $resutl);
        }

        $num_arr = explode('-', $num);

        if (count($num_arr) == 2) {
            $resutl[] = $this->number_to_string($num_arr[0]);
            $resutl[] = $num_arr[1];

            return implode(' ', $resutl);
        }

        $result = $this->number_to_string($num);

        return $result;
    }

    public function number_with_string($number)
    {
        $number_str = $this->number_to_string($number);

        $resutl = "$number ($number_str)";

        return $resutl;
    }

    public function get_immovable_floor($floor)
    {
        return KeyWord::where('key', 'floor_' . $floor)->value('title_d');
    }
}

