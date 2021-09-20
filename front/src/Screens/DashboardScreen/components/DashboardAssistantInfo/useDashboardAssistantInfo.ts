import { useCallback, useEffect, useState } from 'react';
import { useSelector } from 'react-redux';
import { useHistory } from 'react-router';

import { FilterData, State } from '../../../../store/types';
import { loadClientCards, loadClientsCardsByContract } from './actions';

export const useDashboardAssistantInfo = () => {
  const history = useHistory();

  const { token } = useSelector((state: State) => state.main.user);

  const [clientCards, setClientCards] = useState<any>(null);
  const [contractsFiltersUrl, setContractsFiltersUrl] = useState<string>('api/filter/total/generator');
  const [filters, setFilters] = useState<FilterData>({
    accompanying_id: null,
    contract_type_id: null,
    dev_representative_id: null,
    developer_id: null,
    notary_id: null,
    reader_id: null,
    sort_type: null,
  });

  const onFiltersChange = useCallback((newFilters: FilterData) => {
    setFilters(newFilters);
  }, []);

  const onContractsFiltersChange = useCallback(async (url: string) => {
    if (token) {
      const res = await loadClientsCardsByContract(token, url, history);
      setClientCards(res);
    }
  }, [token]);

  useEffect(() => {
    (async () => {
      if (token) {
        const res = await loadClientCards(token, history);
        setClientCards(res);
      }
    })();
  }, [token]);

  return {
    clientCards,
    contractsFiltersUrl,
    filters,
    onFiltersChange,
    onContractsFiltersChange,
  };
};
