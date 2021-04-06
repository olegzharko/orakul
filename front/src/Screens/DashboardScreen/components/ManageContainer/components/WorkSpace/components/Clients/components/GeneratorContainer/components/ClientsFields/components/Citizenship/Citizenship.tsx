import * as React from 'react';
import CustomSelect from '../../../../../../../../../../../../../../components/CustomSelect';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';
import { useCitizenship, Props } from './useCitizenship';

const Citizenship = (props: Props) => {
  const { data, selected, setSelected, onSave } = useCitizenship(props);

  return (
    <div className="clients__citizenship">
      <SectionWithTitle title="Громадянство країни">
        <div className="middle-column-fields">
          <div className="input-container">
            <CustomSelect
              data={data}
              label="Громадянство"
              onChange={setSelected}
              selectedValue={selected}
            />
          </div>
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={onSave} disabled={false} />
      </div>
    </div>
  );
};

export default Citizenship;
