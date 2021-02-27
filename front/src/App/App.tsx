import React from 'react';
import './App.css';
import { useApp } from './useApp';
import Calendar from '../Screens/Calendar';

const App: React.FC = () => {
  useApp();

  return <Calendar />;
};

export default App;
