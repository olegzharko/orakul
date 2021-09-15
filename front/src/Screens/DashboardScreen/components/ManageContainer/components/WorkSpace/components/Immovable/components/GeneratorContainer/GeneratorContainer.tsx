import * as React from 'react';
import { Switch, Route } from 'react-router-dom';

import { MANAGE_CONTAINER_LINK_PREFIX } from '../../../../../../../../constants';

import ImmovableDashboard from './components/ImmovableDashboard';
import ImmovableFields from './components/ImmovableFields';

const GeneratorContainer = () => (
  <main className="immovable">
    <Switch>
      <Route path={`${MANAGE_CONTAINER_LINK_PREFIX}/immovables/:clientId/:immovableId`}>
        <ImmovableFields />
      </Route>
      <ImmovableDashboard />
    </Switch>
  </main>
);

export default GeneratorContainer;
