import {
  useEffect, useMemo, useState, useCallback
} from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { FilterData, State } from '../../store/types';
import { SelectItem } from '../../types';
import { fetchFilterData } from '../../store/filter/actions';
import getDeveloperInfo from '../../services/getDeveloperInfo';

export type Props = {
  onFilterDataChange: (data: FilterData) => void;
  horizontal?: boolean;
}

export const useFilter = ({ onFilterDataChange, horizontal }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);
  const { filterInitialData } = useSelector((state: State) => state.filter);

  useEffect(() => {
    dispatch(fetchFilterData());
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
  const sortType = useMemo(() => filterInitialData?.sort_type, [
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
  const [selectedSortType, setSelectedSortType] = useState<string | null>(null);

  const clearAll = useCallback(() => {
    setSelectedNotary(null);
    setSelectedReader(null);
    setSelectedAccompanying(null);
    setSelectedContractType(null);
    setSelectedDeveloper(null);
    setSelectedRepresentative(null);
    setSelectedSortType(null);
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
    const data: FilterData = {
      notary_id: selectedNotary || null,
      reader_id: selectedReader || null,
      giver_id: selectedAccompanying || null,
      contract_type_id: selectedContractType || null,
      developer_id: selectedDeveloper || null,
      dev_assistant_id: selectedRepresentative || null,
    };

    if (!horizontal) {
      data.sort_type = selectedSortType;
    }

    onFilterDataChange(data);
  }, [
    selectedNotary,
    selectedReader,
    selectedAccompanying,
    selectedContractType,
    selectedDeveloper,
    selectedRepresentative,
    selectedSortType,
  ]);

  return {
    shouldRenderFilter,
    notaries,
    readers,
    accompanyings,
    contractTypes,
    developers,
    representative,
    sortType,
    selectedNotary,
    selectedReader,
    selectedRepresentative,
    selectedDeveloper,
    selectedContractType,
    selectedAccompanying,
    selectedSortType,
    setSelectedNotary,
    setSelectedReader,
    setSelectedAccompanying,
    setSelectedContractType,
    setSelectedDeveloper,
    setSelectedRepresentative,
    setSelectedSortType,
    clearAll,
  };
};
