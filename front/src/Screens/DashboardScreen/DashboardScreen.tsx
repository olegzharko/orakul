import React from 'react';
import { Switch, Route } from 'react-router-dom';

import Header from '../../components/Header';
import CheckList from '../../components/CheckList';

import './index.scss';
import ManageContainer from './components/ManageContainer';
import DashboardAssistantInfo from './components/DashboardAssistantInfo';
import { MANAGE_CONTAINER_LINK_PREFIX } from './constants';

const DashboardScreen = () => (
  <div className="dashboard-screen">
    <Header />
    <Switch>
      <Route path="/:process/:cardId/check-list" exact>
        <div className="flex-center dashboard-screen__check-list">
          <CheckList />
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
