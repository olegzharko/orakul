import React from 'react';
import './index.scss';

// Components
import SchedulerTable from './components/Table/SchedulerTable';
import SchedulerFilter from './components/SchedulerFilter';
import SchedulerForm from './components/SchedulerForm';
import { useModal } from '../../../../components/Modal/useModal';
import Modal from '../../../../components/Modal';

const SchedulerContainer = () => {
  const modalProps = useModal();

  return (
    <div className="scheduler__container">
      <div className="scheduler__dataView">
        <SchedulerFilter />
        <SchedulerTable />
      </div>
      <SchedulerForm />
      <Modal {...modalProps} />
    </div>
  );
};

export default SchedulerContainer;
