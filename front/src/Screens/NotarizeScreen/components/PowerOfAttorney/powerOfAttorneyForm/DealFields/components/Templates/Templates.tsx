import * as React from 'react';

import CustomDatePicker from '../../../../../../../../components/CustomDatePicker';
import CustomSelect from '../../../../../../../../components/CustomSelect';
import PrimaryButton from '../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../components/SectionWithTitle';

import { useTemplates, Props } from './useTemplates';

const Templates = (props: Props) => {
  const meta = useTemplates(props);

  return (
    <div className="templates">
      <SectionWithTitle title="Довіреність">
        <div className="grid">
          <CustomSelect
            label="Шаблон довіреності"
            data={meta.contractTemplates}
            onChange={(e) => meta.setData({ ...meta.data, contract_template_id: +e })}
            selectedValue={meta.data.contract_template_id}
          />
          <CustomDatePicker
            label="Дата підписання"
            onSelect={(e) => meta.setData({ ...meta.data, issue_date: e })}
            selectedDate={meta.data.issue_date}
          />

          <CustomDatePicker
            label="Кінцева дата дії довіреності"
            onSelect={(e) => meta.setData({ ...meta.data, expiry_date: e })}
            selectedDate={meta.data.expiry_date}
          />
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Генерувати" onClick={meta.onSave} disabled={false} />
      </div>
    </div>
  );
};

export default Templates;
