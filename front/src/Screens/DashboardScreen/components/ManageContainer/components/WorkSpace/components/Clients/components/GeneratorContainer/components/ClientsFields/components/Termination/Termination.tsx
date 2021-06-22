import * as React from 'react';
import CustomDatePicker from '../../../../../../../../../../../../../../components/CustomDatePicker';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../components/CustomSelect';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';
import { useTermination, Props } from './useTermination';

const Termination = (props: Props) => {
  const meta = useTermination(props);

  return (
    <div className="termination">
      <SectionWithTitle title="Заява-згода на розірвання ПД" onClear={meta.onClear}>
        <div className="grid">
          <CustomSelect
            label="Нотаріус"
            data={meta.notaries}
            onChange={(e) => meta.setData({ ...meta.data, notary_id: e })}
            selectedValue={meta.data.notary_id}
          />

          <CustomDatePicker
            label="Дата посвідчення"
            onSelect={(e) => meta.setData({ ...meta.data, reg_date: e })}
            selectedDate={meta.data.reg_date}
          />

          <CustomInput
            label="Реєстровий номер"
            onChange={(e) => meta.setData({ ...meta.data, reg_number: e })}
            value={meta.data.reg_number}
          />

          <CustomSelect
            label="Шаблон згоди"
            data={meta.consentTemplates}
            onChange={(e) => meta.setData({ ...meta.data, consent_template_id: e })}
            selectedValue={meta.data.consent_template_id}
          />

          <CustomSelect
            label="Пункт згоди у договорі розірвання"
            data={meta.spouseWords}
            onChange={(e) => meta.setData({ ...meta.data, spouse_word_id: e })}
            selectedValue={meta.data.spouse_word_id}
          />
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={false} />
      </div>
    </div>
  );
};

export default Termination;
