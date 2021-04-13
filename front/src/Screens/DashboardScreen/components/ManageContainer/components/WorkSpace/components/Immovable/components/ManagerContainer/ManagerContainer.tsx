import * as React from 'react';
import { Switch, Route } from 'react-router-dom';
import ImmovableDashboard from './components/Dashboard';
import ImmovableFields from './components/Fields';

const ManagerContainer = () => (
  <main className="immovable">
    <Switch>
      <Route path="/immovables/:clientId/:immovableId">
        <ImmovableFields />
      </Route>
      <ImmovableDashboard />
    </Switch>
  </main>
);

export default ManagerContainer;
