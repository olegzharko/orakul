import React from 'react';
import ControlPanel from '../../../../../../components/ControlPanel';
import Filter from '../../../../../../components/Filter';
import Contracts from './components/Contracts';
import { useDashboardFilter, DashboardFilterProps } from './useDashboardFilter';

const DashboardFilter = ({
  onFiltersChange,
  onContractsFiltersChange
}: DashboardFilterProps) => {
  const {
    filterInitialData,
  } = useDashboardFilter();

  return (
    <ControlPanel>
      <div className="dashboard__filter">
        <Contracts data={filterInitialData?.filter_type} onChange={onContractsFiltersChange} />
        <Filter onFilterDataChange={onFiltersChange} />
      </div>
    </ControlPanel>
  );
};

export default DashboardFilter;
