import * as React from 'react';
import { Switch, Route } from 'react-router-dom';
import ClientsDashboard from './components/ClientsDashboard';
import ClientsFields from './components/ClientsFields';

const GeneratorContainer = () => (
  <Switch>
    <Route path="/clients/:clientId/:personId">
      <ClientsFields />
    </Route>
    <ClientsDashboard />
  </Switch>
);

export default GeneratorContainer;
