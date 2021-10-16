import { useParams, useHistory } from 'react-router-dom';
import { useState, useEffect } from 'react';

import { isNumber } from '../../../../../utils/numbers';
import { ImmovableFactoryLineSections } from '../../../../../routes';

export const useImmovableFactoryLine = () => {
  const history = useHistory();

  const { section, lineItemId } = useParams<{ section: string, lineItemId: string }>();
  const [selectedNav, setSelectedNav] = useState<ImmovableFactoryLineSections>();
  const [contractData] = useState();

  useEffect(() => {
    switch (section) {
      case ImmovableFactoryLineSections.main:
        setSelectedNav(ImmovableFactoryLineSections.main);
        return;
      case ImmovableFactoryLineSections.immovables:
        setSelectedNav(ImmovableFactoryLineSections.immovables);
        return;
      case ImmovableFactoryLineSections.clients:
        setSelectedNav(ImmovableFactoryLineSections.clients);
        return;
      case ImmovableFactoryLineSections.seller:
        setSelectedNav(ImmovableFactoryLineSections.seller);
        return;
      case ImmovableFactoryLineSections.sideNotaries:
        setSelectedNav(ImmovableFactoryLineSections.sideNotaries);
        return;
      default:
        setSelectedNav(ImmovableFactoryLineSections.main);
    }
  }, [section]);

  useEffect(() => {
    if (!isNumber(lineItemId)) {
      history.push('/');
    }
  }, [history, lineItemId]);

  return {
    contractData,
    selectedNav,
    setSelectedNav
  };
};
