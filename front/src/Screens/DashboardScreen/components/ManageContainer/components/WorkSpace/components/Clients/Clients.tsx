import * as React from 'react';
import { UserTypes } from '../../../../../../../../types';
import GeneratorView from './components/GeneratorContainer';
import { useClients } from './useClients';

const Clients = () => {
  const { type } = useClients();

  if (type === UserTypes.GENERATOR) {
    return <GeneratorView />;
  }

  return null;
};

export default Clients;
