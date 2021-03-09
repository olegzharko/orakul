import React from 'react';
import Modal from '../../../../../../components/Modal';
import Form from './components/Form';
import { useSchedulerForm } from './useSchedulerForm';

const SchedulerForm = () => {
  const meta = useSchedulerForm();

  return (
    <div className="scheduler__form">
      <Form />
      <Modal {...meta.modalProps} />
    </div>
  );
};

export default SchedulerForm;
