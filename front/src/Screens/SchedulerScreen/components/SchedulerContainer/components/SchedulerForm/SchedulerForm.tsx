import React from 'react';
import Form from './components/Form';
import { useSchedulerForm } from './useSchedulerForm';

const SchedulerForm = () => {
  const meta = useSchedulerForm();

  if (!meta.newSelectedAppointment) {
    return null;
  }

  return (
    <div className="scheduler__form">
      <Form />
    </div>
  );
};

export default SchedulerForm;
