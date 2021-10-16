import * as React from 'react';
import { useSelector } from 'react-redux';

import { State } from '../../../../../../../../../store/types';
import { UserTypes } from '../../../../../../../../../types';

import ManagerContainer from './components/ManagerContainer';
import GeneratorView from './components/GeneratorContainer';

const Clients = () => {
  const { user: { type } } = useSelector((state: State) => state.main);

  if (type === UserTypes.GENERATOR) {
    return <GeneratorView />;
  }

  if (type === UserTypes.MANAGER) {
    return <ManagerContainer />;
  }

  return null;
};

export default Clients;
