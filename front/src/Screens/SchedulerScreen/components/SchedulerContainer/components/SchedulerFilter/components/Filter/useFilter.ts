import {
  useEffect, useMemo, useState, useCallback
} from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { State } from '../../../../../../../../store/types';
import { SelectItem } from '../../../../../../../../types';
import { fetchSchedulerFilter } from '../../../../../../../../store/scheduler/actions';
import { fetchAppointmentsByFilter } from '../../../../../../../../store/appointments/actions';
import getDeveloperInfo from '../../../../../../../../services/getDeveloperInfo';

export const useFilter = () => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);
  const { filterInitialData } = useSelector((state: State) => state.scheduler);

  useEffect(() => {
    dispatch(fetchSchedulerFilter());
  }, [token]);

  const readers = useMemo(() => filterInitialData?.reader, [filterInitialData]);
  const notaries = useMemo(() => filterInitialData?.notary, [
    filterInitialData,
  ]);
  const accompanyings = useMemo(() => filterInitialData?.accompanying, [
    filterInitialData,
  ]);
  const contractTypes = useMemo(() => filterInitialData?.contract_type, [
    filterInitialData,
  ]);
  const developers = useMemo(() => filterInitialData?.developer, [
    filterInitialData,
  ]);
  const [representative, setRepresentative] = useState<SelectItem[]>([]);

  const shouldRenderFilter = useMemo(() => Boolean(filterInitialData), [
    filterInitialData,
  ]);

  // selected values and CTA
  const [selectedNotary, setSelectedNotary] = useState<string | null>(null);
  const [selectedReader, setSelectedReader] = useState<string | null>(null);
  const [selectedAccompanying, setSelectedAccompanying] = useState<
    string | null
  >(null);
  const [selectedContractType, setSelectedContractType] = useState<
    string | null
  >(null);
  const [selectedDeveloper, setSelectedDeveloper] = useState<string | null>(
    null
  );
  const [selectedRepresentative, setSelectedRepresentative] = useState<
    string | null
  >(null);

  const clearAll = useCallback(() => {
    setSelectedNotary(null);
    setSelectedReader(null);
    setSelectedAccompanying(null);
    setSelectedContractType(null);
    setSelectedDeveloper(null);
    setSelectedRepresentative(null);
  }, []);

  // useEffects
  useEffect(() => {
    setSelectedRepresentative(null);
    if (token && selectedDeveloper) {
      getDeveloperInfo(token, +selectedDeveloper)
        .then((data) => setRepresentative(data.representative || []));
    }
  }, [selectedDeveloper]);

  useEffect(() => {
    const data = {
      notary_id: selectedNotary,
      reader_id: selectedReader,
      giver_id: selectedAccompanying,
      contract_type_id: selectedContractType,
      developer_id: selectedDeveloper,
      dev_assistant_id: selectedRepresentative,
    };

    dispatch(fetchAppointmentsByFilter(data));
  }, [
    selectedNotary,
    selectedReader,
    selectedAccompanying,
    selectedContractType,
    selectedDeveloper,
    selectedRepresentative,
  ]);

  return {
    shouldRenderFilter,
    notaries,
    readers,
    accompanyings,
    contractTypes,
    developers,
    representative,
    selectedNotary,
    selectedReader,
    selectedRepresentative,
    selectedDeveloper,
    selectedContractType,
    selectedAccompanying,
    setSelectedNotary,
    setSelectedReader,
    setSelectedAccompanying,
    setSelectedContractType,
    setSelectedDeveloper,
    setSelectedRepresentative,
    clearAll,
  };
};
