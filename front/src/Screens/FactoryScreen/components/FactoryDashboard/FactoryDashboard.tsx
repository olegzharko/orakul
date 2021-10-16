import React from 'react';

import Loader from '../../../../components/Loader/Loader';

import './index.scss';
import DashboardAssistantInfoHeader from './components/DashboardAssistantInfoHeader';
import DashboardAssistantInfoNavigation from './components/DashboardAssistantInfoNavigation';
import DashboardFilter from './components/DashboardFilter';
import { useFactoryDashboard } from './useFactoryDashboard';
import Dashboard from '../../../../components/Dashboard';

const FactoryDashboard = () => {
  const {
    isLoading,
    cards,
    isNavigationShow,
    navigationValues,
    onFiltersChange,
    onContractsFiltersChange,
  } = useFactoryDashboard();

  if (isLoading) return <Loader />;

  return (
    <div className="dashboard-assistant-info df">
      <DashboardFilter
        onFiltersChange={onFiltersChange}
        onContractsFiltersChange={onContractsFiltersChange}
      />

      <div className="dashboard-assistant-info__dashboard">
        <DashboardAssistantInfoHeader />

        {isNavigationShow && (
          <DashboardAssistantInfoNavigation
            navigationValues={navigationValues}
          />
        )}

        <Dashboard
          isChangeTypeButton
          sections={cards}
        />
      </div>
    </div>
  );
};

export default FactoryDashboard;
