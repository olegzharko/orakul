/* eslint-disable no-unused-vars */
import { useState } from 'react';
import { SelectItem, ImmovableItem } from '../../useForm';

export type Props = {
  initValues: ImmovableItem | {};
  contracts: SelectItem[];
  immovableTypes: SelectItem[];
  building: SelectItem[];
  index: number;
  onChange: (index: number, value: any) => void;
};

export const useImmovable = ({ index, onChange }: Props) => {
  // State
  const [selectedContract] = useState<any>();
  const [selectedBuilding] = useState();
  const [selectedImmovableType] = useState();
  const [bank] = useState(false);
  const [proxy] = useState(false);
  const [immNum] = useState();

  // onChange functions
  const onContractChange = (id: number) => {
    onChange(index, {
      contract_type_id: id,
    });
  };

  const onBuildingChange = (id: string) => {
    onChange(index, {
      building_id: +id,
    });
  };

  const onImmovableTypeChange = (id: number) => {
    onChange(index, {
      immovable_id: id,
    });
  };

  const onBankChange = (val: boolean) => {
    onChange(index, {
      bank: val,
    });
  };

  const onProxyChange = (val: boolean) => {
    onChange(index, {
      proxy: val,
    });
  };

  const onImmNumChange = (val: string) => {
    onChange(index, {
      imm_num: +val,
    });
  };

  return {
    selectedContract,
    selectedBuilding,
    selectedImmovableType,
    bank,
    proxy,
    immNum,
    onContractChange,
    onBuildingChange,
    onImmovableTypeChange,
    onBankChange,
    onProxyChange,
    onImmNumChange,
  };
};
