import * as React from 'react';
import { Switch, Route } from 'react-router-dom';

import routes from '../../../../../../../../../../../routes';

import Dashboard from './components/Dashboard';
import Fields from './components/Fields';

const ManagerContainer = () => (
  <Switch>
    <Route {...routes.factory.lines.immovable.sections.clients.clientView}>
      <Fields />
    </Route>
    <Dashboard />
  </Switch>
);

export default ManagerContainer;
