import * as React from 'react';

import CustomInput from '../../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../../components/CustomSelect';
import SectionWithTitle from '../../../../../../../../../../../../../../../components/SectionWithTitle';
import { SelectItem } from '../../../../../../../../../../../../../../../types';

type Props = {
  onChange: (arg: ManagerContractData) => void;
  types: SelectItem[],
  data: ManagerContractData;
}

export type ManagerContractData = {
  contract_type_id: string | null,
};

const Contract = ({ data, onChange, types }: Props) => {
  const handleClear = () => {
    onChange({
      contract_type_id: null
    });
  };

  return (
    <SectionWithTitle title="Договір" onClear={handleClear}>
      <div className="middle-column-fields">
        <div style={{ width: '360px' }}>
          <CustomSelect
            label="Тип договору"
            data={types}
            onChange={(e) => onChange({ ...data, contract_type_id: e })}
            selectedValue={data?.contract_type_id}
          />
        </div>
      </div>
    </SectionWithTitle>
  );
};

export default Contract;
