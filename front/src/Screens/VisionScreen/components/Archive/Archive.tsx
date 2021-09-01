import React, { useState } from 'react';

import './index.scss';
import ArchiveTabBar from './components/NotariesTabBar';
import ArchiveFilter from './components/ArchiveFilter/ArchiveFilter';
import ArchiveTable from './components/ArchiveTable';
import ArchivePagination from './components/ArchivePagination';

const notaries = ['Ракул Оксана Володимирівна', 'Петрова С.М.', 'Коберник О.М.'];

const Archive = () => {
  const [selectedTabIndex, setSelectedTabIndex] = useState<number>(0);
  const [page, setPage] = useState(1);

  return (
    <div className="vision-archive">
      <ArchiveTabBar
        tabs={notaries}
        selectedIndex={selectedTabIndex}
        onClick={setSelectedTabIndex}
      />
      <ArchiveFilter />
      <div className="vision-archive__table">
        <ArchiveTable />
        <ArchivePagination
          page={page}
          pagesCount={122}
          onChange={(_, e) => setPage(e)}
        />
      </div>
    </div>
  );
};

export default Archive;
