/* eslint-disable prettier/prettier */
/* eslint-disable arrow-body-style */
import { useMemo, useState, useCallback } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { State } from '../../../../../../../../store/types';
import fetchDeveloperInfo from '../../../../../../../../actions/fetchDeveloperInfo';
import { setDevelopersInfo } from '../../../../../../../../store/scheduler/actions';
import { clientItem, immovableItem } from './types';
import createNewCard from '../../../../../../../../actions/createNewCard';
import {
  ClientItem,
  ImmovableItem,
  ImmovableItems,
  NewCard
} from '../../../../../../../../types';

export const useForm = () => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.token);
  const { options, developersInfo, isLoading } = useSelector(
    (state: State) => state.scheduler
  );
  const newSelectedAppointment = useSelector(
    (state: State) => state.scheduler.newSelectedAppointment
  );

  // Form State
  const [notary, setNotary] = useState<number>();
  const [devCompanyId, setDevCompanyId] = useState();
  const [devRepresentativeId, setDevRepresentativeId] = useState();
  const [devManagerId, setDevManagerId] = useState();
  const [immovables, setImmovables] = useState<ImmovableItems>([immovableItem]);
  const [clients, setClients] = useState<ClientItem[]>([clientItem]);

  // Form Memo Values
  const shouldLoad = useMemo(() => isLoading || !options, [options, isLoading]);

  const notaries = useMemo(() => options?.form_data.notary, [options]);

  const developers = useMemo(() => options?.form_data.developer, [options]);

  const manager = useMemo(() => developersInfo?.manager || [], [
    developersInfo,
  ]);

  const representative = useMemo(() => developersInfo?.representative || [], [
    developersInfo,
  ]);

  // Form onChange functions
  const onNotaryChange = useCallback((value) => {
    setNotary(value);
  }, []);

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
      immovables[index] = value;
      setImmovables([...immovables]);
    },
    [immovables]
  );

  const onClientsChange = useCallback(
    (index: number, value: ClientItem) => {
      clients[index] = value;
      setClients([...clients]);
    },
    [clients]
  );

  // Form CTA

  const onClearAll = useCallback(() => {
    setNotary(undefined);
    setDevCompanyId(undefined);
    setDevRepresentativeId(undefined);
    setDevManagerId(undefined);
    setImmovables([immovableItem]);
    setClients([clientItem]);
  }, []);

  const onAddImmovables = useCallback(() => {
    setImmovables([...immovables, immovableItem]);
  }, [immovables]);

  const onAddClients = useCallback(() => {
    setClients([...clients, clientItem]);
  }, [clients]);

  const onFormCreate = useCallback(() => {
    const date = newSelectedAppointment.date.split('.').reverse().join('.');
    const date_time = `${newSelectedAppointment.year}.${date} ${newSelectedAppointment.time}`;

    const formatImmovables = immovables.map((item: ImmovableItem) => ({
      ...item,
      contract_type_id: item.contract_type_id || options.form_data.immovable_type[0].id,
      imm_type_id: item.imm_type_id || options.form_data.immovable_type[0].id,
    }));

    const data: NewCard = {
      immovables: formatImmovables,
      clients,
      date_time,
      dev_company_id: devCompanyId,
      dev_representative_id: devRepresentativeId,
      dev_manager_id: devManagerId,
      room_id: newSelectedAppointment.room,
      notary_id: notary,
    };

    if (token) {
      createNewCard(dispatch, token, data);
    }
  }, [
    devCompanyId,
    devRepresentativeId,
    devManagerId,
    newSelectedAppointment,
    notary,
    immovables,
    clients
  ]);

  return {
    shouldLoad,
    notaries,
    representative,
    developers,
    manager,
    selectedNotaryId: notary,
    selectedDeveloperId: devCompanyId,
    selectedDevRepresentativeId: devRepresentativeId,
    selecedDevManagerId: devManagerId,
    immovables,
    clients,
    onNotaryChange,
    onDeveloperChange,
    onRepresentativeChange,
    onManagerChange,
    onImmovablesChange,
    onAddImmovables,
    onClientsChange,
    onAddClients,
    onClearAll,
    onFormCreate,
  };
};