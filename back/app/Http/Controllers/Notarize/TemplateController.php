<?php

namespace App\Http\Controllers\Notarize;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Requests\Notarize\TemplateInfoRequest;
use App\Models\GenderWord;
use App\Models\PowerOfAttorney;
use App\Models\PowerOfAttorneyTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;

class TemplateController extends BaseController
{
    public $convert;
    public $non_break_space;
    public $style_bold;
    public $style_end;

    public function __construct()
    {
        $this->convert = new ConvertController();
        $this->non_break_space = " ";
        $this->style_bold = "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Rakul\" w:hAnsi=\"Times New Rakul\" w:cs=\"Times New Rakul\"/><w:b/><w:sz w:val=\"22\"/><w:szCs w:val=\"22\"/></w:rPr><w:t xml:space=\"preserve\">";
        $this->style_end = "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Rakul\" w:hAnsi=\"Times New Rakul\" w:cs=\"Times New Rakul\"/><w:sz w:val=\"22\"/><w:szCs w:val=\"22\"/></w:rPr><w:t xml:space=\"preserve\">";
    }

    /**
     * @param $powerOfAttorneyID
     * @return JsonResponse
     */
    public function getTemplate($powerOfAttorneyID)
    {
        $result = null;

        $powerOfAttorney = PowerOfAttorney::findOrFail($powerOfAttorneyID);

        $powerOfAttorneyTemplates = PowerOfAttorneyTemplate::select('id', 'title')->get();
        $result['contract_templates'] = $powerOfAttorneyTemplates;
        $result['contract_template_id'] = $powerOfAttorney->template_id ?? null;
        $result['issue_date'] = $powerOfAttorney->issue_date ? $powerOfAttorney->issue_date->format('d.m.Y') : null;
        $result['expiry_date'] = $powerOfAttorney->expiry_date ? $powerOfAttorney->expiry_date->format('d.m.Y') : null;

        return  $this->sendResponse($result, 'Дані по шаблонам');
    }

