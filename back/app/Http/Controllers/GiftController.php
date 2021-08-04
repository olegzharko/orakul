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

    public function __construct()
    {

    }

    public function get_excel()
    {
        # библиотека читает файл
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile('data.xlsx');

        # задается тип просмотра файла - все что за текстом ставить на фронт - ссылки, формулы
        $reader->setReadDataOnly(FALSE);
        # получить сам файл в виде объекта
        $spreadsheet = $reader->load('data.xlsx');

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

    public function get_word_template()
    {
        $word = new TemplateProcessor($this->contract_generate_file);
        $word = $this->set_data_word($word);
        $word->saveAs($this->contract_generate_file);
    }

    public function start_dzubuk()
    {
        $this->get_excel();
        foreach ($this->sheetData as $data) {
            $word = new \PhpOffice\PhpWord\TemplateProcessor('template.docx');
            $word->setValue('Н-РЕЄСТР-НОМ', $data['A']);
            $word->setValue('Н-ТИП-Н', $data['B']);
            $word->setValue('Н-ПЛ-З-ЦФР', $data['C']);
            $word->setValue('Н-ПЛ-Ж-ЦФР', $data['C']);
            $word->setValue('H-ПОВНА-АДРЕСА', $data['D']);
            $word->setValue('ПР-ВЛ-РСТР-НОМ', $data['E']);
            $word->setValue('ПР-ВЛ-РСТР-ДАТА', $data['F']);
            $word->setValue('ПР-ВЛ-НОТ-ПІБ-О', $data['G']);
//            $word->setValue('ПР-ВЛ-НОТ-АКТИВНІСТЬ-О', $data['A']);
            $word->saveAs('dzubuk/' . $data['D'] . '.docx');
        }
    }
}
