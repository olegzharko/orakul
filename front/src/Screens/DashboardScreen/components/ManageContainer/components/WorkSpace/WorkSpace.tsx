import * as React from 'react';
import { DashboardContractNavigation } from '../../../../useDashboardScreen';
import Clients from './components/Clients';
import Seller from './components/Seller';
import { Props, useWorkSpace } from './useWorkSpace';

const WorkSpace = (props: Props) => {
  useWorkSpace(props);

  if (props.selectedNav === DashboardContractNavigation.SELLER) {
    return <Seller />;
  }

  if (props.selectedNav === DashboardContractNavigation.CLIENTS) {
    return <Clients />;
  }

  return null;
};

export default WorkSpace;
