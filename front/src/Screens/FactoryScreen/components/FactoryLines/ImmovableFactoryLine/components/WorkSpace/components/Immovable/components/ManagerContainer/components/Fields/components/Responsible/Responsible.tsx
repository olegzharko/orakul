import * as React from 'react';
import CustomInput from '../../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../../components/CustomSelect';
import SectionWithTitle from '../../../../../../../../../../../../../../../components/SectionWithTitle';
import { SelectItem } from '../../../../../../../../../../../../../../../types';

type Props = {
  onChange: (arg: ManagerResponsibleData) => void;
  reader: SelectItem[],
  accompanying: SelectItem[],
  data: ManagerResponsibleData;
}

export type ManagerResponsibleData = {
  reader_id: string | null,
  accompanying_id: string | null,
};

const Responsible = ({ data, onChange, reader, accompanying }: Props) => {
  const handleClear = () => {
    onChange({
      reader_id: null,
      accompanying_id: null,
    });
  };

  return (
    <SectionWithTitle title="Відповідaльні особи" onClear={handleClear}>
      <div className="grid-center-duet">
        <CustomSelect
          label="Читач"
          data={reader}
          onChange={(e) => onChange({ ...data, reader_id: e })}
          selectedValue={data?.reader_id}
        />

        <CustomSelect
          label="Видавач"
          data={accompanying}
          onChange={(e) => onChange({ ...data, accompanying_id: e })}
          selectedValue={data?.accompanying_id}
        />
      </div>
    </SectionWithTitle>
  );
};

export default Responsible;
