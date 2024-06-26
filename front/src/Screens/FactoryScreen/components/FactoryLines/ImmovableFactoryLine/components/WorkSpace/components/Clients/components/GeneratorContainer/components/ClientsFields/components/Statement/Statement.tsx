import * as React from 'react';

import CustomDatePicker from '../../../../../../../../../../../../../../../components/CustomDatePicker';
import CustomInput from '../../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../../components/CustomSelect';
import CustomSwitch from '../../../../../../../../../../../../../../../components/CustomSwitch';
import PrimaryButton from '../../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../../components/SectionWithTitle';

import { useStatement, Props } from './useStatement';

const Statement = (props: Props) => {
  const meta = useStatement(props);

  return (
    <div className="clients__statement">
      <SectionWithTitle title="Сімейний стан покупця" onClear={meta.onClear}>
        <div className="grid mb20">
          <CustomSelect
            label="Нотаріус"
            data={meta.rakulNotary}
            onChange={(e) => meta.setData({ ...meta.data, notary_id: e })}
            selectedValue={meta.data.notary_id}
          />
          <CustomDatePicker
            label="Дата посвідчення заяви"
            onSelect={(e) => meta.setData({ ...meta.data, sign_date: e })}
            selectedDate={meta.data.sign_date}
          />
          <CustomInput
            label="Реєстровий номер"
            onChange={(e) => meta.setData({ ...meta.data, reg_num: e })}
            value={meta.data.reg_num}
          />
          <CustomSelect
            label="Шаблон згоди"
            data={meta.consentTemplates}
            onChange={(e) => meta.setData({ ...meta.data, consent_template_id: e })}
            selectedValue={meta.data.consent_template_id}
          />
          <CustomSelect
            label="Тип назви свідоцтва"
            data={meta.marriageTypes}
            onChange={(e) => meta.setData({ ...meta.data, married_type_id: e })}
            selectedValue={meta.data.married_type_id}
          />
          <CustomSelect
            label="Пункт згоди у договорі"
            data={meta.consentSpouseWords}
            onChange={(e) => meta.setData({ ...meta.data, consent_spouse_word_id: e })}
            selectedValue={meta.data.consent_spouse_word_id}
          />
          <CustomInput
            label="Серія свідоцтва"
            onChange={(e) => meta.setData({ ...meta.data, mar_series: e })}
            value={meta.data.mar_series}
          />
          <CustomInput
            label="Номер свідоцтва"
            onChange={(e) => meta.setData({ ...meta.data, mar_series_num: e })}
            value={meta.data.mar_series_num}
          />
          <CustomDatePicker
            label="Дата видачі"
            onSelect={(e) => meta.setData({ ...meta.data, mar_date: e })}
            selectedDate={meta.data.mar_date}
          />
        </div>

        <div className="mb20">
          <CustomInput
            label="Орган, що видав в орудному відмінку. Ким? Чим?"
            onChange={(e) => meta.setData({ ...meta.data, mar_depart: e })}
            value={meta.data.mar_depart}
          />
        </div>

        <div className="grid mb20">
          <CustomInput
            label="Номер актового запису"
            onChange={(e) => meta.setData({ ...meta.data, mar_reg_num: e })}
            value={meta.data.mar_reg_num}
          />
          <CustomSwitch
            label="Видано повторно"
            selected={meta.data.duplicate}
            onChange={(e) => meta.setData({ ...meta.data, duplicate: e })}
          />
          <CustomDatePicker
            label="Дата, коли видано повторно"
            onSelect={(e) => meta.setData({ ...meta.data, duplicate_date: e })}
            selectedDate={meta.data.duplicate_date}
            disabled={!meta.data.duplicate}
          />
        </div>

        <div className="grid mb20">
          <CustomSwitch
            label="Вдівство"
            selected={meta.data.widow}
            onChange={(e) => meta.setData({ ...meta.data, widow: e })}
          />

          <CustomDatePicker
            label="Вдівство від"
            onSelect={(e) => meta.setData({ ...meta.data, widow_date: e })}
            selectedDate={meta.data.widow_date}
            disabled={!meta.data.widow}
          />
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={false} />
      </div>
    </div>
  );
};

export default Statement;
