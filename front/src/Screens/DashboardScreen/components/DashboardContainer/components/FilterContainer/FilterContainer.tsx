import React from 'react';
import Filter from '../../../../../../components/Filter';
import PrimaryButton from '../../../../../../components/PrimaryButton';
import Contracts from './components/Contracts';
import './index.scss';
import { useFilterContainer } from './useFilterContainer';

const FilterContainer = () => {
  const { onFilterDataChange, onFilterSubmit } = useFilterContainer();

  return (
    <div className="dashboard__filter">
      <Contracts />
      <div className="dashboard__filter-container">
        <Filter onFilterDataChange={onFilterDataChange} />
        <div className="mv12">
          <PrimaryButton
            label="Застосувати"
            onClick={onFilterSubmit}
            disabled={false}
          />
        </div>
      </div>
    </div>
  );
};

export default FilterContainer;
