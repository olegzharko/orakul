import React from 'react';
import { Switch, Route } from 'react-router-dom';

import { DashboardAssistantInfoNavigationLinks } from '../../enums';
import Loader from '../../../../components/Loader/Loader';

import './index.scss';
import DashboardAssistantInfoHeader from './components/DashboardAssistantInfoHeader';
import DashboardAssistantInfoNavigation from './components/DashboardAssistantInfoNavigation';
import DashboardAssistantInfoOtherActionsPage from './components/DashboardAssistantInfoOtherActionsPage';
import DashboardFilter from './components/DashboardFilter';
import { useDashboardAssistantInfo } from './useDashboardAssistantInfo';
import Dashboard from '../../../../components/Dashboard';

const assistantInfoRoutes = {
  set: `${DashboardAssistantInfoNavigationLinks.set}`,
  otherActions: `${DashboardAssistantInfoNavigationLinks.otherActions}`,
  reading: `${DashboardAssistantInfoNavigationLinks.reading}`,
  issuance: `${DashboardAssistantInfoNavigationLinks.issuance}`
};

const DashboardAssistantInfo = () => {
  const {
    isLoading,
    accompanying,
    reader,
    generator,
    onFiltersChange,
    onContractsFiltersChange,
  } = useDashboardAssistantInfo();

  if (isLoading) return <Loader />;

  return (
    <div className="dashboard-assistant-info df">
      <Route
        path={[
          assistantInfoRoutes.set,
          assistantInfoRoutes.reading,
          assistantInfoRoutes.issuance
        ]}
        exact
      >
        <DashboardFilter
          onFiltersChange={onFiltersChange}
          onContractsFiltersChange={onContractsFiltersChange}
        />
      </Route>

      <div className="dashboard-assistant-info__dashboard">
        <DashboardAssistantInfoHeader />
        <DashboardAssistantInfoNavigation />

        <Switch>
          <Route path={assistantInfoRoutes.set} exact>
            <Dashboard
              sections={accompanying}
            />
          </Route>

          <Route path={assistantInfoRoutes.reading}>
            <Dashboard
              sections={reader}
            />
          </Route>

          <Route path={assistantInfoRoutes.issuance}>
            <Dashboard
              sections={generator}
            />
          </Route>

          {/* <Route path={assistantInfoRoutes.otherActions} exact>
            <DashboardAssistantInfoOtherActionsPage />
          </Route> */}
        </Switch>
      </div>
    </div>
  );
};

export default DashboardAssistantInfo;
