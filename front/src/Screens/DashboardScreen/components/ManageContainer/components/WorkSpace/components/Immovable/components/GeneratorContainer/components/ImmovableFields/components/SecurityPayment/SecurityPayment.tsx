import * as React from 'react';
import CustomDatePicker from '../../../../../../../../../../../../../../components/CustomDatePicker';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../components/CustomSelect';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';
import { useSecurityPayment, Props } from './useSecurityPayment';

const SecurityPayment = (props: Props) => {
  const meta = useSecurityPayment(props);

  return (
    <div className="security-payment">
      <SectionWithTitle title="Забезпечувальний платіж" onClear={meta.onClear}>
        <div className="grid">
          <CustomInput
            label="I частина з. платежу у грн"
            onChange={(e) => meta.setData({ ...meta.data, first_part_grn: +e })}
            value={meta.data.first_part_grn}
          />
          <CustomSelect
            label="Клієнти"
            data={meta.clients}
            onChange={(e) => meta.setData({ ...meta.data, client_id: +e })}
            selectedValue={meta.data.client_id}
          />
          <CustomInput
            label="Номер договору резервування"
            onChange={(e) => meta.setData({ ...meta.data, reg_num: e })}
            value={meta.data.reg_num}
          />
          <CustomDatePicker
            label="Дата підписання"
            onSelect={(e) => meta.setData({ ...meta.data, sign_date: e })}
            selectedDate={meta.data.sign_date}
          />
          <CustomDatePicker
            label="Дата закінчення"
            onSelect={(e) => meta.setData({ ...meta.data, final_date: e })}
            selectedDate={meta.data.final_date}
          />
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={false} />
      </div>
    </div>
  );
};

export default SecurityPayment;
