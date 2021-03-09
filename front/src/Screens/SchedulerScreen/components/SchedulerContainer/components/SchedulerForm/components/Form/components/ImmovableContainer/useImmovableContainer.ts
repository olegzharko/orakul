import { useMemo, useCallback } from 'react';
import { useSelector } from 'react-redux';
import { State } from '../../../../../../../../../../store/types';
import {
  ImmovableItem,
  ImmovableItems,
} from '../../../../../../../../../../types';

export type Props = {
  immovables: ImmovableItems;
  onChange: (index: number, value: ImmovableItem) => void;
  onAdd: () => void;
  onRemove: (index: number) => void;
};

export const useImmovableContainer = ({ immovables, onChange }: Props) => {
  const { options, developersInfo } = useSelector(
    (state: State) => state.scheduler
  );

  const building = useMemo(() => developersInfo?.building || [], [
    developersInfo,
  ]);

  const contracts = useMemo(() => options?.form_data.contract_type, [options]);

  const immovableTypes = useMemo(() => options?.form_data.immovable_type, [
    options,
  ]);

  // onChange functions
  const onContractChange = useCallback(
    (index: number, id: number) => {
      onChange(index, {
        ...immovables[index],
        contract_type_id: id,
      });
    },
    [immovables]
  );

  const onBuildingChange = useCallback(
    (index: number, id: string) => {
      onChange(index, {
        ...immovables[index],
        building_id: +id,
      });
    },
    [immovables]
  );

  const onImmovableTypeChange = useCallback(
    (index: number, id: number) => {
      onChange(index, {
        ...immovables[index],
        imm_type_id: id,
      });
    },
    [immovables]
  );

  const onBankChange = useCallback(
    (index: number, val: boolean) => {
      onChange(index, {
        ...immovables[index],
        bank: val,
      });
    },
    [immovables]
  );

  const onProxyChange = useCallback(
    (index: number, val: boolean) => {
      onChange(index, {
        ...immovables[index],
        proxy: val,
      });
    },
    [immovables]
  );

  const onImmNumChange = useCallback(
    (index: number, val: string) => {
      onChange(index, {
        ...immovables[index],
        imm_num: +val,
      });
    },
    [immovables]
  );

  return {
    building,
    contracts,
    immovableTypes,
    onContractChange,
    onBuildingChange,
    onImmovableTypeChange,
    onBankChange,
    onProxyChange,
    onImmNumChange,
  };
};
