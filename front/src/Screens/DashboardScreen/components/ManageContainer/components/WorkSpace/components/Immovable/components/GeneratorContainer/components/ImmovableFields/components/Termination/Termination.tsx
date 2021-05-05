import * as React from 'react';
import CustomDatePicker from '../../../../../../../../../../../../../../components/CustomDatePicker';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../components/CustomSelect';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';
import { Props, useTermination } from './useTermination';

const Termination = (props: Props) => {
  const meta = useTermination(props);

  return (
    <div className="termination">
      <SectionWithTitle title="Розірвання попереднього договру" onClear={meta.onClear}>
        <div className="grid-center-duet">
          <CustomInput
            label="Сума повернення коштів"
            value={meta.data.price}
            onChange={(e) => meta.setData({ ...meta.data, price: +e })}
          />

          <CustomSelect
            label="Нотаріус"
            data={meta.notaries}
            onChange={(e) => meta.setData({ ...meta.data, notary_id: +e })}
          />

          <CustomDatePicker
            label="Дата посвідчення"
            selectedDate={meta.data.reg_date}
            onSelect={(e) => meta.setData({ ...meta.data, reg_date: e })}
          />

          <CustomInput
            label="Реєстраційний номер"
            value={meta.data.reg_number}
            onChange={(e) => meta.setData({ ...meta.data, reg_number: e })}
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
