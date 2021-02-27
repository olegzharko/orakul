import React from 'react';
import './App.css';
import { useApp } from './useApp';
import CalendarScreen from '../Screens/Calendar';

const App: React.FC = () => {
  useApp();

  return <CalendarScreen />;
};

export default App;
