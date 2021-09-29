import { useCallback, useState, useEffect } from 'react';
import { useSelector } from 'react-redux';
import getDeveloperInfo from '../../../../../../../services/getDeveloperInfo';
import getFilterData from '../../../../../../../services/getFilterData';

import { State } from '../../../../../../../store/types';
import { ArchiveSelectsFilterData } from '../../../types';

export type ArchiveFilterSelectsProps = {
  filterData: ArchiveSelectsFilterData;
  onChange: (newFilters: ArchiveSelectsFilterData) => void;
}

export const useArchiveFilterSelects = ({
  filterData,
  onChange,
}: ArchiveFilterSelectsProps) => {
  const { token, type } = useSelector((state: State) => state.main.user);

  // State
  const [contractTypes, setContractTypes] = useState([]);
  const [devCompanies, setDevCompanies] = useState([]);
  const [devRepresentatives, setDevRepresentatives] = useState([]);

  // Callbacks
  const onContractTypeChange = useCallback((id: string) => {
    onChange({ ...filterData, contract_type_id: id });
  }, [filterData, onChange]);

  const onDevCompanyChange = useCallback(async (id: string) => {
    onChange({ ...filterData, dev_group_id: id });

    if (!token) return;

    const res = await getDeveloperInfo(token, id);
    setDevRepresentatives(res?.representative || []);
  }, [filterData, onChange, token]);

  const onDevRepresentativeChange = useCallback((id: string) => {
    onChange({ ...filterData, dev_representative_id: id });
  }, [filterData, onChange]);

  // Effects
  useEffect(() => {
    (async () => {
      if (!token || !type) return;

      const res = await getFilterData(token, type);
      setContractTypes(res?.contract_type || []);
      setDevCompanies(res?.developer || []);
    })();
  }, [token, type]);

  return {
    filterData,
    contractTypes,
    devCompanies,
    devRepresentatives,
    onContractTypeChange,
    onDevCompanyChange,
    onDevRepresentativeChange,
  };
};
