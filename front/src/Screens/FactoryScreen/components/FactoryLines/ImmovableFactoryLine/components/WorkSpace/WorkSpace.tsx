import * as React from 'react';

import { ImmovableFactoryLineSections } from '../../../../../../../routes';

import Immovable from './components/Immovable';
import Clients from './components/Clients';
import Seller from './components/Seller';
import SideNotary from './components/SideNotary/SideNotary';
import Main from './components/Main';

type Props = {
  selectedNav?: ImmovableFactoryLineSections
}

const WorkSpace = (props: Props) => {
  if (props.selectedNav === ImmovableFactoryLineSections.main) {
    return <Main />;
  }

  if (props.selectedNav === ImmovableFactoryLineSections.seller) {
    return <Seller />;
  }

  if (props.selectedNav === ImmovableFactoryLineSections.clients) {
    return <Clients />;
  }

  if (props.selectedNav === ImmovableFactoryLineSections.immovables) {
    return <Immovable />;
  }

  if (props.selectedNav === ImmovableFactoryLineSections.sideNotaries) {
    return <SideNotary />;
  }

  return null;
};

export default WorkSpace;
