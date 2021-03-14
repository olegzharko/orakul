import React from 'react';
import Filter from './components/Filter';
import QuantityLabel from './components/QuantityLabel';
import SchedulerLock from './components/SchedulerLock';
import './index.scss';

const SchedulerFilter = () => (
  <div className="scheduler__filter">
    <QuantityLabel />
    <Filter />
    <SchedulerLock />
  </div>
);

export default SchedulerFilter;
