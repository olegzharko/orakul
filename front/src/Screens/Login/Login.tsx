import * as React from 'react';
import { Switch, Route } from 'react-router-dom';
import Authorization from './components/Authorization';
import './index.scss';
import ForgotPassword from './components/ForgotPassword';
import UpdatePassword from './components/UpdatePassword';

const Login = () => (
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
  </main>
);

export default Login;
