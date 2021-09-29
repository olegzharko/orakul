import * as React from 'react';
import { Switch, Route } from 'react-router-dom';

import { MANAGE_CONTAINER_LINK_PREFIX } from '../../../../../../constants';

import './index.scss';
import { useSeller } from './useSeller';
import Dashboard from './components/Dashboard';
import Fields from './components/Fields';

const Seller = () => {
  const meta = useSeller();

  return (
    <main className="manage__seller seller">
      <Switch>
        <Route path={`${MANAGE_CONTAINER_LINK_PREFIX}/seller/:clientId/:developerId`}>
          <Fields />
        </Route>
        <Dashboard />
      </Switch>
    </main>
  );
};

export default Seller;
