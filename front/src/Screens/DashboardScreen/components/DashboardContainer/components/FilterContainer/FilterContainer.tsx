import React from 'react';
import ControlPanel from '../../../../../../components/ControlPanel';
import Filter from '../../../../../../components/Filter';
import PrimaryButton from '../../../../../../components/PrimaryButton';
import Contracts from './components/Contracts';
import { useFilterContainer } from './useFilterContainer';

const FilterContainer = () => {
  const { onFilterDataChange, onFilterSubmit } = useFilterContainer();

  return (
    <ControlPanel>
      <div className="dashboard__filter">
        <Contracts />
        <Filter onFilterDataChange={onFilterDataChange} />
        <div className="mv12">
          <PrimaryButton
            label="Застосувати"
            onClick={onFilterSubmit}
            disabled={false}
          />
        </div>
      </div>
    </ControlPanel>
  );
};

export default FilterContainer;
