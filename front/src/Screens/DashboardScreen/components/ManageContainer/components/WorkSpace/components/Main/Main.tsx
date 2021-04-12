import * as React from 'react';
import { useSelector } from 'react-redux';
import { State } from '../../../../../../../../store/types';
import { UserTypes } from '../../../../../../../../types';
import GeneratorMain from './components/GeneratorMain';

const Main = () => {
  const { user: { type } } = useSelector((state: State) => state.main);

  if (type === UserTypes.GENERATOR) {
    return <GeneratorMain />;
  }

  return null;
};

export default Main;
