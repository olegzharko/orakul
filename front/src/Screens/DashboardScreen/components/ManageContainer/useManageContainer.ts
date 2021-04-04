import { useParams, useHistory } from 'react-router-dom';
import { useState, useEffect } from 'react';
import { DashboardContractNavigation } from '../../useDashboardScreen';

export const useManageContainer = () => {
  const history = useHistory();

  const { section, id } = useParams<{ section: string, id: string }>();
  const [selectedNav, setSelectedNav] = useState<DashboardContractNavigation>();
  const [contractData] = useState();

  useEffect(() => {
    switch (section) {
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
  }, [section]);

  useEffect(() => {
    if (Number.isNaN(parseFloat(id))) {
      history.push('/');
    }
  }, [id]);

  return {
    contractData,
    selectedNav,
    setSelectedNav
  };
};
