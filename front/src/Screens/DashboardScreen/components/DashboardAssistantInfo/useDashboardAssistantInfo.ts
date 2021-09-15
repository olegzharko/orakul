import { useCallback, useState } from 'react';
import { FilterData } from '../../../../store/types';

export const useDashboardAssistantInfo = () => {
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

  const onContractsFiltersChange = useCallback((url: string) => {
    setContractsFiltersUrl(url);
  }, []);

  return {
    contractsFiltersUrl,
    filters,
    onFiltersChange,
    onContractsFiltersChange,
  };
};
