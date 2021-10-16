import * as React from 'react';
import { Switch, Route } from 'react-router-dom';

import routes from '../../../../../../../../../../../routes';

import ImmovableDashboard from './components/Dashboard';
import ImmovableFields from './components/Fields';

const ManagerContainer = () => (
  <main className="immovable">
    <Switch>
      <Route {...routes.factory.lines.immovable.sections.immovables.immovableView}>
        <ImmovableFields />
      </Route>
      <ImmovableDashboard />
    </Switch>
  </main>
);

export default ManagerContainer;
