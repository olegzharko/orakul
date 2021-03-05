/* eslint-disable arrow-body-style */
import { useMemo, useState, useCallback } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { State } from '../../../../../../store/types';
import fetchDeveloperInfo from '../../../../../../actions/fetchDeveloperInfo';
import { setDevelopersInfo } from '../../../../../../store/scheduler/actions';

export type SelectItem = {
  id: number;
  title: string;
};

export type ImmovableItem = {
  contract_type_id: number | null;
  building_id: number | null;
  immovable_id: number | null;
  imm_type_id: number | null;
  imm_num: number | null;
  bank: boolean;
  proxy: boolean;
};

export type ImmovableItemKey = keyof ImmovableItem;

// const immovableItem: ImmovableItem = {
//   contract_type_id: null,
//   building_id: null,
//   immovable_id: null,
//   imm_type_id: null,
//   imm_num: null,
//   bank: false,
//   proxy: false,
// };

type ImmovableItems = ImmovableItem[];

export const useForm = () => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.token);
  const { options, developersInfo, isLoading } = useSelector(
    (state: State) => state.scheduler
  );

  // Form State
  const [notary, setNotary] = useState();
  const [devCompanyId, setDevCompanyId] = useState();
  const [devRepresentativeId, setDevRepresentativeId] = useState();
  const [devManagerId, setDevManagerId] = useState();
  const [initImmovables] = useState<ImmovableItems | object[]>([{}]);
  const [immovables, setImmovables] = useState<ImmovableItems>([]);

  // Form Memo Values
  const shouldLoad = useMemo(() => isLoading || !options, [options, isLoading]);

  const notaries = useMemo(() => options?.form_data.notary, [options]);

  const developers = useMemo(() => options?.form_data.developer, [options]);

  const manager = useMemo(() => developersInfo?.manager || [], [
    developersInfo,
  ]);

  const building = useMemo(() => developersInfo?.building || [], [
    developersInfo,
  ]);

  const representative = useMemo(() => developersInfo?.representative || [], [
    developersInfo,
  ]);

  const contracts = useMemo(() => options?.form_data.contract_type, [options]);

  const immovableTypes = useMemo(() => options?.form_data.immovable_type, [
    options,
  ]);

  // Form onChange functions
  const onNotaryChange = useCallback(
    (value) => {
      setNotary(value);
    },
    [notary]
  );

  const onDeveloperChange = useCallback(
    (value) => {
      setDevCompanyId(value);

      if (!value) {
        dispatch(setDevelopersInfo({}));
      }

      if (token) {
        fetchDeveloperInfo(dispatch, token, value);
      }
    },
    [token, devCompanyId]
  );

  const onRepresentativeChange = useCallback(
    (value) => {
      setDevRepresentativeId(value);
    },
    [devRepresentativeId]
  );

  const onManagerChange = useCallback(
    (value) => {
      setDevManagerId(value);
    },
    [devManagerId]
  );

  const onImmovablesChange = useCallback(
    (index: number, value: any) => {
      immovables[index] = { ...immovables[index], ...value };
      setImmovables([...immovables]);
    },
    [immovables]
  );

  console.log(immovables);

  return {
    shouldLoad,
    notaries,
    representative,
    developers,
    manager,
    building,
    initImmovables,
    contracts,
    immovableTypes,
    selectedNotaryId: notary,
    selectedDeveloperId: devCompanyId,
    selectedDevRepresentativeId: devRepresentativeId,
    selecedDevManagerId: devManagerId,
    onNotaryChange,
    onDeveloperChange,
    onRepresentativeChange,
    onManagerChange,
    onImmovablesChange,
  };
};
