import * as React from 'react';
import CustomDatePicker from '../../../../../../../../../../../../../../components/CustomDatePicker';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../components/CustomSelect';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';
import { usePowerOfAttorney, Props } from './usePowerOfAttorney';

const PowerOfAttorney = (props: Props) => {
  const meta = usePowerOfAttorney(props);

  return (
    <div className="clients__power-of-attorney">
      <SectionWithTitle title="Довіреність представника клієнта" onClear={meta.onClear}>
        <div className="grid">
          <CustomSelect
            label="Нотаріус"
            data={meta.notary}
            onChange={(e) => meta.setData({ ...meta.data, notary_id: e })}
            selectedValue={meta.data.notary_id}
          />
          <CustomInput
            label="Реєстровий номер"
            onChange={(e) => meta.setData({ ...meta.data, reg_num: e })}
            value={meta.data.reg_num}
          />
          <CustomDatePicker
            label="Дата видачі"
            onSelect={(e) => meta.setData({ ...meta.data, reg_date: e })}
            selectedDate={meta.data.reg_date}
          />
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={false} />
      </div>
    </div>
  );
};

export default PowerOfAttorney;
