import React from 'react';
import Filter from './components/FilterContainer';
import { useModal } from '../../../../components/Modal/useModal';
import Modal from '../../../../components/Modal';
import Dashboard from '../../../../components/Dashboard';
import { useDashboardContainer } from './useDashboardContainer';

const DashboardContainer = () => {
  const modalProps = useModal();
  const { formatAppointments } = useDashboardContainer();

  return (
    <div className="dashboard">
      <Filter />
      <Dashboard
        link="contracts"
        sections={formatAppointments}
        isChangeTypeButton
      />
      <Modal {...modalProps} />
    </div>
  );
};

export default DashboardContainer;
