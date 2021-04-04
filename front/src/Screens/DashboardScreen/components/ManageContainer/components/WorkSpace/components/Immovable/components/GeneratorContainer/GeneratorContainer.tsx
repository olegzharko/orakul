import * as React from 'react';
import { Switch, Route } from 'react-router-dom';
import ImmovableDashboard from './components/ImmovableDashboard';
import ImmovableFields from './components/ImmovableFields';

const GeneratorContainer = () => (
  <main className="immovable">
    <Switch>
      <Route path="/immovables/:clientId/immovable/:immovableId">
        <ImmovableFields />
      </Route>
      <ImmovableDashboard />
    </Switch>
  </main>
);

export default GeneratorContainer;
