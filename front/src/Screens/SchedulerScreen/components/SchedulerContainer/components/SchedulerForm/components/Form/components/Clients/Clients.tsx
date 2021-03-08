/* eslint-disable react/destructuring-assignment */
import React, { memo } from 'react';
import AddFormButton from '../../../../../../../../../../components/AddFormButton';
import CustomInput from '../../../../../../../../../../components/CustomInput/CustomInput';
import { Props, useClients } from './useClients';

const Clients = (props: Props) => {
  const meta = useClients(props);

  return (
    <div className="mv12">
      {props.clients.map((item, index) => (
        <>
          <CustomInput
            label="ПІБ"
            value={item.full_name}
            onChange={(val) => meta.onNameChange(index, val)}
          />

          <div className="mv12 df-jc-sb">
            <CustomInput
              label="Номер телефону"
              value={item.phone}
              onChange={(val) => meta.onPhoneChange(index, val)}
            />

            <div style={{ marginLeft: '12px' }}>
              <AddFormButton onClick={props.onAdd} />
            </div>
          </div>
        </>
      ))}
    </div>
  );
};

export default memo(Clients);
