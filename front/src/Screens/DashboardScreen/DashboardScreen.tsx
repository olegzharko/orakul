import React from 'react';
import './index.scss';
import { Switch, Route } from 'react-router-dom';
import Header from '../../components/Header';
import DashboardContainer from './components/DashboardContainer';
import ManageContainer from './components/ManageContainer';

const DashboardScreen = () => (
  <>
    <Header />
    <Switch>
      <Route path="/:id/:section">
        <ManageContainer />
      </Route>
      <DashboardContainer />
    </Switch>
  </>
);

export default DashboardScreen;
