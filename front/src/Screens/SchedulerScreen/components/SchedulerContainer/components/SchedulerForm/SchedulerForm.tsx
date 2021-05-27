import React from 'react';
import './index.scss';
import Form from './components/Form';
import { useSchedulerForm } from './useSchedulerForm';

const SchedulerForm = () => {
  const meta = useSchedulerForm();

  return (
    <div className="schedulerForm scheduler__form">
      <div className="schedulerForm__tabs">
        <div
          className={`item ${meta.selectedTab === 0 ? 'selected' : ''}`}
          style={{ backgroundColor: !meta.editAppointmentData ? 'white' : '' }}
          onClick={() => meta.setSelectedTab(0)}
        >
          {meta.newSelectedAppointment
            ? `${meta.newSelectedAppointment.day} ${meta.newSelectedAppointment.time} ${meta.newSelectedAppointment.date.split('.').reverse().join('.')}`
            : 'Виберіть дату'}
        </div>

        {meta.oldSelectedAppointment && meta.editAppointmentData && (
          <div
            className={`item ${meta.selectedTab === 1 ? 'selected' : ''}`}
            onClick={() => meta.setSelectedTab(1)}
          >
            {`${meta.oldSelectedAppointment.day} ${meta.oldSelectedAppointment.time} ${meta.oldSelectedAppointment.date.split('.').reverse().join('.')}`}
            <img
              src="/icons/x.svg"
              alt="close"
              className="clear-icon"
              onClick={meta.onCloseTab}
            />
          </div>
        )}
      </div>

      {meta.selectedTab === 0 && (
        <Form selectedCard={meta.newSelectedAppointment} />
      )}

      {meta.selectedTab === 1 && meta.editAppointmentData && meta.oldSelectedAppointment && (
        <Form
          selectedCard={meta.oldSelectedAppointment}
          initialValues={meta.editAppointmentData}
          edit
        />
      )}
    </div>
  );
};

export default SchedulerForm;
