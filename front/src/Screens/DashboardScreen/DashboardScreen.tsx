import React from 'react';
import { Switch, Route } from 'react-router-dom';

import Header from '../../components/Header';

import './index.scss';
import ManageContainer from './components/ManageContainer';
import DashboardAssistantInfo from './components/DashboardAssistantInfo';
import { MANAGE_CONTAINER_LINK_PREFIX } from './constants';
import ContractsDashboard from './components/ContractsDashboard/ContractsDashboard';
import DashboardChecklist from './components/DashboardChecklist';

const DashboardScreen = () => (
  <div className="dashboard-screen">
    <Header />
    <Switch>
      <Route path="/:process/:cardId" exact>
        <ContractsDashboard />
      </Route>

      <Route path="/:process/:cardId/checklist/:contractId" exact>
        <div className="flex-center dashboard-screen__check-list">
          <DashboardChecklist />
        </div>
      </Route>

      <Route path={`${MANAGE_CONTAINER_LINK_PREFIX}/:section/:id`}>
        <ManageContainer />
      </Route>

      <DashboardAssistantInfo />
    </Switch>
  </div>
);

export default DashboardScreen;
