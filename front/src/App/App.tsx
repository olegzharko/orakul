import React from 'react';
import './index.scss';
import { useApp } from './useApp';
import Scheduler from '../Screens/SchedulerScreen';
import Dashboard from '../Screens/DashboardScreen';
import Login from '../Screens/LoginScreen';
import { UserTypes } from '../types';

const App: React.FC = () => {
  const { type } = useApp();

  if (!type) {
    return <Login />;
  }

  if (type === UserTypes.RECEPTION) {
    return <Scheduler />;
  }

  if (type === UserTypes.PRINTER) {
    return <Dashboard />;
  }

  return null;
};

export default App;
