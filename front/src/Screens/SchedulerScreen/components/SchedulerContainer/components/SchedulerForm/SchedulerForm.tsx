/* eslint-disable jsx-a11y/click-events-have-key-events */
/* eslint-disable jsx-a11y/no-static-element-interactions */
import React from 'react';
import './index.scss';
import Modal from '../../../../../../components/Modal';
import Form from './components/Form';
import { useSchedulerForm } from './useSchedulerForm';

const SchedulerForm = () => {
  const meta = useSchedulerForm();

  return (
    <div className="schedulerForm scheduler__form">
      <div className="schedulerForm__tabs">
        <div
          className={`item ${meta.selectedTab === 0 ? 'selected' : ''}`}
          onClick={() => meta.setSelectedTab(0)}
        >
          {meta.newSelectedAppointment
            ? `${meta.newSelectedAppointment.day} ${meta.newSelectedAppointment.time} ${meta.newSelectedAppointment.date}`
            : ''}
        </div>

        {meta.oldSelectedAppointment && meta.editAppointmentData && (
          <div
            className={`item ${meta.selectedTab === 1 ? 'selected' : ''}`}
            onClick={() => meta.setSelectedTab(1)}
          >
            {`${meta.oldSelectedAppointment.day} ${meta.oldSelectedAppointment.time} ${meta.oldSelectedAppointment.date}`}
          </div>
        )}
      </div>

      {meta.selectedTab === 0 && (
        <Form selectedCard={meta.newSelectedAppointment} />
      )}

      {meta.selectedTab === 1 && meta.editAppointmentData && (
        <Form
          selectedCard={meta.oldSelectedAppointment}
          initialValues={meta.editAppointmentData}
          edit
        />
      )}

      <Modal {...meta.modalProps} />
    </div>
  );
};

export default SchedulerForm;
