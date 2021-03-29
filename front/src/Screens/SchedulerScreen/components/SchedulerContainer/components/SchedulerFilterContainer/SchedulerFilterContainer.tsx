import React from 'react';
import Filter from '../../../../../../components/Filter';
import QuantityLabel from './components/QuantityLabel';
import SchedulerFilter from './components/SchedulerFilter';
import SchedulerLock from './components/SchedulerLock';
import './index.scss';

const SchedulerFilterContainer = () => (
  <div className="scheduler__filter">
    <QuantityLabel />
    <SchedulerFilter />
    <SchedulerLock />
  </div>
);

export default SchedulerFilterContainer;
