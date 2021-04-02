import * as React from 'react';
import { DashboardContractNavigation } from '../../../../useDashboardScreen';
import Seller from './components/Seller';
import { Props, useWorkSpace } from './useWorkSpace';

const WorkSpace = (props: Props) => {
  useWorkSpace(props);

  if (props.selectedNav === DashboardContractNavigation.SELLER) {
    return <Seller />;
  }

  return null;
};

export default WorkSpace;
