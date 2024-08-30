import * as React from 'react';

import CustomInput from '../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../components/CustomSelect';
import PrimaryButton from '../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../components/SectionWithTitle';
import CustomDatePicker from '../../../../../../../../components/CustomDatePicker';

import { useGeneral, Props } from './useGeneral';

const General = (props: Props) => {
  const meta = useGeneral(props);

  return (
    <>
      <SectionWithTitle title="Загальні дані" onClear={meta.onClear}>
        <div className="general grid-center-duet">
          <CustomInput
            label="Автомобільна марка"
            onChange={(e) => meta.setData({ ...meta.data, car_make: e })}
            value={meta.data.car_make}
          />
          <CustomInput
            label="Комерційний опис"
            onChange={(e) => meta.setData({ ...meta.data, commercial_description: e })}
            value={meta.data.commercial_description}
          />
        </div>
        <br />
        <div className="general grid-center-duet">
          <CustomInput
            label="Тип кузову"
            onChange={(e) => meta.setData({ ...meta.data, type: e })}
            value={meta.data.type}
          />
          <CustomInput
            label="Особливі відмітки"
            onChange={(e) => meta.setData({ ...meta.data, special_notes: e })}
            value={meta.data.special_notes}
          />
        </div>
        <br />
        <div className="general grid-center-duet">
          <CustomInput
            type="number"
            label="Рік випуску"
            onChange={(e) => meta.setData({ ...meta.data, year_of_manufacture: e })}
            value={meta.data.year_of_manufacture}
          />
          <CustomInput
            label="VIN-код"
            onChange={(e) => meta.setData({ ...meta.data, vin_code: e })}
            value={meta.data.vin_code}
          />
        </div>
        <br />
        <div className="general grid-center-duet">
          <CustomInput
            label="Реєстраційний номер"
            onChange={(e) => meta.setData({ ...meta.data, registration_number: e })}
            value={meta.data.registration_number}
          />
          <CustomInput
            label="Зареєстровано"
            onChange={(e) => meta.setData({ ...meta.data, registered: e })}
            value={meta.data.registered}
          />
        </div>
        <br />
        <div className="general grid-center-duet">
          <CustomDatePicker
            label="Дата підписання"
            onSelect={(e) => meta.setData({ ...meta.data, registration_date: e })}
            selectedDate={meta.data.registration_date}
          />
          <CustomInput
            label="Свідоцтво реєстрації"
            onChange={(e) => meta.setData({ ...meta.data, registration_certificate: e })}
            value={meta.data.registration_certificate}
          />
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={meta.isSaveButtonDisable} />
      </div>
    </>
  );
};

export default General;
