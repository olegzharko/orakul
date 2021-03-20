import React from 'react';
import './index.scss';
import Dashboard from './components/Dashboard';
import Filter from './components/Filter';

const DashboardContainer = () => (
  <div className="dashboard">
    <Filter />
    <Dashboard />
  </div>
);

export default DashboardContainer;
