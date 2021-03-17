import React from 'react';
import './index.scss';
import { Switch, Route } from 'react-router-dom';
import { useApp } from './useApp';
import SchedulerScreen from '../Screens/SchedulerScreen';
import Login from '../Screens/Login';

const App: React.FC = () => {
  useApp();

  return (
    <Switch>
      <Route path="/login">
        <Login />
      </Route>
      <Route exact path="/scheduler">
        <SchedulerScreen />
      </Route>
    </Switch>
  );
};

export default App;
