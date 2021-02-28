import React from 'react';
import './App.css';
import { useApp } from './useApp';
import SchedulerScreen from '../Screens/SchedulerScreen';

const App: React.FC = () => {
  useApp();

  return <SchedulerScreen />;
};

export default App;
