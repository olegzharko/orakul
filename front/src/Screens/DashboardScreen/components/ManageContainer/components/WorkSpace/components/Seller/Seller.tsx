import * as React from 'react';
import './index.scss';
import { Switch, Route } from 'react-router-dom';
import { useSeller } from './useSeller';
import Dashboard from './components/Dashboard';
import Fields from './components/Fields';

const Seller = () => {
  const meta = useSeller();

  return (
    <main className="manage__seller seller">
      <Switch>
        <Route path="/seller/:clientId/:developerId">
          <Fields />
        </Route>
        <Dashboard />
      </Switch>
    </main>
  );
};

export default Seller;
