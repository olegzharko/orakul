import * as React from 'react';
import { Switch, Route } from 'react-router-dom';

import { MANAGE_CONTAINER_LINK_PREFIX } from '../../../../../../../../constants';

import Dashboard from './components/Dashboard';
import Fields from './components/Fields';

const ManagerContainer = () => (
  <Switch>
    <Route path={`${MANAGE_CONTAINER_LINK_PREFIX}/clients/:clientId/:personId`}>
      <Fields />
    </Route>
    <Dashboard />
  </Switch>
);

export default ManagerContainer;
