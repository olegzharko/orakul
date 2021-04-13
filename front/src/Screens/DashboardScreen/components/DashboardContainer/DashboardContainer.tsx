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
  const { formatAppointments } = useDashboardContainer();

  return (
    <div className="dashboard-screen">
      <Filter />
      <ContentPanel>
        {!formatAppointments.length ? <Loader /> : (
          <Dashboard
            link="main"
            sections={formatAppointments}
            isChangeTypeButton
          />
        )}
      </ContentPanel>
      <Modal {...modalProps} />
    </div>
  );
};

export default DashboardContainer;
