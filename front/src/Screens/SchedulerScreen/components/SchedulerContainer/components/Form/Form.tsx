import React from 'react';
import RadioButtonsGroup from '../../../../../../components/RadioButtonsGroup';
import './index.scss';

const buttons = [
  {
    notary_id: 0,
    title: 'ОВ',
  },
  {
    notary_id: 1,
    title: 'СМ',
  },
  {
    notary_id: 2,
    title: 'ОМ',
  },
];

const SchedulerForm = () => (
  <div className="scheduler__form schedulerForm">
    <div className="schedulerForm__tabs" />
    <div className="schedulerForm__forms">
      <div className="schedulerForm__header">
        <p className="title">Новий запис</p>
        <img src="/icons/clear.svg" alt="clear icon" className="clear-icon" />
      </div>
      <div className="mv12">
        <RadioButtonsGroup
          buttons={buttons}
          onChange={(id) => console.log(id)}
        />
      </div>
    </div>
  </div>
);

export default SchedulerForm;
