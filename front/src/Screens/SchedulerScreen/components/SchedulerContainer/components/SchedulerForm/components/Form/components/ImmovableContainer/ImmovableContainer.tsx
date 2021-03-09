/* eslint-disable react/destructuring-assignment */
/* eslint-disable no-unused-vars */
import React, { memo } from 'react';
import { v4 as uuidv4 } from 'uuid';
import AddFormButton from '../../../../../../../../../../components/AddFormButton';
import CustomInput from '../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../components/CustomSelect';
import CustomSwitch from '../../../../../../../../../../components/CustomSwitch';
import RadioButtonsGroup from '../../../../../../../../../../components/RadioButtonsGroup';
import RemoveFormButton from '../../../../../../../../../../components/RemoveFormButton';
import { ImmovableItem } from '../../../../../../../../../../types';
import { useImmovableContainer, Props } from './useImmovableContainer';

const ImmovableContainer = (props: Props) => {
  const meta = useImmovableContainer(props);
  return (
    <div className="mv12">
      {props.immovables.map((item: ImmovableItem, index: number) => (
        <>
          <RadioButtonsGroup
            buttons={meta.contracts}
            onChange={(val) => meta.onContractChange(index, val)}
            selected={item.contract_type_id}
            unicId={`contract-${index}`}
          />

          <div className="mv12">
            <CustomSelect
              onChange={(val) => meta.onBuildingChange(index, val)}
              data={meta.building}
              label="Будинок"
              selectedValue={item.building_id}
            />
          </div>

          <RadioButtonsGroup
            buttons={meta.immovableTypes}
            onChange={(val) => meta.onImmovableTypeChange(index, val)}
            selected={item.imm_type_id}
            unicId={`types-${index}`}
          />

          <div className="mv12">
            <CustomSwitch
              label="Банк"
              onChange={(val) => meta.onBankChange(index, val)}
              selected={item.bank}
            />
          </div>

          <div className="mv12">
            <CustomSwitch
              label="Довіреність"
              onChange={(val) => meta.onProxyChange(index, val)}
              selected={item.proxy}
            />
          </div>

          <div className="mv12 df-jc-sb">
            <CustomInput
              key="test"
              label="Номер приміщення"
              onChange={(val) => meta.onImmNumChange(index, val)}
              value={item.imm_num}
            />

            {props.immovables.length > 1 && (
              <div style={{ marginLeft: '12px' }}>
                <RemoveFormButton onClick={props.onRemove} index={index} />
              </div>
            )}

            {index === props.immovables.length - 1 && (
              <div style={{ marginLeft: '12px' }}>
                <AddFormButton onClick={props.onAdd} />
              </div>
            )}
          </div>
        </>
      ))}
    </div>
  );
};

export default memo(ImmovableContainer);
