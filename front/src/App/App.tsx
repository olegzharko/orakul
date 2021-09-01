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
        <VisionScreen />
        {/* <Scheduler /> */}
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

  return (
    <Suspense fallback={<Loader />}>
      <Login />
    </Suspense>
  );
};

export default App;
