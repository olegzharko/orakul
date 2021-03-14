import React from 'react';
import './index.scss';

// Components
import SchedulerTable from './components/Table/SchedulerTable';
import SchedulerFilter from './components/SchedulerFilter';
import SchedulerForm from './components/SchedulerForm';

const SchedulerContainer = () => (
  <div className="scheduler__container">
    <div className="scheduler__dataView">
      <SchedulerFilter />
      <SchedulerTable />
    </div>
    <SchedulerForm />
  </div>
);

export default SchedulerContainer;
