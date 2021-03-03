import * as React from 'react';
import AddFormButton from '../../../../../../../../components/AddFormButton';
import CustomInput from '../../../../../../../../components/CustomInput/CustomInput';

const Clients = () => (
  <>
    <CustomInput label="ПІБ" onChange={(val) => console.log(val)} />

    <div className="mv12 df-jc-sb">
      <CustomInput
        label="Номер телефону"
        onChange={(val) => console.log(val)}
      />

      <div style={{ marginLeft: '12px' }}>
        <AddFormButton onClick={() => console.log('click')} />
      </div>
    </div>
  </>
);

export default Clients;