    /**
     * @param TemplateInfoRequest $templateInfo
     * @param $powerOfAttorneyID
     * @return JsonResponse
     */
    public function setTemplate(TemplateInfoRequest $templateInfo, $powerOfAttorneyID)
    {
        // Найти запись PowerOfAttorney
        $powerOfAttorney = PowerOfAttorney::findOrFail($powerOfAttorneyID);

        $powerOfAttorney->update([
            'template_id' => $templateInfo['contract_template_id'],
            'expiry_date' => $templateInfo['expiry_date'],
            'issue_date' => $templateInfo['issue_date'],
        ]);

        // 1. Извлечение файла шаблона с использованием Spatie MediaLibrary
        $templatePath = $powerOfAttorney->template->getFirstMediaPath('path');

        if (!$templatePath || !file_exists($templatePath)) {
            abort(404, 'Template not found');
        }

        // 4. Генерация уникального имени для папки
        $folderName = 'powerOfAttorney/' . Str::slug($powerOfAttorney->template->title) . '-' . Str::slug($powerOfAttorney->trustor->tax_code);

        // 5. Создание директории, если её нет
        Storage::makeDirectory('public/' . $folderName);

        $fileName = Str::slug($powerOfAttorney->template->title) . '.docx';
        // 6. Полный путь для сохранения файла
        $filePath = 'public/' . $folderName . '/' . $fileName;
        $absoluteFilePath = storage_path('app/' . $filePath);


        // 2. Инициализация TemplateProcessor с шаблоном Word
        $templateProcessor = new TemplateProcessor($templatePath);

        // 3. Заменяем формулу ${'ТЕСТ'} на название файла
        $templateProcessor->setValue('ТЕСТ', $fileName);
        $this->convert->date_to_string($powerOfAttorney, $powerOfAttorney->issue_date);
        $templateProcessor->setValue('ДАТА-СЛОВАМИ', $powerOfAttorney->str_day->title . " " . $powerOfAttorney->str_month->title_r . " " . $powerOfAttorney->str_year->title_r);
        $this->convert->date_to_string($powerOfAttorney, $powerOfAttorney->expiry_date);
        $templateProcessor->setValue('ТЕРМІН-ДО', $powerOfAttorney->str_day->title . " " . $powerOfAttorney->str_month->title_r . " " . $powerOfAttorney->str_year->title_r);

        $templateProcessor->setValue('КЛ-ПІБ-Н', $this->convert->get_full_name_n($powerOfAttorney->trustor));
        $templateProcessor->setValue('КЛ-ДН', $powerOfAttorney->trustor->birth_date->format('d.m.Y'));
        $templateProcessor->setValue('КЛ-ІПН', $powerOfAttorney->trustor->tax_code);
        $templateProcessor->setValue('КЛ-ЗАРЕЄСТР', $this->getRegistrationWord($powerOfAttorney->trustor));
        $templateProcessor->setValue('КЛ-АДРЕСА', $this->convert->client_full_address_short($powerOfAttorney->trustor));

        $gender_whose = GenderWord::where('alias', "whose")->value($powerOfAttorney->trustor->gender);
        $templateProcessor->setValue('КЛ-ЇХ', $gender_whose);

        $templateProcessor->setValue('ДОВ-ПІБ-Р', $this->convert->get_full_name_r($powerOfAttorney->agent));
        $templateProcessor->setValue('ДОВ-ДН', $powerOfAttorney->agent->birth_date->format('d.m.Y'));
        $templateProcessor->setValue('ДОВ-ІПН', $powerOfAttorney->agent->tax_code);
        $templateProcessor->setValue('ДОВ-ЗАРЕЄСТР', $this->getRegistrationWord($powerOfAttorney->agent));
        $templateProcessor->setValue('ДОВ-АДРЕСА', $this->convert->client_full_address_short($powerOfAttorney->agent));

        // 7. Сохранение файла
        $templateProcessor->saveAs($absoluteFilePath);

        $templateProcessor = new TemplateProcessor($absoluteFilePath);
        $templateProcessor->setValue('КЛ-ПАСПОРТ-ШАБЛОН',$powerOfAttorney->trustor->passport_type ? $powerOfAttorney->trustor->passport_type->description_n : '');
        $templateProcessor->saveAs($absoluteFilePath);

        $templateProcessor = new TemplateProcessor($absoluteFilePath);
        $templateProcessor->setValue('pssprt-code', str_replace(" ", $this->non_break_space, $powerOfAttorney->trustor->passport_code));
        $templateProcessor->setValue('pssprt-date', $powerOfAttorney->trustor->passport_date->format('d.m.Y'));
        $templateProcessor->setValue('pssprt-depart', $powerOfAttorney->trustor->passport_department);
        $templateProcessor->setValue('pssprt-demogr', $powerOfAttorney->trustor->passport_demographic_code);
        $templateProcessor->saveAs($absoluteFilePath);

//        $templateProcessor = new TemplateProcessor($absoluteFilePath);
//        $templateProcessor->setValue('ДОВ-ПАСПОРТ-ШАБЛОН',$powerOfAttorney->agent->passport_type ? $powerOfAttorney->agent->passport_type->description_n : '');
//        $templateProcessor->saveAs($absoluteFilePath);
//
//        $templateProcessor = new TemplateProcessor($absoluteFilePath);
//        $templateProcessor->setValue('pssprt-code', str_replace(" ", $this->non_break_space, $powerOfAttorney->agent->passport_code));
//        $templateProcessor->setValue('pssprt-date', $powerOfAttorney->agent->passport_date->format('d.m.Y'));
//        $templateProcessor->setValue('pssprt-depart', $powerOfAttorney->agent->passport_department);
//        $templateProcessor->setValue('pssprt-demogr', $powerOfAttorney->agent->passport_demographic_code);
//        $templateProcessor->saveAs($absoluteFilePath);

        $templateProcessor = new TemplateProcessor($absoluteFilePath);

        if ($powerOfAttorney->general_car->type) {
            $templateProcessor->setValue('CAR-INFO', '${ВИРОБНИК-АВТО}, моделі ${КОМЕРЦІЙНИЙ-ОПИС}, рік випуску ${РІК-ВИРОБНИЦТВА}, номер шасі (кузова, рами) ${VIN-CODE}, тип ${ТИП}, реєстраційний номер ${НОМЕР-АВТО}, зареєстрований ${ДЕ-ЗАРЕЄСТРОВАНО}, ${ДАТА-РЕЄСТРАЦІЇ}, свідоцтво про реєстрацію ${НОМЕР-СВІДОЦТВА}');
        } else {
            $templateProcessor->setValue('CAR-INFO', '${ВИРОБНИК-АВТО}, комерційний опис ${КОМЕРЦІЙНИЙ-ОПИС}, особливі відмітки: ${ВІДМІТКА}, рік випуску ${РІК-ВИРОБНИЦТВА}, ідентифікаційний номер транспортного засобу ${VIN-CODE}, реєстраційний номер ${НОМЕР-АВТО}, зареєстрований ${ДЕ-ЗАРЕЄСТРОВАНО}, ${ДАТА-РЕЄСТРАЦІЇ}, свідоцтво про реєстрацію транспортного засобу ${НОМЕР-СВІДОЦТВА}');
        }

        $templateProcessor->saveAs($absoluteFilePath);

        $templateProcessor = new TemplateProcessor($absoluteFilePath);
        $templateProcessor->setValue('ВИРОБНИК-АВТО', $this->set_style_bold($powerOfAttorney->general_car->car_make));
        $templateProcessor->setValue('КОМЕРЦІЙНИЙ-ОПИС',  $this->set_style_bold($powerOfAttorney->general_car->commercial_description));
        $templateProcessor->setValue('ВІДМІТКА',  $this->set_style_bold($powerOfAttorney->general_car->special_notes));
        $templateProcessor->setValue('ТИП',  $this->set_style_bold($powerOfAttorney->general_car->type));
        $templateProcessor->setValue('РІК-ВИРОБНИЦТВА', $this->set_style_bold($powerOfAttorney->general_car->year_of_manufacture));
        $templateProcessor->setValue('НОМЕР-АВТО', $this->set_style_bold($powerOfAttorney->general_car->registration_number));
        $templateProcessor->setValue('VIN-CODE', $this->set_style_bold($powerOfAttorney->general_car->vin_code));
        $templateProcessor->setValue('ДЕ-ЗАРЕЄСТРОВАНО', $powerOfAttorney->general_car->registered);
        $templateProcessor->setValue('ДАТА-РЕЄСТРАЦІЇ', $powerOfAttorney->general_car->registration_date->format('d.m.Y'));
        $templateProcessor->setValue('НОМЕР-СВІДОЦТВА', $this->set_style_bold($powerOfAttorney->general_car->registration_certificate));
        $templateProcessor->saveAs($absoluteFilePath);


        // 8. Генерация ссылки для скачивания
        $downloadUrl = env('APP_URL') . Storage::url($filePath);

        // 9. Возврат ссылки пользователю
        return $this->sendResponse(['link' => [$downloadUrl]], 'test');
    }

    private function getRegistrationWord($client)
    {
        if ($client->registration)
            $word = GenderWord::where('alias', "registration")->value($client->gender);
        else
            $word = GenderWord::where('alias', "reside")->value($client->gender);

        return $word;
    }

    public function set_style_bold($text)
    {
        $str = $this->style_bold . $text . $this->style_end;

        return $str;
    }
}
