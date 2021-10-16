import * as React from 'react';
import { Switch, Route } from 'react-router-dom';
import routes from '../../../../../../../../../../../routes';

import ImmovableDashboard from './components/ImmovableDashboard';
import ImmovableFields from './components/ImmovableFields';

const GeneratorContainer = () => (
  <main className="immovable">
    <Switch>
      <Route {...routes.factory.lines.immovable.sections.immovables.immovableView}>
        <ImmovableFields />
      </Route>
      <ImmovableDashboard />
    </Switch>
  </main>
);

export default GeneratorContainer;
