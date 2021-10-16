import * as React from 'react';

import CustomInput from '../../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../../components/CustomSelect';
import SectionWithTitle from '../../../../../../../../../../../../../../../components/SectionWithTitle';
import { SelectItem } from '../../../../../../../../../../../../../../../types';

type Props = {
  title: string;
  onChange: (arg: ManagerGeneralData) => void;
  immovableTypes: SelectItem[],
  buildings: SelectItem[],
  data: ManagerGeneralData;
}

export type ManagerGeneralData = {
  immovable_type_id: string | null,
  building_id: string | null,
  immovable_number: string | null,
  immovable_reg_num: string | null,
}

const General = ({ title, data, onChange, immovableTypes, buildings }: Props) => {
  const handleClear = () => {
    onChange({
      immovable_type_id: null,
      building_id: null,
      immovable_number: null,
      immovable_reg_num: null,
    });
  };

  return (
    <SectionWithTitle title={title} onClear={handleClear}>
      <div className="grid-center-duet">
        <CustomSelect
          required
          label="Тип нерухомості"
          data={immovableTypes}
          onChange={(e) => onChange({ ...data, immovable_type_id: e })}
          selectedValue={data?.immovable_type_id}
        />

        <CustomSelect
          required
          label="Будинок"
          data={buildings}
          onChange={(e) => onChange({ ...data, building_id: e })}
          selectedValue={data?.building_id}
        />

        <CustomInput
          required
          label="Номер нерухомості"
          onChange={(e) => onChange({ ...data, immovable_number: e })}
          value={data?.immovable_number}
        />

        <CustomInput
          label="Реєстраційний номер"
          onChange={(e) => onChange({ ...data, immovable_reg_num: e })}
          value={data?.immovable_reg_num}
        />
      </div>
    </SectionWithTitle>
  );
};

export default General;
