import * as React from 'react';
import Immovable from './components/Immovable';
import { DashboardContractNavigation } from '../../../../useDashboardScreen';
import Clients from './components/Clients';
import Seller from './components/Seller';
import SideNotary from './components/SideNotary/SideNotary';

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

  if (props.selectedNav === DashboardContractNavigation.SIDE_NOTARIES) {
    return <SideNotary />;
  }

  return null;
};

export default WorkSpace;
