import React from 'react';
import './index.scss';

// Components
import SchedulerTable from './components/Table/SchedulerTable';
import SchedulerFilter from './components/Filter';
import SchedulerForm from './components/Form';

const SchedulerContainer = () => (
  <div className="scheduler__container">
    <div className="scheduler__dataView">
      <SchedulerFilter />
      <SchedulerTable />
    </div>
    <div className="scheduler__form">
      <SchedulerForm />
    </div>
  </div>
);

export default SchedulerContainer;
