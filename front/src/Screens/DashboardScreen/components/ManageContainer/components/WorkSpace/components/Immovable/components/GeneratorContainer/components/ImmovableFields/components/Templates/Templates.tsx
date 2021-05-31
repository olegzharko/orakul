import * as React from 'react';
import CustomDatePicker from '../../../../../../../../../../../../../../components/CustomDatePicker';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
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
            onSelect={(e) => meta.setData({ ...meta.data, sign_date: e })}
            selectedDate={meta.data.sign_date}
          />

          <CustomSwitch
            label="Оброблений"
            onChange={(e) => meta.setData({ ...meta.data, ready: e })}
            selected={meta.data.ready}
          />
          <CustomDatePicker
            label="ПД - дата підписання ОД"
            onSelect={(e) => meta.setData({ ...meta.data, final_sign_date: e })}
            selectedDate={meta.data.final_sign_date}
          />
          <CustomSwitch
            label="Усний переклад"
            onChange={(e) => meta.setData({ ...meta.data, translate: e })}
            selected={meta.data.translate}
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

      <SectionWithTitle title="Запит щодо зареєстрованих осіб">
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

      <SectionWithTitle title="Анкета фінансового моніторінгу">
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

      <SectionWithTitle title="Довіреність щодо надання комунальних та інших послуг">
        <div className="flex-center">
          <CustomSelect
            label="Шаблон по коммунальним"
            data={meta.communalTemplates}
            onChange={(e) => meta.setData({ ...meta.data, communal_template_id: +e })}
            selectedValue={meta.data.communal_template_id}
            className="single"
          />
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Договір розірвання ПД">
        <div className="flex-center">
          <CustomSelect
            label="Шаблон договору розірвання ПД"
            data={meta.terminationContracts}
            onChange={(e) => meta.setData({ ...meta.data, termination_contract_id: +e })}
            selectedValue={meta.data.termination_contract_id}
            className="single"
          />
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Заява про повернення коштів">
        <div className="grid-center-duet">
          <CustomSelect
            label="Шаблон договору розірвання ПД"
            data={meta.terminationRefunds}
            onChange={(e) => meta.setData({ ...meta.data, termination_refund_id: +e })}
            selectedValue={meta.data.termination_refund_id}
          />

          <CustomSelect
            label="Нотаріус"
            data={meta.notaries}
            onChange={(e) => meta.setData({ ...meta.data, termination_refund_notary_id: e })}
            selectedValue={meta.data.termination_refund_notary_id}
          />

          <CustomDatePicker
            label="Дата посвідчення"
            onSelect={(e) => meta.setData({ ...meta.data, termination_refund_reg_date: e })}
            selectedDate={meta.data.termination_refund_reg_date}
          />

          <CustomInput
            label="Реєстровий номер"
            onChange={(e) => meta.setData({ ...meta.data, termination_refund_reg_number: e })}
            value={meta.data.termination_refund_reg_number}
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
