import React from 'react';
import { useSelector } from 'react-redux';
import { Switch, Route } from 'react-router-dom';
import { State } from '../../../../../../../../store/types';
import { UserTypes } from '../../../../../../../../types';
import Dashboard from './components/Dashboard';
import Fields from './components/Fields';

const SideNotary = () => {
  const { user: { type } } = useSelector((state: State) => state.main);

  if (type === UserTypes.GENERATOR) {
    return (
      <Switch>
        <Route path="/side-notaries/:clientId/:notaryId">
          <Fields />
        </Route>
        <Dashboard />
      </Switch>
    );
  }

  return null;
};

export default SideNotary;
