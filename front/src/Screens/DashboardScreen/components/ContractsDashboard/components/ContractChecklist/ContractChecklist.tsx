import React from 'react';

import CheckList from '../../../../../../components/CheckList';
import Loader from '../../../../../../components/Loader/Loader';

import { useContractChecklist } from './useContractChecklist';

const ContractChecklist = () => {
  const {
    isLoading,
    formattedCheckList,
    onCancel,
    onSave,
  } = useContractChecklist();

  if (isLoading) return <Loader />;

  return (
    <div className="flex-center dashboard-screen__check-list">
      <CheckList
        onSave={onSave}
        onCancel={onCancel}
        checkList={formattedCheckList}
      />
    </div>
  );
};

export default ContractChecklist;
