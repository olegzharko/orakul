import React from 'react';
import './index.scss';
import { Switch, Route } from 'react-router-dom';
import { useApp } from './useApp';
import SchedulerScreen from '../Screens/SchedulerScreen';
import Login from '../Screens/Login';

const App: React.FC = () => {
  const { type } = useApp();

  if (!type) {
    return <Login />;
  }

  return <SchedulerScreen />;
};

export default App;
