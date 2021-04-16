/* eslint-disable prettier/prettier */
/* eslint-disable react/destructuring-assignment */
/* eslint-disable no-unused-vars */
import React, { memo } from 'react';
import './index.scss';
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
    <div className="mv12 immovables__group">
      {props.immovables.map((item: ImmovableItem, index: number) => (
        <div className="immovables__item mv12">
          <RadioButtonsGroup
            buttons={
              props.disabled
                ? meta.contracts.filter(
                  ({ id }: any) => id === (item.contract_type_id || meta.contracts[0].id)
                )
                : meta.contracts
            }
            onChange={(val) => meta.onContractChange(index, +val)}
            selected={item.contract_type_id}
            unicId={`contract-${index}`}
          />

          <div className="mv12">
            <CustomSelect
              required
              onChange={(val) => meta.onBuildingChange(index, val)}
              data={meta.building}
              label="Будинок"
              selectedValue={item.building_id}
              disabled={props.disabled || false}
            />
          </div>

          <RadioButtonsGroup
            buttons={
              props.disabled
                ? meta.immovableTypes.filter(
                  ({ id }: any) => id === (item.imm_type_id || meta.immovableTypes[0].id)
                )
                : meta.immovableTypes
            }
            onChange={(val) => meta.onImmovableTypeChange(index, +val)}
            selected={item.imm_type_id}
            unicId={`types-${index}`}
          />

          <div className="mv12">
            <CustomSwitch
              label="Банк"
              onChange={(val) => meta.onBankChange(index, val)}
              selected={item.bank}
              disabled={props.disabled}
            />
          </div>

          <div className="mv12">
            <CustomSwitch
              label="Довіреність"
              onChange={(val) => meta.onProxyChange(index, val)}
              selected={item.proxy}
              disabled={props.disabled}
            />
          </div>

          <div className="mv12 df-jc-sb">
            <CustomInput
              required
              key="test"
              label="Номер приміщення"
              onChange={(val) => meta.onImmNumChange(index, val)}
              value={item.imm_number}
              disabled={props.disabled}
            />

            {props.immovables.length > 1 && (
              <div style={{ marginLeft: '12px' }}>
                <RemoveFormButton
                  onClick={props.onRemove}
                  index={index}
                  disabled={props.disabled}
                />
              </div>
            )}

            {index === props.immovables.length - 1 && (
              <div style={{ marginLeft: '12px' }}>
                <AddFormButton
                  onClick={props.onAdd}
                  disabled={props.disabled}
                />
              </div>
            )}
          </div>
        </div>
      ))}
    </div>
  );
};

export default memo(ImmovableContainer);
