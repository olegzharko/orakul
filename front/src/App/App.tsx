import React, { Suspense } from 'react';
import './index.scss';
import { useApp } from './useApp';
import { UserTypes } from '../types';
import Loader from '../components/Loader/Loader';

// Lazy
const RegistratorScreen = React.lazy(() => import('../Screens/RegistratorScreen'));
const Dashboard = React.lazy(() => import('../Screens/DashboardScreen'));
const Scheduler = React.lazy(() => import('../Screens/SchedulerScreen'));
const Login = React.lazy(() => import('../Screens/LoginScreen'));

const App: React.FC = () => {
  const { type } = useApp();

  if (!type) {
    return (
      <Suspense fallback={<Loader />}>
        <Login />
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

  return <h1>You have not access</h1>;
};

export default App;
