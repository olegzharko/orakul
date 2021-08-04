import React from 'react';
import './index.scss';

// Components
import SchedulerTable from './components/Table/SchedulerTable';
import SchedulerFilter from './components/SchedulerFilterContainer';
import SchedulerForm from './components/SchedulerForm';
import { useRequestModal } from '../../../../components/RequestModal/useRequestModal';
import Modal from '../../../../components/RequestModal';

const SchedulerContainer = () => {
  const modalProps = useRequestModal();

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
