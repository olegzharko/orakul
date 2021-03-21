import React from 'react';
import './index.scss';
import Dashboard from './components/Dashboard';
import Filter from './components/Filter';
import { useModal } from '../../../../components/Modal/useModal';
import Modal from '../../../../components/Modal';

const DashboardContainer = () => {
  const modalProps = useModal();

  return (
    <div className="dashboard">
      <Filter />
      <Dashboard />
      <Modal {...modalProps} />
    </div>
  );
};

export default DashboardContainer;
