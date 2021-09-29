import React from 'react';
import Pagination from '@material-ui/lab/Pagination';

type ArchivePaginationProps = {
  page: number;
  pagesCount: number;
  onChange: (_: any, page: number) => void;
}

const ArchivePagination = ({ page, pagesCount, onChange }: ArchivePaginationProps) => (
  <div className="vision-archive__pagination">
    <Pagination
      page={page}
      count={pagesCount}
      variant="outlined"
      shape="rounded"
      onChange={onChange}
    />
  </div>
);

export default ArchivePagination;
