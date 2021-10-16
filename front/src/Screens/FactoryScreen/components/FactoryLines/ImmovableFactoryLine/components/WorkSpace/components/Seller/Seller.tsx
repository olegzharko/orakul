import * as React from 'react';
import { Switch, Route } from 'react-router-dom';

import routes from '../../../../../../../../../routes';

import './index.scss';
import Dashboard from './components/Dashboard';
import Fields from './components/Fields';

const Seller = () => (
  <main className="manage__seller seller">
    <Switch>
      <Route {...routes.factory.lines.immovable.sections.seller.developerView}>
        <Fields />
      </Route>
      <Dashboard />
    </Switch>
  </main>
);

export default Seller;
