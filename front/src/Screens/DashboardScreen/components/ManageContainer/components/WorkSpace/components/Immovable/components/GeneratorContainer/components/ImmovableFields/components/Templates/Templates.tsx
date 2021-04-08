import * as React from 'react';
import CustomDatePicker from '../../../../../../../../../../../../../../components/CustomDatePicker';
import CustomSelect from '../../../../../../../../../../../../../../components/CustomSelect';
import CustomSwitch from '../../../../../../../../../../../../../../components/CustomSwitch';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';
import { useTemplates, Props } from './useTemplates';

const Templates = (props: Props) => {
  const meta = useTemplates(props);
  return (
    <div className="templates">
      <SectionWithTitle title="Договір">
        <div className="grid">
          <CustomSelect
            label="Тип договору"
            data={meta.contractType}
            onChange={(e) => meta.setData({ ...meta.data, type_id: +e })}
            selectedValue={meta.data.type_id}
          />
          <CustomSelect
            label="Шаблон договору"
            data={meta.contractTemplates}
            onChange={(e) => meta.setData({ ...meta.data, contract_template_id: +e })}
            selectedValue={meta.data.contract_template_id}
          />
          <CustomDatePicker
            label="Дата підписання договору"
            onSelect={(e) => meta.setData({ ...meta.data, sign_date: +e })}
            selectedDate={meta.data.sign_date}
          />

          <CustomSwitch
            label="Оброблений"
            onChange={(e) => meta.setData({ ...meta.data, ready: e })}
            selected={meta.data.ready}
          />
          <CustomDatePicker
            label="ПД - дата підписання ОД"
            onSelect={(e) => meta.setData({ ...meta.data, final_sign_date: +e })}
            selectedDate={meta.data.final_sign_date}
          />
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Оплата рахунку">
        <div className="flex-center">
          <CustomSelect
            label="Шаблон рахунку"
            data={meta.bankTemplates}
            onChange={(e) => meta.setData({ ...meta.data, bank_template_id: +e })}
            selectedValue={meta.data.bank_template_id}
            className="single"
          />
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Оплата податків">
        <div className="flex-center">
          <CustomSelect
            label="Шаблон рахунку податків"
            data={meta.taxesTemplates}
            onChange={(e) => meta.setData({ ...meta.data, taxes_template_id: +e })}
            selectedValue={meta.data.taxes_template_id}
            className="single"
          />
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Запит">
        <div className="flex-center">
          <CustomSelect
            label="Шаблон запиту"
            data={meta.statementTemplates}
            onChange={(e) => meta.setData({ ...meta.data, statement_template_id: +e })}
            selectedValue={meta.data.statement_template_id}
            className="single"
          />
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Анкета">
        <div className="flex-center">
          <CustomSelect
            label="Шаблон анкети"
            data={meta.questionnaireTemplates}
            onChange={(e) => meta.setData({ ...meta.data, questionnaire_template_id: +e })}
            selectedValue={meta.data.questionnaire_template_id}
            className="single"
          />
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={false} />
      </div>
    </div>
  );
};

export default Templates;
