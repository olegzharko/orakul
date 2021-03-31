import React from 'react';
import './index.scss';
import { Switch, Route } from 'react-router-dom';
import Header from '../../components/Header';
import DashboardContainer from './components/DashboardContainer';

const DashboardScreen = () => (
  <>
    <Header />
    <Switch>
      <Route path="/contracts/:id">
        <h1>Here</h1>
      </Route>
      <Route path="/">
        <DashboardContainer />
      </Route>
    </Switch>
  </>
);

export default DashboardScreen;
