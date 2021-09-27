import React from 'react';

import CheckList from '../../../../components/CheckList';
import Loader from '../../../../components/Loader/Loader';

import { useDashboardChecklist } from './useDashboardChecklist';

const DashboardChecklist = () => {
  const {
    isLoading,
    formattedCheckList,
    onCancel,
    onSave,
  } = useDashboardChecklist();

  if (isLoading) return <Loader />;

  return (
    <CheckList
      onSave={onSave}
      onCancel={onCancel}
      checkList={formattedCheckList}
    />
  );
};

export default DashboardChecklist;
