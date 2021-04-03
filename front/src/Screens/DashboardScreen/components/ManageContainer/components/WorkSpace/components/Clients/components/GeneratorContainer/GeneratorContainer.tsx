import * as React from 'react';
import { Switch, Route } from 'react-router-dom';
import ClientsDashboard from './components/ClientsDashboard';

const GeneratorContainer = () => (
  <Switch>
    <Route path="/clients/:clientId/person/:personId">
      <h1>hello</h1>
    </Route>
    <ClientsDashboard />
  </Switch>
);

export default GeneratorContainer;
