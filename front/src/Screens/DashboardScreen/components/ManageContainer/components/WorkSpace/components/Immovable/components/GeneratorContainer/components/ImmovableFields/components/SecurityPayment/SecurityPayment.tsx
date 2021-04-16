import * as React from 'react';
import CustomDatePicker from '../../../../../../../../../../../../../../components/CustomDatePicker';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';
import { useSecurityPayment, Props } from './useSecurityPayment';

const SecurityPayment = (props: Props) => {
  const meta = useSecurityPayment(props);

  return (
    <div className="security-payment">
      <SectionWithTitle title="Забезпечувальний платіж" onClear={meta.onClear}>
        <div className="grid">
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
          <CustomInput
            label="Реєстраційний номер"
            onChange={(e) => meta.setData({ ...meta.data, reg_num: +e })}
            value={meta.data.reg_num}
          />

          <CustomInput
            label="I частина з. платежу у грн"
            onChange={(e) => meta.setData({ ...meta.data, first_part_grn: +e })}
            value={meta.data.first_part_grn}
          />
          <CustomInput
            label="II частина з. платежу у грн"
            onChange={(e) => meta.setData({ ...meta.data, last_part_grn: +e })}
            value={meta.data.last_part_grn}
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
