import * as React from 'react';
import { Switch, Route } from 'react-router-dom';
import Authorization from './components/Authorization';
import './index.scss';
import ForgotPassword from './components/ForgotPassword';
import UpdatePassword from './components/UpdatePassword';
import Modal from '../../components/Modal';
import { useModal } from '../../components/Modal/useModal';

const LoginScreen = () => {
  const modalProps = useModal();

  return (
    <main className="login">
      <Switch>
        <Route path="/forgot" exact>
          <ForgotPassword />
        </Route>
        <Route path="/update-password/:token">
          <UpdatePassword />
        </Route>
        <Authorization />
      </Switch>
      <Modal {...modalProps} />
    </main>
  );
};

export default LoginScreen;
