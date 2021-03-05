/* eslint-disable react/destructuring-assignment */
/* eslint-disable no-unused-vars */
import React from 'react';
import RadioButtonsGroup from '../../../../../../../../components/RadioButtonsGroup';
import CustomSelect from '../../../../../../../../components/CustomSelect';
import CustomSwitch from '../../../../../../../../components/CustomSwitch/CustomSwitch';
import CustomInput from '../../../../../../../../components/CustomInput';
import AddFormButton from '../../../../../../../../components/AddFormButton';
import { Props, useImmovable } from './useImmovable';

const Immovable = (props: Props) => {
  const meta = useImmovable(props);

  return (
    <>
      <RadioButtonsGroup
        buttons={props.contracts}
        onChange={meta.onContractChange}
        initial={meta.selectedContract}
      />

      <div className="mv12">
        <CustomSelect
          onChange={meta.onBuildingChange}
          data={props.building}
          label="Будинок"
          selectedValue={meta.selectedBuilding}
        />
      </div>

      <RadioButtonsGroup
        buttons={props.immovableTypes}
        onChange={meta.onImmovableTypeChange}
        initial={meta.selectedImmovableType}
      />

      <div className="mv12">
        <CustomSwitch
          label="Банк"
          onChange={meta.onBankChange}
          selected={meta.bank}
        />
      </div>

      <div className="mv12">
        <CustomSwitch
          label="Довіреність"
          onChange={meta.onProxyChange}
          selected={meta.proxy}
        />
      </div>

      <div className="mv12 df-jc-sb">
        <CustomInput
          label="Номер приміщення"
          type="number"
          onChange={meta.onImmNumChange}
          value={meta.immNum}
        />

        <div style={{ marginLeft: '12px' }}>
          <AddFormButton onClick={() => console.log('click')} />
        </div>
      </div>
    </>
  );
};

export default Immovable;
