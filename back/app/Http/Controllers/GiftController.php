<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankTaxesList;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

    public function start()
    {
        /*
         * Ракул квартири
         * */
        // договори
        $info = "Квартири з 1 по 60 - Ракул О.В..xlsx";
        $docx_template = 'КВ-СТУСА-РАКУЛ.docx';
        $title = "КВ-РАКУЛ/07.10 Основний МАМ (Мартинов А. М.) (Боярчук) - Фещук (Ковалік М.Л.) вул. Стуса В. 7 кв. ";

        $this->sheetData = null;
        $this->get_deal_info_from_excel($info);
        $this->start_multiple_contract($docx_template, $title);

        // податки
        $excel_template = 'Податки на одного Excel Фещук.xlsx';
        $title = "Податки на одного Excel Фещук ";
        $immovable = "Київська область, Бучанський район, село Софіївська Борщагівка, вул. Стуса В., буд. 7, кв. ";

        $this->set_taxes_data($excel_template, $title, $immovable);

        /*
         * Петрова квартири
         * */
        $info = "Квартири з 61 по 96 Петрова С.М..xlsx";
        $docx_template = 'КВ-СТУСА-ПЕТРОВА.docx';
        $title = "КВ-ПЕТРОВА/07.10 Основний МАМ (Мартинов А. М.) (Боярчук) - Фещук (Ковалік М.Л.) вул. Стуса В. 7 кв. ";

        $this->sheetData = null;
        $this->get_deal_info_from_excel($info);
        $this->start_multiple_contract($docx_template, $title);

        // податки
        $excel_template = 'Податки на одного Excel Фещук.xlsx';
        $title = "Податки на одного Excel Фещук ";
        $immovable = "Київська область, Бучанський район, село Софіївська Борщагівка, вул. Стуса В., буд. 7, кв. ";

        $this->set_taxes_data($excel_template, $title, $immovable);

        /*
         * Петрова ГНП
         * */
        $info = "97-116 приміщення - Петрова С.М..xlsx";
        $docx_template = 'ГНП-СТУСА-ПЕТРОВА.docx';
        $title = "ГНП-ПЕТРОВА/07.10 Основний МАМ (Мартинов А.М.) (Боярчук) - Фещук (Ковалік М.Л.) Стуса В. 7 гнп ";

        $this->sheetData = null;
        $this->get_deal_info_from_excel($info);
        $this->start_multiple_contract($docx_template, $title);

        // податки
        $excel_template = 'Податки на одного Excel Фещук.xlsx';
        $title = "Податки на одного Excel Фещук ";
        $immovable = "Київська область, Бучанський район, село Софіївська Борщагівка, вул. Стуса В., буд. 7, гнп ";

        $this->set_taxes_data($excel_template, $title, $immovable);
    }

    public function start_multiple_contract($docx, $title)
    {
        // створити договір
        foreach ($this->sheetData as $data) {
            $word = new \PhpOffice\PhpWord\TemplateProcessor($docx);

            if (isset($data['A']))
                $word->setValue('РЕЄСТРАЦІЙНИЙ-НОМЕР', $data['A']);
            if (isset($data['B']))
                $word->setValue('ТИП-НЕРУХОМОСТІ', $data['B']);
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
            if (isset($data['H']))
                $word->setValue('ДАТА-ЗАПИСУ', $this->convert_date($data['H']));
            if (isset($data['I']))
                $word->setValue('НОМЕР-ВИТЯГУ', $data['I']);
            if (isset($data['J']))
                $word->setValue('ДАТА-ВИТЯГУ', $this->convert_date($data['J']));
            if (isset($data['L']))
                $word->setValue('ОК-ОЦ-ЦІНА', $this->convert->get_convert_price($data['L'] * 100, 'grn'));
            if (isset($data['M']))
                $word->setValue('ОК-ОЦ-ДАТА', $this->convert_date($data['M']));
            if (isset($data['M']))
                $word->setValue('Н-ЦІНА-ЗАГ-ГРН', $this->convert->get_convert_price($data['N'] * 100, 'grn'));

            $word->saveAs('MAM/' . $title .  $data['F'] . '.docx');
        }
    }

    public function set_taxes_data($excel_template, $title, $immovable)
    {
        $taxes = BankTaxesList::get();

        foreach ($this->sheetData as $data) {

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($excel_template);
            $sheet = $spreadsheet->getActiveSheet();

            $price = sprintf("%.2f", $data['N']);
            $sheet->setCellValue("J1", $price);

            $i = 2;
            foreach ($taxes as $tax) {
                $percent = $tax->percent / 10000; // 5% зберігається у форматі 500, 1% можна ділити на 100 частин
                $sheet->setCellValue("A{$i}", $price * $percent);
                $i++;
            }

            $sheet->setCellValue("B10", $immovable . $data['F']);
            $sheet->setCellValue("B11", $price);

            $file_name = $title .  $data['F'] . ".xlsx";
            $this->create_file_for_contract($excel_template, $file_name);
            $writer = new Xlsx($spreadsheet);
            $writer->save($file_name);
        }
    }

    public function get_deal_info_from_excel($excel)
    {
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
    }

    public function convert_date($date)
    {
        $date = new \DateTime($date);
        return $date->format('d.m.Y');
    }

    public function create_file_for_contract($template, $title)
    {
        if (!file_exists($title)) {
//            $data = file_get_contents($template);
            $data = curl_init();
            curl_setopt($data, CURLOPT_URL,$template);
            curl_setopt($data, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($data, CURLOPT_USERAGENT, 'Document Template');

            $result = curl_exec($data);

            curl_close($data);

            file_put_contents($title, $result);
        }
    }
}
