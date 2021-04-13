import * as React from 'react';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../components/CustomSelect';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';
import { SelectItem } from '../../../../../../../../../../../../../../types';

type Props = {
  onChange: (arg: ManagerContractData) => void;
  type: SelectItem[],
  data: ManagerContractData;
}

export type ManagerContractData = {
  contract_type: string | null,
};

const Contract = ({ data, onChange, type }: Props) => {
  const handleClear = () => {
    onChange({
      contract_type: null
    });
  };

  return (
    <SectionWithTitle title="Договір" onClear={handleClear}>
      <div className="middle-column-fields">
        <div style={{ width: '360px' }}>
          <CustomSelect
            label="Тип договору"
            data={type}
            onChange={(e) => onChange({ ...data, contract_type: e })}
            selectedValue={data?.contract_type}
          />
        </div>
      </div>
    </SectionWithTitle>
  );
};

export default Contract;
