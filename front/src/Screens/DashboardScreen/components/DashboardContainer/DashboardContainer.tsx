import React from 'react';
import Filter from './components/FilterContainer';
import { useRequestModal } from '../../../../components/RequestModal/useRequestModal';
import Modal from '../../../../components/RequestModal';
import Dashboard from '../../../../components/Dashboard';
import { useDashboardContainer } from './useDashboardContainer';
import ContentPanel from '../../../../components/ContentPanel';
import Loader from '../../../../components/Loader/Loader';

const DashboardContainer = () => {
  const modalProps = useRequestModal();
  const {
    formatAppointments,
    isLoading,
  } = useDashboardContainer();

  if (isLoading) {
    return <Loader />;
  }

  return (
    <div className="dashboard-screen">
      <Filter />
      <ContentPanel>
        <Dashboard
          isChangeTypeButton
          sections={formatAppointments}
        />
      </ContentPanel>
      <Modal {...modalProps} />
    </div>
  );
};

export default DashboardContainer;
