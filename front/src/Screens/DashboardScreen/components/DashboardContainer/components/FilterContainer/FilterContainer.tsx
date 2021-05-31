import React from 'react';
import ControlPanel from '../../../../../../components/ControlPanel';
import Filter from '../../../../../../components/Filter';
import Contracts from './components/Contracts';
import { useFilterContainer } from './useFilterContainer';

const FilterContainer = () => {
  const {
    filterInitialData,
    onFilterDataChange,
    onContractsFilterChange
  } = useFilterContainer();

  return (
    <ControlPanel>
      <div className="dashboard__filter">
        <Contracts data={filterInitialData?.filter_type} onChange={onContractsFilterChange} />
        <Filter onFilterDataChange={onFilterDataChange} />
      </div>
    </ControlPanel>
  );
};

export default FilterContainer;
