import React from 'react';
import Filter from '../../../../../../components/Filter';

import ArchiveFilterQuantity from './ArchiveFilterQuantity';
import ArchiveFilterPeriod from './ArchiveFilterPeriod';

const ArchiveFilter = () => (
  <div className="vision-archive__filter">
    <div className="vision-archive__filter-left">
      <ArchiveFilterQuantity quantity={3077} />

      <div className="filters">
        <span>Сортувати по:</span>
        <Filter onFilterDataChange={(e) => console.log(e)} horizontal />
      </div>
    </div>

    <ArchiveFilterPeriod />
  </div>
);

export default ArchiveFilter;
