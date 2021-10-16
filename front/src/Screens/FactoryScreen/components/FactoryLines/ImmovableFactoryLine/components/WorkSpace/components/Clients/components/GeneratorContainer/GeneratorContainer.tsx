import * as React from 'react';
import { Switch, Route } from 'react-router-dom';

import routes from '../../../../../../../../../../../routes';

import ClientsDashboard from './components/ClientsDashboard';
import ClientsFields from './components/ClientsFields';

const GeneratorContainer = () => (
  <Switch>
    <Route {...routes.factory.lines.immovable.sections.clients.clientView}>
      <ClientsFields />
    </Route>
    <ClientsDashboard />
  </Switch>
);

export default GeneratorContainer;
