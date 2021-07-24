import * as React from 'react';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../components/CustomSelect';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';
import { useGeneral, Props } from './useGeneral';

const General = (props: Props) => {
  const meta = useGeneral(props);

  return (
    <>
      <SectionWithTitle title="Загальні дані" onClear={meta.onClear}>
        <div className="general grid-center-duet">
          <CustomSelect
            required
            label="Тип нерухомості"
            data={meta.immType}
            onChange={(e) => meta.setData({ ...meta.data, imm_type_id: +e })}
            selectedValue={meta.data.imm_type_id}
          />
          <CustomSelect
            required
            label="Адреса"
            data={meta.building}
            onChange={(e) => meta.setData({ ...meta.data, building_id: e })}
            selectedValue={meta.data.building_id}
          />

          <CustomInput
            required
            label="Номер нерухомості"
            onChange={(e) => meta.setData({ ...meta.data, imm_number: e })}
            value={meta.data.imm_number}
          />
          <CustomInput
            label="Реєстраційний номер"
            onChange={(e) => meta.setData({ ...meta.data, registration_number: e })}
            value={meta.data.registration_number}
          />

          <CustomInput
            label="Повна вартість в гривнях"
            onChange={(e) => meta.setData({ ...meta.data, price_grn: e })}
            value={meta.data.price_grn}
          />

          <div />

          <div className="duet">
            <CustomInput
              label="Загальна площа"
              onChange={(e) => meta.setData({ ...meta.data, total_space: e })}
              value={meta.data.total_space}
            />
            <CustomInput
              label="Житлова площа"
              onChange={(e) => meta.setData({ ...meta.data, living_space: e })}
              value={meta.data.living_space}
            />
          </div>

          <div className="trio">
            <CustomSelect
              label="К-ть кімнат"
              data={meta.roominess}
              onChange={(e) => meta.setData({ ...meta.data, roominess_id: e })}
              selectedValue={meta.data.roominess_id}
            />
            <CustomInput
              label="№ поверху"
              onChange={(e) => meta.setData({ ...meta.data, floor: e })}
              value={meta.data.floor}
            />
            <CustomInput
              label="№ секції"
              onChange={(e) => meta.setData({ ...meta.data, section: +e })}
              value={meta.data.section}
            />
          </div>
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={meta.isSaveButtonDisable} />
      </div>
    </>
  );
};

export default General;
