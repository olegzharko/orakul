import * as React from 'react';
import { Switch, Route } from 'react-router-dom';
import Authorization from './components/Authorization';
import './index.scss';
import ForgotPassword from './components/ForgotPassword';
import UpdatePassword from './components/UpdatePassword';
import Modal from '../../components/RequestModal';
import { useRequestModal } from '../../components/RequestModal/useRequestModal';

const LoginScreen = () => {
  const modalProps = useRequestModal();

  return (
    <main className="login">
      <Switch>
        <Route path="/forgot" exact>
          <ForgotPassword />
        </Route>
        <Route path="/password/reset/:token" exact>
          <UpdatePassword />
        </Route>
        <Authorization />
      </Switch>
      <Modal {...modalProps} />
    </main>
  );
};

export default LoginScreen;
