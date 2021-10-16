import * as React from 'react';

import CustomInput from '../../../../../../../../../../../../../../../components/CustomInput';
import PhoneMaskInput from '../../../../../../../../../../../../../../../components/PhoneMaskInput';
import PrimaryButton from '../../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../../components/SectionWithTitle';
import { useContracts, Props } from './useContracts';

const Contacts = (props: Props) => {
  const { data, setData, onClear, onSave } = useContracts(props);

  return (
    <div className="clients__contacts">
      <SectionWithTitle title="Контактна інформація" onClear={onClear}>
        <div className="middle-column-fields">
          <div className="input-container">
            <PhoneMaskInput
              label="Номер телефону"
              onChange={(e) => setData({ ...data, phone: e })}
              value={data.phone}
            />
          </div>

          <div className="input-container">
            <CustomInput
              label="Email"
              onChange={(e) => setData({ ...data, email: e })}
              value={data.email}
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

export default Contacts;
