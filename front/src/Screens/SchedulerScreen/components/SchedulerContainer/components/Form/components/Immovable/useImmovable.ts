/* eslint-disable no-unused-vars */
import { useState, useCallback, useEffect } from 'react';
import { SelectItem, ImmovableItem } from '../../useForm';

export type Props = {
  item: ImmovableItem;
  contracts: SelectItem[];
  immovableTypes: SelectItem[];
  building: SelectItem[];
  index: number;
  onChange: (index: number, value: ImmovableItem, input?: boolean) => void;
  onAddClick: () => void;
};

export const useImmovable = ({ index, onChange, item }: Props) => {
  // State
  const [selectedContract] = useState(item.contract_type_id || undefined);
  const [selectedBuilding] = useState(item.building_id || undefined);
  const [selectedImmovableType] = useState(item.imm_type_id || undefined);
  const [bank] = useState(item.bank || false);
  const [proxy] = useState(item.proxy || false);
  const [immNum] = useState(item.imm_num || undefined);

  // onChange functions
  const onContractChange = useCallback(
    (id: number) => {
      onChange(index, {
        ...item,
        contract_type_id: id,
      });
    },
    [onChange, index, item]
  );

  const onBuildingChange = useCallback(
    (id: string) => {
      onChange(index, {
        ...item,
        building_id: +id,
      });
    },
    [onChange, index, item]
  );

  const onImmovableTypeChange = useCallback(
    (id: number) => {
      onChange(index, {
        ...item,
        imm_type_id: id,
      });
    },
    [onChange, index, item]
  );

  const onBankChange = useCallback(
    (val: boolean) => {
      onChange(index, {
        ...item,
        bank: val,
      });
    },
    [onChange, index, item]
  );

  const onProxyChange = useCallback(
    (val: boolean) => {
      onChange(index, {
        ...item,
        proxy: val,
      });
    },
    [onChange, index, item]
  );

  const onImmNumChange = useCallback(
    (val: string) => {
      onChange(
        index,
        {
          ...item,
          imm_num: +val,
        },
        true
      );
    },
    [onChange, index, item]
  );

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
