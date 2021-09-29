import { useSelector } from 'react-redux';
import { FilterData, State } from '../../../../../../store/types';

export type DashboardFilterProps = {
  onFiltersChange: (newFilters: FilterData) => void;
  onContractsFiltersChange: (url: string) => void;
}

export const useDashboardFilter = () => {
  const { filterInitialData } = useSelector((state: State) => state.filter);

  return {
    filterInitialData,
  };
};
