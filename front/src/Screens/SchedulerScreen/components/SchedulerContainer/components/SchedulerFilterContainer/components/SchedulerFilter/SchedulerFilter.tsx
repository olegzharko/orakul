import * as React from 'react';
import Filter from '../../../../../../../../components/Filter';
import { useSchedulerFilter } from './useSchedulerFilter';

const SchedulerFilter = () => {
  const { onFilterDataChange } = useSchedulerFilter();

  return (
    <Filter onFilterDataChange={onFilterDataChange} horizontal />
  );
};

export default SchedulerFilter;
