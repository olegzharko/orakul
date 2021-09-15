import React from 'react';
import { Switch, Route } from 'react-router-dom';

import { DashboardAssistantInfoNavigationLinks } from '../../enums';

import './index.scss';
import DashboardAssistantInfoHeader from './components/DashboardAssistantInfoHeader';
import DashboardAssistantInfoNavigation from './components/DashboardAssistantInfoNavigation';
import DashboardAssistantInfoSetPage from './components/DashboardAssistantInfoSetPage';
import DashboardAssistantInfoOtherActionsPage from './components/DashboardAssistantInfoOtherActionsPage';
import DashboardAssistantInfoReadingPage from './components/DashboardAssistantInfoReadingPage';
import DashboardAssistantInfoIssuancePage from './components/DashboardAssistantInfoIssuancePage';
import DashboardFilter from './components/DashboardFilter';
import { useDashboardAssistantInfo } from './useDashboardAssistantInfo';

const assistantInfoRoutes = {
  set: `${DashboardAssistantInfoNavigationLinks.set}`,
  otherActions: `${DashboardAssistantInfoNavigationLinks.otherActions}`,
  reading: `${DashboardAssistantInfoNavigationLinks.reading}`,
  issuance: `${DashboardAssistantInfoNavigationLinks.issuance}`
};

const DashboardAssistantInfo = () => {
  const {
    onFiltersChange,
    onContractsFiltersChange,
  } = useDashboardAssistantInfo();

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
            <DashboardAssistantInfoSetPage />
          </Route>

          <Route path={assistantInfoRoutes.reading}>
            <DashboardAssistantInfoReadingPage />
          </Route>

          <Route path={assistantInfoRoutes.issuance}>
            <DashboardAssistantInfoIssuancePage />
          </Route>

          <Route path={assistantInfoRoutes.otherActions} exact>
            <DashboardAssistantInfoOtherActionsPage />
          </Route>
        </Switch>
      </div>
    </div>
  );
};

export default DashboardAssistantInfo;
