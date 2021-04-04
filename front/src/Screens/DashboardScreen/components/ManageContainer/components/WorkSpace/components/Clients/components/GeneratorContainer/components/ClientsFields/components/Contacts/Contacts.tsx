import * as React from 'react';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';

const Contacts = () => (
  <div className="clients__contacts">
    <SectionWithTitle title="Контактна інформація" onClear={() => console.log('clear')}>
      <div className="middle-column-fields">
        <div className="input-container">
          <CustomInput
            label="Номер телефону"
            onChange={(e) => console.log(e)}
            value="+38050 000 00 00"
          />
        </div>

        <div className="input-container">
          <CustomInput
            label="Номер телефону"
            onChange={(e) => console.log(e)}
            value="+38050 000 00 00"
          />
        </div>
      </div>
    </SectionWithTitle>

    <div className="middle-button">
      <PrimaryButton label="Зберегти" onClick={() => console.log('click')} disabled={false} />
    </div>
  </div>
);

export default Contacts;
