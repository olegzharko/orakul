import React, { useState } from 'react';

import Loader from '../../../../components/Loader/Loader';
import {
  ArchiveFilterPeriod,
  ArchiveFilterSelects,
  ArchiveFilterQuantity,
} from './components/ArchiveFilter';

import { useArchive } from './useArchive';
import './index.scss';
import ArchiveTabBar from './components/NotariesTabBar';
import ArchiveTable from './components/ArchiveTable';
import ArchivePagination from './components/ArchivePagination';

const Archive = () => {
  const {
    isLoading,
    formattedNotaries,
    selectedNotary,
    tableHeader,
    formattedTableRawsData,
    filterSelectsData,
    totalRaws,
    selectedPage,
    totalPages,
    period,
    onFilterChange,
    onPageChange,
    onPeriodChange,
  } = useArchive();

  if (isLoading) return <Loader />;

  return (
    <div className="vision-archive">
      <ArchiveTabBar
        notaries={formattedNotaries}
        selectedNotary={selectedNotary}
      />

      <div className="vision-archive__filter">
        <div className="vision-archive__filter-left">
          <ArchiveFilterQuantity quantity={totalRaws} />

          <ArchiveFilterSelects
            filterData={filterSelectsData}
            onChange={onFilterChange}
          />
        </div>

        <ArchiveFilterPeriod
          period={period}
          onChange={onPeriodChange}
        />
      </div>

      <div className="vision-archive__table">
        <ArchiveTable
          headers={tableHeader}
          raws={formattedTableRawsData}
        />
        <ArchivePagination
          page={selectedPage}
          pagesCount={totalPages}
          onChange={onPageChange}
        />
      </div>
    </div>
  );
};

export default Archive;
