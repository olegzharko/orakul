import * as React from 'react';
import { Switch, Route } from 'react-router-dom';
import Dashboard from './components/Dashboard';
import Fields from './components/Fields';

const ManagerContainer = () => (
  <Switch>
    <Route path="/clients/:clientId/:personId">
      <Fields />
    </Route>
    <Dashboard />
  </Switch>
);

export default ManagerContainer;
