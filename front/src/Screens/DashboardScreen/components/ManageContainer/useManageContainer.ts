import { useParams } from 'react-router-dom';
import { useState, useEffect } from 'react';
import { DashboardContractNavigation } from '../../useDashboardScreen';

export const useManageContainer = () => {
  const { type } = useParams<{ type: string }>();
  const [selectedNav, setSelectedNav] = useState<DashboardContractNavigation>();
  const [contractData, setContractData] = useState();

  useEffect(() => {
    switch (type) {
      case DashboardContractNavigation.MAIN:
        setSelectedNav(DashboardContractNavigation.MAIN);
        return;
      case DashboardContractNavigation.IMMOVABLES:
        setSelectedNav(DashboardContractNavigation.IMMOVABLES);
        return;
      case DashboardContractNavigation.CLIENTS:
        setSelectedNav(DashboardContractNavigation.CLIENTS);
        return;
      case DashboardContractNavigation.SELLER:
        setSelectedNav(DashboardContractNavigation.SELLER);
        return;
      case DashboardContractNavigation.SIDE_NOTARIES:
        setSelectedNav(DashboardContractNavigation.SIDE_NOTARIES);
        return;
      default:
        setSelectedNav(DashboardContractNavigation.MAIN);
    }
  }, [type]);

  return {
    contractData,
    selectedNav,
    setSelectedNav
  };
};
