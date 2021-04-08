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
            data={meta.contractTemplates}
            onChange={(e) => meta.setData({ ...meta.data, contract_template_id: +e })}
            selectedValue={meta.data.contract_template_id}
          />
          <CustomSelect
            label="Шаблон договору"
            data={[]}
            onChange={(e) => console.log(e)}
          />
          <CustomDatePicker label="Дата підписання договору" onSelect={(e) => console.log(e)} />
          <CustomSwitch label="Оброблений" onChange={(e) => console.log(e)} selected={false} />
          <CustomDatePicker label="ПД - дата підписання ОД" onSelect={(e) => console.log(e)} />
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
        <div className="grid-center-duet">
          <CustomSelect
            label="Шаблон запиту"
            data={meta.statementTemplates}
            onChange={(e) => meta.setData({ ...meta.data, statement_template_id: +e })}
            selectedValue={meta.data.statement_template_id}
          />
          <CustomDatePicker label="Дата підписання запиту" onSelect={(e) => console.log(e)} />
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Анкета">
        <div className="grid-center-duet">
          <CustomSelect
            label="Шаблон анкети"
            data={meta.questionnaireTemplates}
            onChange={(e) => meta.setData({ ...meta.data, questionnaire_template_id: +e })}
            selectedValue={meta.data.questionnaire_template_id}
          />
          <CustomDatePicker label="Дата підписання анкети" onSelect={(e) => console.log(e)} />
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={false} />
      </div>
    </div>
  );
};

export default Templates;
