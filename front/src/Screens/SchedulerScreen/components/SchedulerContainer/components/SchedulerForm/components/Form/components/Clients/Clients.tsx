/* eslint-disable react/destructuring-assignment */
import React, { memo } from 'react';
import './index.scss';
import { v4 as uuidv4 } from 'uuid';
import AddFormButton from '../../../../../../../../../../components/AddFormButton';
import CustomInput from '../../../../../../../../../../components/CustomInput/CustomInput';
import RemoveFormButton from '../../../../../../../../../../components/RemoveFormButton';
import { Props, useClients } from './useClients';

const Clients = (props: Props) => {
  const meta = useClients(props);

  return (
    <div className="mv12">
      {props.clients.map((item, index) => (
        <div className="clients__item mv12" key={uuidv4()}>
          <CustomInput
            label="ПІБ"
            value={item.full_name}
            onChange={(val) => meta.onNameChange(index, val)}
            disabled={props.disabled || false}
          />

          <div className="mv12 df-jc-sb">
            <CustomInput
              label="Номер телефону"
              value={item.phone}
              onChange={(val) => meta.onPhoneChange(index, val)}
              disabled={props.disabled || false}
            />

            {props.clients.length > 1 && (
              <div style={{ marginLeft: '12px' }}>
                <RemoveFormButton
                  onClick={props.onRemove}
                  index={index}
                  disabled={props.disabled || false}
                />
              </div>
            )}

            {index === props.clients.length - 1 && (
              <div style={{ marginLeft: '12px' }}>
                <AddFormButton
                  onClick={props.onAdd}
                  disabled={props.disabled || false}
                />
              </div>
            )}
          </div>
        </div>
      ))}
    </div>
  );
};

export default memo(Clients);
