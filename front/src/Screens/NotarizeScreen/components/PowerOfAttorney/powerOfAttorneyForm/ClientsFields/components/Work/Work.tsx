import * as React from 'react';

import CustomInput from '../../../../../../../../components/CustomInput';
import PhoneMaskInput from '../../../../../../../../components/PhoneMaskInput';
import PrimaryButton from '../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../components/SectionWithTitle';
import { useWork, Props } from './useWork';

const Work = (props: Props) => {
  const { data, setData, onClear, onSave } = useWork(props);

  return (
    <div className="clients__contacts">
      <SectionWithTitle title="Місце роботи" onClear={onClear}>
        <div className="middle-column-fields">
          <div className="input-container" style={{ width: '1000px' }}>
            <CustomInput
              label="Компанія"
              onChange={(e) => setData({ ...data, company: e })}
              value={data.company}
            />
          </div>

          <div className="input-container" style={{ width: '1000px' }}>
            <CustomInput
              label="Посада"
              onChange={(e) => setData({ ...data, position: e })}
              value={data.position}
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

export default Work;
