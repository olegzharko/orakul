import * as React from 'react';
import { useSelector } from 'react-redux';
import { State } from '../../../../../../../../store/types';
import { UserTypes } from '../../../../../../../../types';
import GeneratorView from './components/GeneratorContainer';

const Clients = () => {
  const { user: { type } } = useSelector((state: State) => state.main);

  if (type === UserTypes.GENERATOR) {
    return <GeneratorView />;
  }

  return null;
};

export default Clients;
