<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GiftController extends Controller
{
    public $registration_number;
    public $immovable_type;
    public $total_space;
    public $living_space;
    public $address;
    public $gov_reg_number;
    public $gov_reg_date_format;
    public $discharge_date_format;
    public $discharge_number;
    public $word_template_path;
    public $excel_file_path;
    public $sheet;
    public $sheetData;
    public $non_break_space;
    public $convert;

    public function __construct()
    {
        $this->non_break_space = " ";
        $this->convert = new \App\Http\Controllers\Factory\ConvertController($this->non_break_space);
    }

    public function get_excel($excel)
    {
        $excel = "НП 114.xlsx";
        # библиотека читает файл
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($excel);

        # задается тип просмотра файла - все что за текстом ставить на фронт - ссылки, формулы
        $reader->setReadDataOnly(FALSE);

        # получить сам файл в виде объекта
        $spreadsheet = $reader->load($excel);

        # получить лист файла под номером $i
        $this->sheet = $spreadsheet->getSheet(0);

        # перевести объект $sheet в массив по типу таблицы excel
        $this->sheetData = $this->sheet->toArray(null, true, true, true);

		$sheetData = array_reverse($this->sheetData);
		foreach($sheetData as $key => $row)
		{
			if (count(array_filter($row)) == 0)
				unset($sheetData[$key]);
			else
				break ;
		}
		$sheetData = array_reverse($sheetData);
		$sheetData = array_merge(array('start'), $sheetData);
		$this->sheetData = array_values($sheetData);

		unset($this->sheetData[0]);
		unset($this->sheetData[1]);

		$total = 0;
		foreach ($this->sheetData as $value) {
		    echo $value['C'] . "<br>";
		    $total += $value['C'];
        }

		dd($total);
    }

    public function get_word_template()
    {
        $word = new TemplateProcessor($this->contract_generate_file);
        $word = $this->set_data_word($word);
        $word->saveAs($this->contract_generate_file);
    }

    public function start_dzubuk()
    {
//        $excel = 'НП Леніна 10-Б 9 шт.xlsx';
//        $excel = 'НП Леніна 10-В 1 шт.xlsx';
//        $excel = 'НП Оксамитова 20-А 24 шт.xlsx';
//        $excel = 'НП Оксамитова 20-Б 31 шт.xlsx';
//        $excel = 'НП Щаслива 44 6 шт.xlsx';
//        $excel = 'НП Яблунева 5-А 2 шт.xlsx';
//        $excel = 'НП Яблунева 5-Б 1 шт.xlsx';
//        $excel = 'НП Яблунева 7-В 2 шт.xlsx';
//        $excel = 'НП Яблунева 9-А 1 шт.xlsx';
//        $excel = 'НП Яблунева 9-Б 8 шт.xlsx';
//        $excel = 'НП Яблунева 9-В 5 шт.xlsx';
//        $excel = 'НП Яблунева 9-Г 4 шт.xlsx';
//        $excel = 'НП Яблунева 9-Д 6 шт.xlsx';
//        $excel = 'НП Яблунева 13-б 4 шт.xlsx';
//        $excel = 'НП Яблунева 13-В 3 шт.xlsx';
//        $excel = 'НП Яблунева 13-Г 7 шт.xlsx';
//
//        $docx = 'НП вулиця Леніна 10-Б ПБ Петрова 03.08.docx';
//        $docx = 'НП вулиця Леніна 10-В ПБ Петрова 03.08.docx';
//        $docx = 'НП вулиця Оксамитова 20-А ПБ Петрова 03.08.docx';
//        $docx = 'НП вулиця Оксамитова 20-Б ПБ Ракул 03.08.docx';
//        $docx = 'НП вулиця Щаслива 44 СБ Ракул 03.08.docx';
//        $docx = 'НП вулиця Яблунева 5-А СБ Ракул 03.08.docx';
//        $docx = 'НП вулиця Яблунева 5-Б СБ Ракул 03.08.docx';
//        $docx = 'НП вулиця Яблунева 7-В СБ Ракул 03.08.docx';
//        $docx = 'НП вулиця Яблунева 9-А СБ Ракул 03.08.docx';
//        $docx = 'НП вулиця Яблунева 9-Б СБ Ракул 03.08.docx';
//        $docx = 'НП вулиця Яблунева 9-В СБ Ракул 03.08.docx';
//        $docx = 'НП вулиця Яблунева 9-Г СБ Ракул 03.08.docx';
//        $docx = 'НП вулиця Яблунева 9-Д СБ Ракул 03.08.docx';
//        $docx = 'НП вулиця Яблунева 13-Б СБ Ракул 03.08.docx';
//        $docx = 'НП вулиця Яблунева 13-В СБ Ракул 03.08.docx';
//        $docx = 'НП вулиця Яблунева 13-Г СБ Ракул 03.08.docx';


//        $excel = 'НП Леніна 10-Б 9 шт.xlsx';
//        $docx = 'НП вулиця Леніна 10-Б ПБ Петрова 03.08.docx';
//
        $excel = 'НП Леніна 10-В 1 шт.xlsx';
        $docx = 'НП вулиця Леніна 10-В ПБ Петрова 03.08.docx';
//
//        $excel = 'НП Оксамитова 20-А 24 шт.xlsx';
//        $docx = 'НП вулиця Оксамитова 20-А ПБ Петрова 03.08.docx';
//
//        $excel = 'НП Оксамитова 20-Б 31 шт.xlsx';
//        $docx = 'НП вулиця Оксамитова 20-Б ПБ Ракул 03.08.docx';
//
//        $excel = 'НП Щаслива 44 6 шт.xlsx';
//        $docx = 'НП вулиця Щаслива 44 СБ Ракул 03.08.docx';
//
//        $excel = 'НП Яблунева 5-А 2 шт.xlsx';
//        $docx = 'НП вулиця Яблунева 5-а СБ Ракул 03.08.docx';
//
//        $excel = 'НП Яблунева 5-Б 1 шт.xlsx';
//        $docx = 'НП вулиця Яблунева 5-б СБ Ракул 03.08.docx';
//
//        $excel = 'НП Яблунева 7-В 2 шт.xlsx';
//        $docx = 'НП вулиця Яблунева 7-В СБ Ракул 03.08.docx';
//
//        $excel = 'НП Яблунева 9-А 1 шт.xlsx';
//        $docx = 'НП вулиця Яблунева 9-А СБ Ракул 03.08.docx';
//
//        $excel = 'НП Яблунева 9-Б 8 шт.xlsx';
//        $docx = 'НП вулиця Яблунева 9-Б СБ Ракул 03.08.docx';
//
//        $excel = 'НП Яблунева 9-В 5 шт.xlsx';
//        $docx = 'НП вулиця Яблунева 9-В СБ Ракул 03.08.docx';
//
//        $excel = 'НП Яблунева 9-Г 4 шт.xlsx';
//        $docx = 'НП вулиця Яблунева 9-Г СБ Ракул 03.08.docx';
//
//        $excel = 'НП Яблунева 9-Д 6 шт.xlsx';
//        $docx = 'НП вулиця Яблунева 9-Д СБ Ракул 03.08.docx';
//
//        $excel = 'НП Яблунева 13-б 4 шт.xlsx';
//        $docx = 'НП вулиця Яблунева 13-б СБ Ракул 03.08.docx';
//
//        $excel = 'НП Яблунева 13-В 3 шт.xlsx';
//        $docx = 'НП вулиця Яблунева 13-в СБ Ракул 03.08.docx';

//        $excel = 'НП Яблунева 13-Г 7 шт.xlsx';
//        $docx = 'НП вулиця Яблунева 13-г СБ Ракул 03.08.docx';


        $this->get_excel($excel);
        foreach ($this->sheetData as $data) {
            $date = new \DateTime($data['H']);
            $word = new \PhpOffice\PhpWord\TemplateProcessor($docx);


            if (isset($data['A']))
                $word->setValue('РЕЄСТРАЦІЙНИЙ-НОМЕР', $data['A']);
            if (isset($data['C']))
                $word->setValue('ЗАГАЛЬНА-ПЛОЩА', str_replace(".", ",", $data['C']));
            if (isset($data['D']))
                $word->setValue('ЖИТЛОВА-ПЛОЩА', str_replace(".", ",", $data['D']));
            if (isset($data['E']))
                $word->setValue('КІМНАТНІСТЬ', mb_strtolower($data['E']));
            if (isset($data['F']))
                $word->setValue('НОМЕР-НЕРУХОМОСТІ', $this->convert->immovable_number_with_string($data['F']));
            if (isset($data['G']))
                $word->setValue('НОМЕР-ЗАПИСУ', $data['G']);
            if (isset($data['K']))
                $word->setValue('КАДАСТРОВИЙ-НОМЕР', $data['K']);
            if (isset($data['L']))
                $word->setValue('НОМЕР-ДЗК', $data['L']);
            if (isset($date))
                $word->setValue('ДАТА-ЗАПИСУ', $date->format('d.m.Y'));

            $title = str_replace(".docx", "", $docx);
            $word->saveAs('dzubuk/' . $title . ' - номер ' . str_replace("/", "-", $data['F']) . '.docx');
        }
    }
}
