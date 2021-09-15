import React from 'react';
import { Switch, Route } from 'react-router-dom';

import Header from '../../components/Header';

import './index.scss';
import ManageContainer from './components/ManageContainer';
import DashboardAssistantInfo from './components/DashboardAssistantInfo';
import { MANAGE_CONTAINER_LINK_PREFIX } from './constants';

// import DashboardContainer from './components/DashboardContainer';

const DashboardScreen = () => (
  <>
    <Header />
    <Switch>
      <Route path={`${MANAGE_CONTAINER_LINK_PREFIX}/:section/:id`}>
        <ManageContainer />
      </Route>
      <DashboardAssistantInfo />
      {/* <DashboardContainer /> */}
    </Switch>
  </>
);

export default DashboardScreen;
