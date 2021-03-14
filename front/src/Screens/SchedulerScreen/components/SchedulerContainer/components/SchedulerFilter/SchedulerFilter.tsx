import React from 'react';
import Filter from './components/Filter';
import QuantityLabel from './components/QuantityLabel';
import './index.scss';

const SchedulerFilter = () => (
  <div className="scheduler__filter">
    <QuantityLabel />
    <Filter />
  </div>
);

export default SchedulerFilter;
