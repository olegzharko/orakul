import * as React from 'react';

import CustomDatePicker from '../../../../../../../../../../../../../../../components/CustomDatePicker';
import CustomInput from '../../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../../components/CustomSelect';
import PrimaryButton from '../../../../../../../../../../../../../../../components/PrimaryButton';
import RadioButtonsGroup from '../../../../../../../../../../../../../../../components/RadioButtonsGroup';
import SectionWithTitle from '../../../../../../../../../../../../../../../components/SectionWithTitle';

import { usePassport, Props } from './usePassport';

const Passport = (props: Props) => {
  const { sexButtons, passportTypes, data, setData, onClear, onSave } = usePassport(props);

  return (
    <div className="clients__passport">
      <SectionWithTitle title="Код та Паспортні данні" onClear={onClear}>
        <div className="grid mb20">
          <div className="sex">
            <p className="sex__title">Стать</p>
            <RadioButtonsGroup
              buttons={sexButtons}
              onChange={(e) => setData({ ...data, gender: e.toString() })}
              selected={data.gender}
              unicId="clients__passport-sex"
            />
          </div>

          <CustomDatePicker
            label="Дата народження"
            onSelect={(e) => setData({ ...data, date_of_birth: e })}
            selectedDate={data.date_of_birth}
          />
          <CustomInput
            label="ІПН"
            onChange={(e) => setData({ ...data, tax_code: e })}
            value={data.tax_code}
          />
          <CustomSelect
            label="Тип паспорту"
            data={passportTypes}
            onChange={(e) => setData({ ...data, passport_type_id: e })}
            selectedValue={data.passport_type_id}
          />
          <CustomInput
            label="Серія/Номер паспорту"
            onChange={(e) => setData({ ...data, passport_code: e })}
            value={data.passport_code}
          />
          <CustomDatePicker
            label="Дата видачі"
            onSelect={(e) => setData({ ...data, passport_date: e })}
            selectedDate={data.passport_date}
          />
        </div>

        <div className="mb20">
          <CustomInput
            label="Орган що видав паспорт"
            onChange={(e) => setData({ ...data, passport_department: e })}
            value={data.passport_department}
          />
        </div>

        <div className="grid">
          <CustomInput
            label="Запису в ЄДДР (для ID карток)"
            onChange={(e) => setData({ ...data, passport_demographic_code: e })}
            value={data.passport_demographic_code}
          />
          <CustomDatePicker
            label="Діє до"
            onSelect={(e) => setData({ ...data, passport_finale_date: e })}
            selectedDate={data.passport_finale_date}
          />
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={onSave} disabled={false} />
      </div>
    </div>
  );
};

export default Passport;
