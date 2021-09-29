import * as React from 'react';
import { Switch, Route } from 'react-router-dom';

import { MANAGE_CONTAINER_LINK_PREFIX } from '../../../../../../../../constants';

import ClientsDashboard from './components/ClientsDashboard';
import ClientsFields from './components/ClientsFields';

const GeneratorContainer = () => (
  <Switch>
    <Route path={`${MANAGE_CONTAINER_LINK_PREFIX}/clients/:clientId/:personId`}>
      <ClientsFields />
    </Route>
    <ClientsDashboard />
  </Switch>
);

export default GeneratorContainer;
