import * as React from 'react';
import './index.scss';
import { useSelector } from 'react-redux';
import { State } from '../../../../../../../../store/types';
import { UserTypes } from '../../../../../../../../types';
import GeneratorContainer from './components/GeneratorContainer';
import ManagerContainer from './components/ManagerContainer';

const Immovable = () => {
  const { user: { type } } = useSelector((state: State) => state.main);

  if (type === UserTypes.GENERATOR) {
    return <GeneratorContainer />;
  }

  if (type === UserTypes.MANAGER) {
    return <ManagerContainer />;
  }

  return null;
};

export default Immovable;
