import React from 'react';
import Filter from './components/FilterContainer';
import { useModal } from '../../../../components/Modal/useModal';
import Modal from '../../../../components/Modal';
import Dashboard from '../../../../components/Dashboard';
import { useDashboardContainer } from './useDashboardContainer';
import ContentPanel from '../../../../components/ContentPanel';
import Loader from '../../../../components/Loader/Loader';

const DashboardContainer = () => {
  const modalProps = useModal();
  const { formatAppointments, isLoading } = useDashboardContainer();

  if (isLoading) {
    return <Loader />;
  }

  return (
    <div className="dashboard-screen">
      <Filter />
      <ContentPanel>
        <Dashboard
          link="main"
          sections={formatAppointments}
          isChangeTypeButton
        />
      </ContentPanel>
      <Modal {...modalProps} />
    </div>
  );
};

export default DashboardContainer;
