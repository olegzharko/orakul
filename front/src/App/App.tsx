import React from 'react';
import './index.scss';
import { useApp } from './useApp';
import SchedulerScreen from '../Screens/SchedulerScreen';

const App: React.FC = () => {
  useApp();

  return <SchedulerScreen />;
};

export default App;
