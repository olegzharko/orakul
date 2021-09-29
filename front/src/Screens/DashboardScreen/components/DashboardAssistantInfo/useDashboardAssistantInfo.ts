import { useCallback, useEffect, useMemo, useState } from 'react';
import { useSelector } from 'react-redux';
import { useHistory } from 'react-router';

import { FilterData, State } from '../../../../store/types';
import { UserTypes } from '../../../../types';
import { DashboardAssistantInfoNavigationLinks } from '../../enums';
import { loadClientCards, loadClientsCardsByContract, onFiltersChangeAction } from './actions';

const assistantInfoRoutes = {
  set: `${DashboardAssistantInfoNavigationLinks.set}`,
  otherActions: `${DashboardAssistantInfoNavigationLinks.otherActions}`,
  reading: `${DashboardAssistantInfoNavigationLinks.reading}`,
  accompanying: `${DashboardAssistantInfoNavigationLinks.accompanying}`
};

export const useDashboardAssistantInfo = () => {
  const history = useHistory();

  const { token, type } = useSelector((state: State) => state.main.user);

  const [isLoading, setIsLoading] = useState<boolean>(true);
  const [navigationValues, setNavigationValues] = useState<any>([]);
  const [accompanying, setAccompanying] = useState<any>();
  const [generator, setGenerator] = useState<any>();
  const [reader, setReader] = useState<any>();

  // Memo
  const cards = useMemo(() => {
    if (type === UserTypes.GENERATOR) {
      switch (history.location.pathname) {
        case assistantInfoRoutes.set:
          return generator;
        case assistantInfoRoutes.reading:
          return reader;
        case assistantInfoRoutes.accompanying:
          return accompanying;
        default:
          return [];
      }
    } else {
      return generator;
    }
  }, [accompanying, generator, history.location.pathname, reader, type]);

  const isNavigationShow = useMemo(() => type === UserTypes.GENERATOR, [type]);

  // Callbacks
  const onFiltersChange = useCallback(async (newFilters: FilterData) => {
    if (!token || !type) return;

    const [generator, reader, accompanying, info] = await onFiltersChangeAction(
      token, newFilters, type, history
    );

    setGenerator(generator);
    setReader(reader);
    setAccompanying(accompanying);
    setNavigationValues(info || []);
  }, [history, token, type]);

  const onContractsFiltersChange = useCallback(async (url: string) => {
    if (!token || !type) return;

    const [
      generator,
      reader,
      accompanying,
      info,
    ] = await loadClientsCardsByContract(token, url, history, type);

    setGenerator(generator);
    setReader(reader);
    setAccompanying(accompanying);
    setNavigationValues(info || []);
  }, [history, token, type]);

  useEffect(() => {
    (async () => {
      if (!token || !type) return;

      const [
        generator,
        reader,
        accompanying,
        info,
      ] = await loadClientCards(token, history, type);

      setGenerator(generator || []);
      setReader(reader || []);
      setAccompanying(accompanying || []);
      setNavigationValues(info || []);
      setIsLoading(false);
    })();
  }, [history, token, type]);

  return {
    isLoading,
    cards,
    isNavigationShow,
    navigationValues,
    onFiltersChange,
    onContractsFiltersChange,
  };
};
