import React, { Suspense } from 'react';

import { UserTypes } from '../types';
import Loader from '../components/Loader/Loader';

import './index.scss';
import { useApp } from './useApp';

// Lazy
const VisionScreen = React.lazy(() => import('../Screens/VisionScreen'));
const RegistratorScreen = React.lazy(() => import('../Screens/RegistratorScreen'));
const Dashboard = React.lazy(() => import('../Screens/DashboardScreen'));
const Scheduler = React.lazy(() => import('../Screens/SchedulerScreen'));
const BankUser = React.lazy(() => import('../Screens/BankUserScreen'));
const DeveloperUserScreen = React.lazy(() => import('../Screens/DeveloperUserScreen'));
const Login = React.lazy(() => import('../Screens/LoginScreen'));

const App: React.FC = () => {
  const { type } = useApp();

  if (type === UserTypes.VISION) {
    return (
      <Suspense fallback={<Loader />}>
        <VisionScreen />
      </Suspense>
    );
  }

  if (type === UserTypes.RECEPTION) {
    return (
      <Suspense fallback={<Loader />}>
        <Scheduler />
      </Suspense>
    );
  }

  if (type === UserTypes.REGISTRATOR) {
    return (
      <Suspense fallback={<Loader />}>
        <RegistratorScreen />
      </Suspense>
    );
  }

  if (type === UserTypes.GENERATOR
    || type === UserTypes.ASSISTANT
    || type === UserTypes.MANAGER
  ) {
    return (
      <Suspense fallback={<Loader />}>
        <Dashboard />
      </Suspense>
    );
  }

  if (type === UserTypes.BANK) {
    return (
      <Suspense fallback={<Loader />}>
        <BankUser />
      </Suspense>
    );
  }

  if (type === UserTypes.DEVELOPER) {
    return (
      <Suspense fallback={<Loader />}>
        <DeveloperUserScreen />
      </Suspense>
    );
  }

  return (
    <Suspense fallback={<Loader />}>
      <Login />
    </Suspense>
  );
};

export default App;
