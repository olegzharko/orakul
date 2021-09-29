import React from 'react';

import Loader from '../../../../components/Loader/Loader';

import './index.scss';
import DashboardAssistantInfoHeader from './components/DashboardAssistantInfoHeader';
import DashboardAssistantInfoNavigation from './components/DashboardAssistantInfoNavigation';
import DashboardFilter from './components/DashboardFilter';
import { useDashboardAssistantInfo } from './useDashboardAssistantInfo';
import Dashboard from '../../../../components/Dashboard';

const DashboardAssistantInfo = () => {
  const {
    isLoading,
    cards,
    isNavigationShow,
    navigationValues,
    onFiltersChange,
    onContractsFiltersChange,
  } = useDashboardAssistantInfo();

  if (isLoading) return <Loader />;

  return (
    <div className="dashboard-assistant-info df">
      {/* <Route
        path={[
          assistantInfoRoutes.set,
          assistantInfoRoutes.reading,
          assistantInfoRoutes.accompanying
        ]}
        exact
      >
        <DashboardFilter
          onFiltersChange={onFiltersChange}
          onContractsFiltersChange={onContractsFiltersChange}
        />
      </Route> */}

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

        {/* <Switch>
          <Route path={assistantInfoRoutes.otherActions} exact>
            <DashboardAssistantInfoOtherActionsPage />
          </Route>
        </Switch> */}
      </div>
    </div>
  );
};

export default DashboardAssistantInfo;
