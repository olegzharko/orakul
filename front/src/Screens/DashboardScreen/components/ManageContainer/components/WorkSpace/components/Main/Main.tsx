import * as React from 'react';
import './index.scss';
import { useSelector } from 'react-redux';
import { State } from '../../../../../../../../store/types';
import { UserTypes } from '../../../../../../../../types';
import GeneratorMain from './components/GeneratorMain';
import ManagerMain from './components/ManagerMain';
import AssistantMain from './components/Assistant';

const Main = () => {
  const { user: { type } } = useSelector((state: State) => state.main);

  if (type === UserTypes.GENERATOR) {
    return <GeneratorMain />;
  }

  if (type === UserTypes.MANAGER) {
    return <ManagerMain />;
  }

  if (type === UserTypes.ASSISTANT) {
    return <AssistantMain />;
  }

  return null;
};

export default Main;
