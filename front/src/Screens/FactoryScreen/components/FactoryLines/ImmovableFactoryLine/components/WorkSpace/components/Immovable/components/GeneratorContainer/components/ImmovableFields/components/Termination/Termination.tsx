import * as React from 'react';

import CustomDatePicker from '../../../../../../../../../../../../../../../components/CustomDatePicker';
import CustomInput from '../../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../../components/CustomSelect';
import PrimaryButton from '../../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../../components/SectionWithTitle';

import { Props, useTermination } from './useTermination';

const Termination = (props: Props) => {
  const meta = useTermination(props);

  return (
    <div className="termination">
      <SectionWithTitle title="Розірвання попереднього договору" onClear={meta.onClear}>
        <div className="grid mb20">
          <CustomSelect
            label="Нотаріус"
            data={meta.notaries}
            onChange={(e) => meta.setData({ ...meta.data, notary_id: e })}
            selectedValue={meta.data.notary_id}
          />

          <CustomDatePicker
            label="Дата посвідчення"
            selectedDate={meta.data.reg_date}
            onSelect={(e) => meta.setData({ ...meta.data, reg_date: e })}
          />

          <CustomInput
            label="Реєстровий номер"
            value={meta.data.reg_number}
            onChange={(e) => meta.setData({ ...meta.data, reg_number: e })}
          />

          <CustomInput
            label="Сума повернення коштів в гривнях"
            value={meta.data.price_grn}
            onChange={(e) => meta.setData({ ...meta.data, price_grn: e })}
          />

          <CustomInput
            label="Сума повернення коштів в доларах"
            value={meta.data.price_dollar}
            onChange={(e) => meta.setData({ ...meta.data, price_dollar: e })}
          />
        </div>

        <div className="grid">
          <CustomSelect
            label="Клієнт 1"
            data={meta.clients}
            onChange={(e) => meta.setData({ ...meta.data, first_client_id: e })}
            selectedValue={meta.data.first_client_id}
          />

          <CustomSelect
            label="Клієнт 2"
            data={meta.clients}
            onChange={(e) => meta.setData({ ...meta.data, second_client_id: e })}
            selectedValue={meta.data.second_client_id}
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
