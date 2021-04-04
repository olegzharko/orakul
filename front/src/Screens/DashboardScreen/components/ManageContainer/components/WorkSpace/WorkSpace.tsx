import * as React from 'react';
import Immovable from './components/Immovable';
import { DashboardContractNavigation } from '../../../../useDashboardScreen';
import Clients from './components/Clients';
import Seller from './components/Seller';

type Props = {
  selectedNav?: DashboardContractNavigation
}

const WorkSpace = (props: Props) => {
  if (props.selectedNav === DashboardContractNavigation.SELLER) {
    return <Seller />;
  }

  if (props.selectedNav === DashboardContractNavigation.CLIENTS) {
    return <Clients />;
  }

  if (props.selectedNav === DashboardContractNavigation.IMMOVABLES) {
    return <Immovable />;
  }

  return null;
};

export default WorkSpace;
