import { data } from 'jquery';
import * as React from 'react';
import CustomDatePicker from '../../../../../../../../../../../../../../components/CustomDatePicker';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../components/CustomSelect';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';
import { useOwnership, Props } from './useOwnership';

const Ownership = (props: Props) => {
  const meta = useOwnership(props);

  return (
    <div className="ownership">
      <SectionWithTitle title="Право власності" onClear={meta.onClear}>
        <div className="grid-center-duet mb20">
          <CustomSelect
            label="Нотаріус"
            data={meta.notary}
            onChange={(e) => meta.setData({ ...meta.data, notary_id: e })}
            selectedValue={meta.data.notary_id}
          />
          {/* <CustomSelect
            label="Нотаріус"
            data={meta.notary}
            onChange={(e) => meta.setData({ ...meta.data, notary_id: e })}
            selectedValue={meta.data.notary_id}
          /> */}
        </div>
        <div className="grid-center-duet">
          <CustomDatePicker
            label="Дата запису про право власності"
            onSelect={(e) => meta.setData({ ...meta.data, reg_date: e })}
            selectedDate={meta.data.reg_date}
          />
          <CustomInput
            label="Номер запису про право власності"
            onChange={(e) => meta.setData({ ...meta.data, reg_number: +e })}
            value={meta.data.reg_number}
          />

          <CustomDatePicker
            label="Дата витягу на право власності"
            onSelect={(e) => meta.setData({ ...meta.data, discharge_date: e })}
            selectedDate={meta.data.discharge_date}
          />
          <CustomInput
            label="Номер витягу на право власності"
            onChange={(e) => meta.setData({ ...meta.data, discharge_number: +e })}
            value={meta.data.discharge_number}
          />
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={false} />
      </div>
    </div>
  );
};

export default Ownership;
