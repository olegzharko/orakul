import React from 'react';
import { Switch, Route } from 'react-router-dom';

import Header from '../../components/Header';
import routes from '../../routes';

import './index.scss';
import ImmovableFactoryLine from './components/FactoryLines/ImmovableFactoryLine';
import LineItemProcess from './components/LineItemProcess/LineItemProcess';
import FactoryDashboard from './components/FactoryDashboard';

const FactoryScreen = () => (
  <div className="factory-screen">
    <Header />
    <Switch>
      <Route {...routes.factory.processLineItem}>
        <LineItemProcess />
      </Route>

      <Route {...routes.factory.lines.immovable}>
        <ImmovableFactoryLine />
      </Route>

      <FactoryDashboard />
    </Switch>
  </div>
);

export default FactoryScreen;
